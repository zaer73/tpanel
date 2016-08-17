<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\PreTextGroup as Group;
use Auth;

class PreTextGroupController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        return [
            'title' => 'required|max:50'
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seeGroups', new Group)) abort('404');
        $groups = Auth::user()->pre_text_groups()->whereStatus(0)->get();
        return $groups;
        // return view('pretexts.groups.index')->with(['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createGroup', new Group)) abort('404');
        return view('pretexts.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validate_terms());
        Auth::user()->pre_text_groups()->create($request->all());
        return [
            'result' => 'success',
            'message' => trans('pre_text_group_created')
        ];
        // return redirect()->route('pre-texts.group.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $group = Group::whereId($id)->whereStatus(0)->first();
        if(!$group || Auth::user()->cannot('editGroup', $group)) abort('404');
        return $group;
        // return view('pretexts.groups.edit')->with(['group' => $group]);
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
        if(!$group || Auth::user()->cannot('editGroup', $group)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $group->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('pre_text_group_updated_successfully')
        ];
        // return redirect()->route('pre-texts.group.edit', ['id' => $id]);
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
        // if(!$group || Auth::user()->cannot('deleteGroup', $group)) abort('403');
        $group->update(['status' => -1]);
        // return redirect()->route('pre-texts.group.index');
    }
}
