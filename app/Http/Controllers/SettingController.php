<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cons, Auth;

class SettingController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validation_terms(){
        return [ // validate inputs 
            'sms_on_login' => 'boolean',
            'sms_on_ticket' => 'boolean',
            'sms_balance' => 'boolean',
        ];
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->getSettings(); // if user hasn't any setting then create for him/her
        return view('users.settings')->with(['settings' => $settings]); // return blade with settings
    }

    public function api(){
        return $this->getSettings();
    }

    /**
     * Create new default setting for user
     *
     * @return object
     */
    private function getSettings(){
        $settings = Auth::user()->settings;
        if(!$settings){
            $settings = new \App\Setting;
            $settings->user_id = Auth::id();
            foreach(Cons::$default_settings as $key => $value){
                $settings->{$key} = $value;
            }
            $settings->save();
            return Cons::$default_settings;
        }
        return $settings; // return created settings
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $settings = $this->getSettings(); // if user hasn't any setting then create for him/her
        $validation_terms = $this->validation_terms();
        $this->validate($request, $validation_terms);
        $to_save = array_intersect_key($request->all(), $validation_terms);
        if(count($to_save)){
            $settings = Auth::user()->settings;
            foreach($to_save as $key => $value){
                $settings->{$key} = $value;
            }
            $settings->save();
            Auth::user()->settings()->update($to_save);
        }
        return [
            'result' => 'success', 
            'message' => trans('settings_successful')
        ];
    }

}
