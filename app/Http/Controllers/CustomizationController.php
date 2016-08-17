<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, \App\User, \App\Customization as Custom;
use Redis;

class CustomizationController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private $validation_terms = [
        'title' => 'max:50',
        'contact_us' => 'max:2000',
        'about_us' => 'max:3000',
        'our_services' => 'max:3000',
        'marketing_code' => 'max:3000'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort('404');
    }

    // public function getAboutUs(){
    //     $role = userRole(Auth::user());
    //     if($role == 'admin' || $role == 'agent'){
    //         return Auth::user()->customization['about_us'];
    //     }
    //     return User::find(Auth::user()->agent_id)->customization['about_us'];
    // }

    // public function getContactUs(){
    //     $role = userRole(Auth::user());
    //     if($role == 'admin' || $role == 'agent'){
    //         return Auth::user()->customization['contact_us'];
    //     }
    //     return User::find(Auth::user()->agent_id)->customization['contact_us'];
    // }

    // public function getOurServices(){
    //     $role = userRole(Auth::user());
    //     if($role == 'admin' || $role == 'agent'){
    //         return Auth::user()->customization['our_services'];
    //     }
    //     return User::find(Auth::user()->agent_id)->customization['our_services'];
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort('403');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = str_replace('-', '_', $id);
        return $this->customizations(Auth::user())->{$id};
    }

    private function customizations($user){
        if(userRole($user) == 'admin') return $user->customization;
        $admin = User::whereRole(2)->first();
        if($user->role == 1 && $user->parent == 0){
            return $admin->customization;
        }
        $agent = ($user->parent == 0) ? $admin : User::select('id')->whereId($user->parent)->first();
        return $agent->customization;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $custom = Custom::whereUserId($id)->first();
        if(!$custom) $custom = $this->firstTime($id);
        if(Auth::user()->cannot('showCustom', $custom)) abort('404');
        return $custom;
        // return view('customization.edit')->with(['id' => $id]);
    }

    private function firstTime($id){
        $user = Auth::user();
        if(isAdmin($user) || (isAgent($user) && $user->id == $id)){
            return $user->customization()->create([]);
        }
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
        $custom = Custom::whereUserId($id)->first();
        if(!$custom || Auth::user()->cannot('showCustom', $custom)) abort('403');
        $this->validate($request, $this->validation_terms);
        $to_save = array_intersect_key($request->all(), $this->validation_terms);
        $custom->update($to_save);
        return [
            'result' => 'success', 
            'message' => trans('customization_updated')
        ];
        // return redirect()->route('customization.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadLogo(Request $request)
    {
        $this->validate($request, [
            'uplaodFile' => 'max:1000'
        ]);
        $path = public_path().'/img/uploads';
        if(!file_exists($path)){
            mkdir($path);
        }
        $filename = 'logo-'.time().'.'.$request->file('uploadfile')->getClientOriginalExtension();
        $request->file('uploadfile')->move($path, $filename);
        Custom::whereUserId(Auth::id())->first()->update([
            'logo' => $filename
        ]);
        return [
            'result' => 'success', 
            'message' => trans('settings_successful')
        ];
    }

}
