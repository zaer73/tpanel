<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\AddPlanToInvoice;
use App\Policies\PlanPolicy;
use App\User;
use Auth, Validator, Hash, Cons;

class GuestController extends Controller
{

	public function __construct(){
        $this->middleware('guest');
    }

    /**
     * show signup page
     *
     * @return \Illuminate\Http\Response
     */

    public function getSignup(Request $request, $domain=null){
        if(empty($domain)){
            $user = User::select('id')->whereId(admin_id())->first();
        } else {
            $user = User::select('id')->whereDomain($domain)->first();
            if(!$user) abort('404');
        }
        if($request->session()->has('plan')){
            $plan = \App\Plan::whereId(session()->get('plan'))->first();
            return view('users.signup', ['domain' => $domain, 'plan' => $plan]);
        }
        $plans = $user->plans()->where('status', 0)->with(['line', 'permission_groups'])->get();
        $defined_permissions = Cons::$permissions;
    	return view('users.plans')->with(['plans' => $plans, 'defined_permissions' => $defined_permissions, 'domain' => $domain]);
    }

    /**
     * post signup page info
     *
     * @param  $request \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */ 
    public function postSignup(Request $request){
    	if($request->type == 0){ // user is Haghighi
            $this->storeTypeZero($request);
        } elseif($request->type == 1){ // user is Hoghooghi
            $this->storeTypeOne($request);
        } else { // user type is not correct
            \App::abort('403');
        }  
        $toSave = $request->all();
        if ($request->type == 0) {
            $toSave['name'] = $request->first_name . ' ' . $request->last_name;
        }
        $user = User::create($toSave);
        // if($request->session()->has('plan')){
        //     $this->setPlanForUser($user, session('plan'));
        // }
        $user->contact_groups()->create(['title' => 'General']);
        $user->apikey()->create([
            'public_key' => str_random(25),
            'secret_key' => str_random(30)
        ]);
        $user->registration_payment()->create([
            'plan_id' => session('plan')
        ]);
        Auth::loginUsingId($user->id);
        $api = app(\App\Http\Controllers\APIController::class);
        try{
            $api->sendSignupSMS($user);
        } catch(\Exception $e) {

        }
        $request->session()->forget('plan');
        return redirect()->route('homepage');
    }

    private function setPlanForUser($user, $plan){
        $plan = \App\Plan::whereId($plan)->first();
        (new AddPlanToInvoice($plan, $user))->handle();
        $user->agent_id = $plan->user_id;
        $user->role = $plan->type;
        $user->save();
        // $plan->line()->update(['user_id' => $user->id]);
        // $user->agent_id = $plan->user_id;
        // $user->price_groups_id = $plan->price_groups->id;
        // $user->save();
        // $user->permissions()->create($plan->permission_groups->toArray());
    }

    public function postChoosePlan(Request $request, $domain=null){
        if(empty($domain)){
            $agent = User::select('id')->whereId(admin_id())->first();
        } else {
            $agent = User::select('id')->whereDomain($domain)->first();
            if(!$agent) abort('404');
        }
        $plan_id = $request->plan_id;
        $plan = \App\Plan::whereId($plan_id)->whereUserId($agent->id)->first();
        if(!$plan) abort('403');
        session(['plan' => $plan_id]);
        return redirect()->route('users.signup', ['domain' => $domain]);
    }

    public function changePlan($domain=null){
        session()->forget('plan');
        return redirect()->route('users.signup', ['domain' => $domain]);
    }

    public function storeTypeZero($request){  // function to store Haghighi user info
        $this->validate($request, [
            'first_name' => 'required|max:25',
            'last_name' => 'required|max:25',
            'username' => 'required|alpha_num|max:25|unique:users,username',
            'email' => 'email|max:50|unique:users,email',
            'mobile' => 'required|size:11|regex:/[0-9]/|unique:users,mobile',
            'national_code' => 'required|regex:/[0-9]/|unique:users,national_code|nationalCode',
            'password' => 'required|max:30'
        ]);
        
    }

