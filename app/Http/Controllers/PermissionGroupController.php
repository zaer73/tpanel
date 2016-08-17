<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\PermissionGroup as Group;
use Auth,Cons;

class PermissionGroupController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private $validateArray = [ // validation array to check input data
        'title' => 'required|max:50',
        'description' => 'max:250',
        'agent_limit' => 'max:3|regex:/[0-9]/',
        'user_limit' => 'max:3|regex:/[0-9]/',
        'lawyer_limit' => 'max:3|regex:/[0-9]/'
    ];

    public function updateValidationArray(&$array){ // this function makes $validateArray dynamic ... if in the future anything added to Cons::$permissions it'll make it to us easier
        foreach(Cons::$permissions as $permission){
            $array[$permission] = 'boolean';
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Auth::user()->permission_groups()->whereStatus(0)->get();
        // return view('permissions.groups.index')->with(['groups' => $groups]);
        return $groups;
    }

    public function api(){
        return Cons::$permissions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.groups.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->updateValidationArray($this->validateArray);
        $this->validate($request, $this->validateArray);

        Auth::user()->permission_groups()->create($request->all());
        return [
            'result' => 'success',
            'message' => trans('permission_group_success')
        ];
        // return redirect()
        //         ->route('permissions.groups.index')
        //         ->with('status', trans('permission_group_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::whereId($id)->whereStatus(0)->first();
        if(!$group) abort('404');
        return $group;
        // return view('permissions.groups.edit')->with(['group' => $group]);
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
        $group = Group::whereId($id)->whereStatus(0)->first();
        if(!$group) abort('403');
        $this->updateValidationArray($this->validateArray);
        $this->validate($request, $this->validateArray);
        $falses = array_diff(Cons::$permissions, array_keys($request->all())); // determine if user hasn't checked any of the checkboxes
        if(count($falses)){
            $values = array_fill(0, sizeof($falses), 0); // set an array of zeros with size of $falses
            $not_checked = array_combine($falses, $values); // make an array that keys are permission names and values are zeros
            $group->update($not_checked); // first set not checked permissions
        }
        $group->update($request->all());
        return [
            'result' => 'success',
            'message' => trans('permission_group_success_edit')
        ];
        // return redirect()->route('permissions.groups.edit', ['id' => $id])->with('status', trans('permission_group_success_edit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::whereId($id)->whereStatus(0)->first();
        if(!$group) abort('403');
        $group->update(['status' => -1]);
        return [
            'result' => 'success'
        ];
    }
}
