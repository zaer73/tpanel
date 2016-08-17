<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redis, Auth, Session;

class AdminController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
		$this->middleware('admin', ['except' => [
            'getGoBack'
        ]]);
	}

	public $validation_terms = [
        'uploadfile' => 'mimes:jpeg,bmp,png|max:1000',
        'about_us' => 'max:3000'
	];

    public function uploadLogo(Request $request){
        $this->validate($request, $this->validation_terms);
        $path = public_path().'/img/uploads';
        if(!file_exists($path)){
            mkdir($path);
        }
        $filename = 'logo-'.time().'.'.$request->file('uploadfile')->getClientOriginalExtension();
        $request->file('uploadfile')->move($path, $filename);
        \App\AdminSetting::where('key', 'logo')->first()->update([
            'value' => $filename
        ]);
        $redis = Redis::connection();
        $redis->delete('admin_settings');
    }

    public function getInfo(){
        return setting();
    }

    public function update(Request $request){
        $this->validate($request, $this->validation_terms);
        foreach($request->all() as $setting_key => $setting_value){
            $setting = \App\AdminSetting::where('key', $setting_key)->first();
            if(!$setting) continue;
            $setting->update([
                'value' => $setting_value
            ]);
        }
        $lang = \App\AdminSetting::where('key', 'site_lang')->first();
        if($lang){
            $conf = config(['app.locale' => $lang->value]);
            $languageController = app(LanguageController::class);
            $languageController->generateJS();
;        }
        $redis = Redis::connection();
        $redis->delete('admin_settings');
        $this->getInfo();
        return [
            'result' => 'success',
            'message' => trans('admin_settings_updated')
        ];
    }

    public function getLoginToUser($id){
        Session::put('adminLoginBy', Auth::id());
        Auth::loginUsingId($id);
        return redirect('/');
    }

    public function getGoBack()
    {
        if( !Session::has('adminLoginBy') ) abort(403);
        Auth::loginUsingId( Session::get('adminLoginBy') );
        Session::forget('adminLoginBy');
        return redirect('/');
    }
}
