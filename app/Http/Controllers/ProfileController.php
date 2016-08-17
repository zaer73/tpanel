<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Hash, Auth, Cons;

class ProfileController extends Controller
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
        
    }

    public function update(Request $request, $id=null){
        $id = $id ?: Auth::id();
        \App\User::whereId($id)->update([
            'domain' => $request->domain,
            'email' => $request->email,
            'name' => $request->name,
            'link_first_name' => $request->link_first_name,
            'link_last_name' => $request->link_last_name,
            'mobile' => $request->mobile,
            'national_code' => $request->national_code,
            'submit_code' => $request->submit_code
        ]);
        return [
            'result' => 'success',
            'message' => trans('profile_updated')
        ];
    }

    public function editProfile(Request $request, $id=null){
        // foreach($request->all() as $key => $value){
        //     Auth::user()->{$key} = $value;
        // }
        // Auth::user()->save();
        $user = (empty($id)) ? Auth::user() : \App\User::whereId($id)->first();
        $user->update($request->all());
        return [
            'result' => 'success',
            'message' => trans('profile_updated')
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id, $type)
    {
        if(!in_array($type, ['password', 'birth'])) abort('403'); // if type of request is not correct throw an error
        $validation = $this->{'check_' . $type}($request); // validate inputs with sending them to appropriate function according to their type

        if($validation->fails()){
            // if($request->ajax()){
                return response()->json([
                    'result' => 'fail',
                    'errors' => $validation->errors()->all()
                ]);
            // }
            // return redirect()
            //     ->route('users.profile.index')
            //     ->withErrors($validation)
            //     ->withInput();
        }

        $this->{'save_' . $type}($request, $id); // save data by sending them to appropriate function
        return response()->json(['result' => 'success', 'message' => trans('profile_changed')]);
        // return redirect()->route('users.profile.index')->with('status', trans('password_changed'));
    }

    /**
     * validate values inserted for changing password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Validator $validation
     */
    private function check_password($request){
        $validation = Validator::make($request->all(), [
            'old_password' => 'required|max:50',
            'new_password' => 'required|min:6|max:50',
            'repeat_new_password' => 'required|min:6|max:50|same:new_password'
        ])
        ->after(function($validation) use ($request){
            if(!Hash::check($request->old_password, Auth::user()->password)){ // if old password entered by user is not correct throw an error
                $validation->errors()->add(trans('old_password'), trans('password_mismatch'));
            }
        });
        return $validation;
    }

    /**
     * save new password
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function save_password($request, $id){
        Auth::user()->password = $request->new_password;
        Auth::user()->save();
        event(new \App\Events\ProfilePasswordChanged);
    }

    /**
     * validate values inserted for changing birthday
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Validator $validation
     */
    private function check_birth($request){
        $max_birth = Cons::$max_birth_year; // get maximum available birth year from constants
        $min_birth = Cons::$min_birth_year; // get minimum available birth year from constants
        $validation = Validator::make($request->all(), [
            'birth_day' => 'required|max:31|numeric|min:1',
            'birth_month' => 'required|numeric|min:1|max:12',
            'birth_year' => "required|numeric|min:{$min_birth}|max:{$max_birth}"
        ]);
        return $validation;
    }

    /**
     * save new birth year
     *
     * @param  \Illuminate\Http\Request  $request
     */
    private function save_birth($request, $id){
        $user = ($id) ? \App\User::findOrFail($id) : Auth::user();
        $timestamp = \App\Jalali::toStamp($request->birth_day, $request->birth_month, $request->birth_year); // change date of birth user entered to php well-formatted timestamp
        $user->date_of_birth = $timestamp;
        $user->birth_day = $request->birth_day;
        $user->birth_month = $request->birth_month;
        $user->birth_year = $request->birth_year;
        $user->save();
    }

}
