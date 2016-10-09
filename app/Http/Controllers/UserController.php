<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Events\User\UserDeleted;
use App\User;
use Auth, Validator, Hash;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(isAdmin(Auth::user())){
            $users = User::DataTable(function ($where) {
                $where->where('status', '!=', '-2');
            },[
                'parentUser' => function($query){
                    $query->select('name', 'id', 'parent', 'username');
                }, 'plan' => function($query){
                    $query->select('expires_at', 'id', 'user_id');
                }
            ]);

            return $users;
        }
        if(isAgent(Auth::user())){
            
            $users = User::DataTable(function ($where) {
                $where->where('status', '!=', '-2')->where('parent', Auth::id());
            },[
                'parentUser' => function($query){
                    $query->select('name', 'id', 'parent', 'username');
                }, 'plan' => function($query){
                    $query->select('expires_at', 'id', 'user_id');
                }
            ]);

            return $users;
        }
        if(count($users) < 1) return;
        // $users = $users->toArray();
        $return = [];
        foreach($users as $user){
            $online_status = online_status($user);
            $user = $user->toArray();
            $user['online_status'] = $online_status;
            array_push($return, $user);
        }
        return $return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.signup');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, GuestController $guest)
    {
        if($request->type == 0){ // user is Haghighi
            $guest->storeTypeZero($request);
        } elseif($request->type == 1){ // user is Hoghooghi
            $guest->storeTypeOne($request);
        } else { // user type is not correct
            \App::abort('403');
        }  
        $toSave = $request->all();
        if ($request->type == 0) {
            $toSave['name'] = $request->first_name . ' ' . $request->last_name;
            $toSave['role'] = ($request->role == 1) ? 1 : 0;
        }
        if($request->has('credit')){
            if($request->credit > Auth::user()->credit && userRole(Auth::user()) != 'admin'){
                return [
                    'result' => 'exception',
                    'errors' => trans('credit_not_enough')
                ];
            }
        }
        if($request->has('line')){
            $role = userRole(Auth::user());
            if($role == 'admin'){
                if(\App\Line::whereUserId('0')->whereAgentId('0')->whereId($request->line)->count('id') < 1){
                    return [
                        'result' => 'exception',
                        'errors' => trans('line_not_available')
                    ];
                }
            } elseif($role == 'agent'){
                if(\App\Line::whereUserId('0')->whereAgentId(Auth::id())->whereId($request->line)->count('id') < 1){
                    return [
                        'result' => 'exception',
                        'errors' => trans('line_not_available')
                    ];
                }
            }
        }
        if($request->role == 0){
            if(Auth::user()->role != 2 && Auth::user()->permissions->user_limit == 0){
                return [
                    'result' => 'exception',
                    'errors' => trans('user_limit_exceeded')
                ];
            } else {
                if(Auth::user()->permissions->user_limit != -1){
                    Auth::user()->permissions->update([
                        'user_limit' => Auth::user()->permissions->user_limit-1
                    ]);
                }
            }
        } elseif($request->role == 1){
            if(Auth::user()->role != 2 && Auth::user()->permissions->agent_limit == 0){
                return [
                    'result' => 'exception',
                    'errors' => trans('user_limit_exceeded')
                ];
            } else {
                if(Auth::user()->permissions->agent_limit != -1){
                    Auth::user()->permissions->update([
                        'agent_limit' => Auth::user()->permissions->agent_limit-1
                    ]);
                }
            }
        }
        $toSave['parent'] = Auth::id();
        if(Auth::user()->role == 1 && $toSave['role'] == 0){
            $toSave['agent_id'] = Auth::id();
        }
        $toSave['status'] = 1;
        $user = User::create($toSave);
        if($request->has('plan')){
            $service = \App::make(\App\Services\PlanChooserService::class);
            $service->set($request->plan, $user->id);
        } else {
            $user->permissions()->create([]);
        }
        $user->apikey()->create([
            'public_key' => str_random(25),
            'secret_key' => str_random(30)
        ]);
        if($request->has('line')){
            if(userRole($user) == 'user'){
                \App\Line::whereId($request->line)->update(['user_id' => $user->id]);
            } elseif(userRole($user) == 'agent'){
                \App\Line::whereId($request->line)->update(['agent_id' => $user->id]);
            }
        }
        return [
            'result' => 'success',
            'message' => trans('user_successful_create'),
            'reset' => true
        ];
        // return redirect()->intented('homepage');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::select([
            'first_name', 'last_name', 'name', 'mobile', 'national_code', 'link_first_name', 'link_last_name', 'submit_code', 'role', 'domain', 'parent', 'email', 'id', 'date_of_birth', 'birth_day', 'birth_year', 'birth_month'
            ])->findOrFail($id);
        if(
            Auth::user()->role == 2 
            || ( Auth::user()->role == 1 && $user->parent == Auth::id() )
        )
        {
            return $user;
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::whereId($id)->first();
        $user->status = -2;
        $user->save();
        event(new UserDeleted($user));
    }

    /**
     * logout page
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogOut(){
        Auth::user()->last_logout = date('Y-m-d H:i:s');
        Auth::user()->save();
        Auth::logout();
        return redirect()->route('users.login');
    }

    public function loginBy($id){
        $user = User::whereId($id)->first();
        if(!$user || Auth::user()->cannot('loginForUser', $user)) abort('404');
        Auth::loginUsingId($id);
        return redirect()->route('users.index');
    }

    public function toggleStatus(Request $request, $id){
        $user = User::whereId($id)->first();
        $status = ($user->status == 0) ? '-1' : '0';
        $user->status = $status;
        $user->save();
    }

    public function toggleRole(Request $request, $id){
        $user = User::whereId($id)->first();
        $role = ($user->role == 0) ? 'agent' : 'user';
        $user->role = $role;
        $user->save();
    }

    public function RegistrationPayment(FinancialController $FinancialController)
    {
        $gateways = $FinancialController->getGateways();
        return view('users.registration-payment')->with(compact('gateways'));
    }

}