    public function storeTypeOne($request){ // function to store Hoghooghi user info
        $this->validate($request, [
            'name' => 'required|max:50',
            'submit_code' => 'max:10|regex:/[0-9]/|unique:users,submit_code',
            'link_first_name' => 'required|max:25',
            'link_last_name' => 'required|max:25',
            'username' => 'required|max:25|alpha_num|unique:users,username',
            'email' => 'email|max:50|unique:users,email',
            'mobile' => 'required|size:11|regex:/[0-9]/|unique:users,mobile',
            'national_code' => 'required|regex:/[0-9]/|unique:users,national_code|nationalCode'
        ]);
    }


    /**
     * show login page
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin($agent='tpanel'){
        $agent_info = $this->getAgentInfo($agent);
        return view('users.login')->with($agent_info);
    }

    private function getAgentInfo($agent){
        if($agent != 'tpanel'){
            $user = User::select('id')->whereUsername($agent)->whereRole(1)->first();
            if($user){
                $customization = $user->customization()->select('logo', 'about_us')->first()->toArray();
                return $customization;
            }
        }
        return ['logo' => setting('logo'), 'about_us' => setting('about_us')];
    }

    /**
     * post login page info
     *
     * @param  $request \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */    
    
    public function postLogin(Request $request){
        $this->validate($request, [
            'username' => 'required|max:25|regex:/[a-zA-Z0-9-]/|exists:users,username',
            'password' => 'required|max:50'
        ]);
        if(!Auth::attempt(['username' => $request->username, 'password' => $request->password]) || (\App\User::where('username', $request->username)->first() && !in_array(\App\User::where('username', $request->username)->first()->status, [0,1,2])) ){
            Auth::logout();
            return redirect()
                ->route('users.login')
                ->withErrors([
                'errors' => trans('wrong_user_pass')
            ])
                ->withInput();
        }
        Auth::user()->last_login = date('Y-m-d H:i:s');
        Auth::user()->save();
        Auth::user()->logins()->create([
            'ip' => $request->ip()
        ]);
        $this->smsOnLogin();
        $url = route('homepage');
        if($request->ajax()){
            return response()->json(['result' => 'success', 'url' => $url]);
        }
        return redirect($url);

    }

    /**
     * show reset password page
     *
     * @return \Illuminate\Http\Response
     */
    public function getResetPassword(){
        return view('users.reset_password');
    }

    /**
     * post reset password page
     *
     * @param \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function postResetPassword(Request $request){
        $this->validate($request, [ // validate email user inserted
            'email' => 'required|email|exists:users,email|max:50'
        ]); 
        $new_password = str_random(8); // give the user a random password
        $user = \App\User::whereEmail($request->email)->first();  // grab user info by the email inserted
        event(new \App\Events\Email($request->email, ['password' => $new_password, 'name' => $user->name], 'reset_password', $user->name, 'رمز عبور جدید')); // email to user his/her new password
        $user->password = bcrypt($new_password); // encrypt new password
        $user->save(); // saven user info
        event(new \App\Events\ChangePassword($request->email, $user->password)); // and also create a tiny log from this action
        $url = route('users.login');
        if($request->ajax()){
            return response()->json([
                'result' => 'success',
                'url' => $url
            ]);
        }
        return redirect($url)->with('status', 'Password Changed'); // turn user back to login page
    }

    /**
     * post reset password page for by mobile form 
     *
     * @param \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function postResetPasswordByMobile(Request $request){
        $this->validate($request, [ // validate useranme and mobile number user inserted
            'username' => 'required|alpha_num|exists:users,username|max:25',
            'mobile' => 'required|size:11|regex:/[0-9]/|exists:users,mobile,username,' . $request->username
        ]);
        $new_password = str_random(8); // give the user a random password
        $user = \App\User::whereUsername($request->username)->first(); // grab user info by the username inserted
        event(new \App\Events\SMS\SystemSMS($user->mobile, 'رمز عبور جدید شما: ' . $new_password));
        $user->password = bcrypt($new_password); // encrypt new password
        $user->save(); // saven user info
        event(new \App\Events\ChangePassword($user->email, $user->password)); // and also create a tiny log from this action
        $url = route('users.login');
        if($request->ajax()){
            return response()->json([
                'result' => 'success',
                'url' => $url
            ]);
        }
        return redirect($url)->with('status', 'Password Changed'); // turn user back to login page
    }

    /**
     * show secure login page
     *
     * @return \Illuminate\Http\Response
     */
    public function getSecureLogin(){

        return view('users.secure_login');
    }

