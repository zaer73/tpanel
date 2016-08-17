<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth, Cons, Session;
use App\Services\GenderSMSService as GenderSerevice;

class APIController extends Controller
{

    use \App\Helpers\API\SMS;

    public function getUserInfo(){
    	return [
            'result' => 'success', 
            'id' => Auth::id(),
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'name' => Auth::user()->name,
            'national_code' => Auth::user()->national_code,
            'submit_code' => Auth::user()->submit_code,
            'email' => Auth::user()->email,
            'mobile' => Auth::user()->mobile,
            'credit' => Auth::user()->credit,
            'date_of_birth' => Auth::user()->date_of_birth,
            'birth_day' => jalali(Auth::user()->date_of_birth, 'd'),
            'birth_month' => jalali(Auth::user()->date_of_birth, 'm'),
            'birth_year' => jalali(Auth::user()->date_of_birth, 'Y'),
            'link_first_name' => Auth::user()->link_first_name,
            'link_last_name' => Auth::user()->link_last_name,
            'domain' => Auth::user()->domain,
            'type' => Auth::user()->type,
            'price_group' => Auth::user()->price_groups_id,
            'agent_id' => Auth::user()->agent_id,
            'role' => userRole(Auth::user()),
            'permissions' => permissions(Auth::user()),
            'allowed' => permissions(Auth::user(), true),
            'adminLoginBy' => Session::get('adminLoginBy'),
            'languages' => $this->getLanguages()
        ];
    }

    private function getLanguages()
    {
        return array_where(scandir(resource_path('lang')), function ($key, $value) {
            return (strstr($value, '.') === FALSE);
        });
    }

    public function getBirthInfo(){
    	$birth_date = Auth::user()->date_of_birth;
    	return [
    		'birth_year' => jalali($birth_date, 'Y'), 
    		'birth_month' => jalali($birth_date, 'm'), 
    		'birth_day' => jalali($birth_date, 'd')
    	];
    }

    public function getUserRole(Request $request){
        $user = User::findOrFail($request->id);
        return userRole($user);
    }

    public function getOperators(){
        return Cons::operators();
    }

    public function getInfo(){
        return Auth::user()->apikey;
    }

    private function saveInput($request){
        $input = new \App\SMSInput;
        $input->inputs = json_encode($request);
        $input->save();
        return $input->id;
    }

    use \App\Helpers\SMS\creditControl;

    public function sendAutoreply(Request $request){
        $line = \App\Line::findOrFail($request->line);
        $user = \App\User::findOrFail($line->user_id);
        $type = ($request->has('type')) ? $request->get('type') : 'auto';
        $totalCost = $this->controlCredit($line->id, $type, [$request->to], $request->text);
        event(new \App\Events\Financial\CreditChanged($totalCost, 'minus', $user->id));
        $sms = $user->sms()->create([
            'input_id' => 0,
            'queue_name' => 'singleSMS',
            'reciever' => $request->to,
            'text' => $request->text,
            'type' => 0,
            'scheduled_on' => '0000-00-00 00:00:00',
            'group_hash' => rand(100000000000000, 999999999999999) 
        ]);
        $this->sendSMS($request->to, $request->text, $line->id, $sms->id, '', 'singleSMS', false, '', '', $user);
        die();
    }

    public function sendSignupSMS($user){
        $line = \App\Line::whereAgentId($user->agent_id)->whereNotifier(1)->first();
        if(!$line) {
            $system_number = \App\AdminSetting::whereKey('system_number')->first()->value;
            $line = \App\Line::whereNumber($system_number)->first()->id;
        }
        $agent = \App\User::whereId($user->agent_id)->first();
        if($agent->credit <= 0) return;
        $text = "اطلاعات ورود به سایت: \n
            نام کاربری: {$user->username}\n
            رمز عبور: رمز انتخابی شما\n
            آدرس سایت: {($agent) ? $agent->domain : ''}";
        $totalCost = $this->controlCredit($line->id, 'auto', [$user->mobile], $text, false, false, true);
        event(new \App\Events\Financial\CreditChanged($totalCost, 'minus', $agent->id));
        $sms = $user->sms()->create([
            'input_id' => 0,
            'queue_name' => 'singleSMS',
            'reciever' => $user->mobile,
            'text' => $text,
            'type' => 0,
            'scheduled_on' => '0000-00-00 00:00:00',
            'group_hash' => rand(100000000000000, 999999999999999) 
        ]);
        $this->sendSMS($user->mobile, $text, $line->id, $sms->id, '', 'singleSMS', false, '', '', $agent);
    }

    public function getAgents(){
        if(Auth::user()->role != 2) abort('403');
        return User::select('id', 'username')->whereRole(1)->get();
    }

    public function getUsers(Request $request){
        if(Auth::user()->role != 2) abort('403');
        return User::select('id', 'username')->whereRole(0)->whereAgentId($request->agent)->get();
    }

    public function getProvinces(GenderSerevice $gender){
        return $gender->getProvinces();
    }

    public function getCities(GenderSerevice $gender, Request $request){
        return $gender->getCities($request->get('province'));
    }

    public function getCount(GenderSerevice $gender, Request $request){
        return $gender->getCount($request);
    }

    public function getAvailableParents($id){
        return [
        'userInfo' => \App\User::select('id', 'parent')->whereId($id)->first(),
        'users' => \App\User::select('username', 'id', 'parent')->whereParent(Auth::id())->get()
        ];
    }

    public function postChangeParent(Request $request){
        \App\User::whereId($request->target)->update([
            'parent' => $request->parent
        ]);
        return [
            'result' => 'success',
            'message' => trans('saved_successfully')
        ];
    }
}
