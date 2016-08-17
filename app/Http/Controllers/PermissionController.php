<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\User;
use \App\Permission;
use Cons;

class PermissionController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private $validateArray;

    public function index(){
        abort('404');
    }

    public function show($id){
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::select('username', 'id')->whereId($id)->with(['permissions'])->first(); //select user with inserted id and take his/her permissions too
        if(!$user) abort('404'); // if id is not correct throw an error
        if(!$user->permissions) {  // if user doesn't have any permission
            $user->permissions = $this->defaultPermission($user); // make him/her a new one
        }

        $permission_groups = \App\PermissionGroup::select('title', 'id')->get();
        return $user->toArray();
        // return view('permissions.user.new')->with(['user' => $user, 'permission_groups' => $permission_groups]);
    }

    private function defaultPermission($user){
        $default = \App\PermissionGroup::first(); // this is default group that should be replaced in the future
        $user->permissions = $user->permissions()->create($default->toArray()); // take all of the fields in the default group and set permissions 
        return $user->permissions; // return user with brand new permissions
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PermissionGroupController $group, $id)
    {
        $group->updateValidationArray($this->validateArray);

        $permissions = \App\Permission::whereUserId($id)->first();
        if(!$permissions) abort('404');

        $this->validate($request, $this->validateArray);
        // dd($request->get('permissions'));
        $to_save = array_intersect_key($request->get('permissions'), array_fill_keys(Cons::$permissions, 1)); // determine if user hasn't checked any of the checkboxes
        // if(count($falses)){
        //     $values = array_fill(0, sizeof($falses), 0); // set an array of zeros with size of $falses
        //     $not_checked = array_combine($falses, $values); // make an array that keys are permission names and values are zeros
        //     $permissions->update($not_checked); // first set not checked permissions
        // }
        // $to_save = $request->get('permissions');
        // $to_save['group'] = 0; // permissions are edited manually. so set the group zero that shows it has a custom permission group
        $permissions->update($to_save); // then set checked permissions
        return [
            'result' => 'success',
            'message' => trans('permission_user_success_edit')
        ];
        // return redirect()->route('permissions.user.edit', ['id' => $id]);

    }

    /**
     * Update user's permissions by pre-defined permission groups
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function groupToUser(Request $request, $id){
        $this->validate($request, [
            'group' => 'required|numeric'
        ]);
        $user = User::select('id')->whereId($id)->first();
        if(!$user) abort('403'); // if user id is not correct throw an error
        $group = \App\PermissionGroup::whereId($request->group)->first(); // get permission group
        if(!$group) abort('403'); // if permission group is not available throw an error
        $to_save = array_intersect_key($group->toArray(), array_flip(Cons::$permissions)); // take necessary fields from permission group ... the fields that are common with Cons::$permissions array
        $to_save['group'] = $group->id; // add group id to intersected array
        $user->permissions()->update($to_save); // update user's permissions 
        return redirect()->route('permissions.user.edit', ['user' => $id]);
    }

}