    /**
     * post secure login info
     *
     * @param \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function postSecureLogin(Request $request){
        
        $user = User::where(['username' => $request->username])->first();
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:25|alpha_num|exists:users,username',
            'mobile' => 'required|regex:/[0-9]/|max:4'
        ])
        ->after(function($validator) use ($request, $user){
            if(!$user) return;
            if(substr($user->mobile, -4) != $request->mobile){ // check if last four characters of mobile numbers match 
                $validator->errors()->add(trans('mobile'), trans('wrong_secure_mobile'));
                return;
            }
        });

        if($validator->fails()){
            if($request->ajax()){
                return response()->json([
                    'result' => 'fail',
                    'errors' => $validator->errors()->all()
                ]);
            }
            return redirect()
                    ->route('users.secureLogin')
                    ->withErrors($validator)
                    ->withInput();
        }

        event(new \App\Events\SecureLogin($user->id));
        $url = route('users.secureLogin.form');
        if($request->ajax()){
            return response()->json([
                'result' => 'success',
                'url' => $url
            ]);
        }
        return redirect($url);
    }

    /**
     * show secure login form
     *
     * @return \Illuminate\Http\Response
     */
    public function getSecureLoginForm(){
        return view('users.secure_login_form');
    }

    /**
     * post secure login form
     *
     * @param \Illuminate\Http\Request  
     * @return \Illuminate\Http\Response
     */
    public function postSecureLoginForm(Request $request){
        $user = User::where(['username' => $request->username])->first();
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:25|alpha_num|exists:users,username',
            'password' => 'required|max:25'
        ])
        ->after(function($validator) use ($request, $user){
            if(!$user) return;
            $secure_login = $user->secureLogin;
            if(!$secure_login) {
                $validator->errors()->add(trans('username'), trans('no_secure_logins'));
                return;
            }
            if($secure_login->expired == 1 || strtotime($secure_login->expires_at) < time()) {
                $validator->errors()->add(trans('password'), trans('expired_secure_login'));
            }
            if(!Hash::check($request->password, $secure_login->password)){
                $validator->errors()->add(trans('password'), trans('wrong_secure_pass'));
            }
        });

        if($validator->fails()){
            if($request->ajax()){
                return response()->json([
                    'result' => 'fail',
                    'errors' => $validator->errors()->all()
                ]);
            }
            return redirect()
                    ->route('users.secureLogin.form')
                    ->withErrors($validator)
                    ->withInput();
        }
        \App\SecureLogin::find($user->secureLogin->id)->update(['expired' => 1]);
        Auth::loginUsingId($user->id);
        $this->smsOnLogin();
        $url = route('homepage');
        if($request->ajax()){
            return response()->json([
                'result' => 'success',
                'url' => $url
            ]);
        }
        return redirect($url);
    }

    use \App\Helpers\SMS\creditControl;

    private function smsOnLogin(){
        if(Auth::user()->settings()->where('sms_on_login', 1)->count() > 0 && !empty(Auth::user()->mobile) && Auth::user()->credit > 0){
            $system_number = \App\AdminSetting::whereKey('system_number')->first()->value;
            $line = \App\Line::whereNumber($system_number)->first()->id;
            $text = trans('new_login', [
                'date' => jalali(date('Y-m-d H:i:s'), 'Y-m-d'),
                'time' => jalali(date('Y-m-d H:i:s'), 'H:i:s')
            ]);
            $this->controlCredit($line, 'login_sms', [Auth::user()->mobile], $text, false, false, true);
            event(new \App\Events\SMS(0, Auth::user()->mobile, $text, $line, Auth::id()));

        }
    }
}
