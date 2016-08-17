<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ContactGroup;
use Auth;

class ContactGroupController extends Controller
{


    private function validate_terms($is_edit=false){
        $user_id = Auth::id();
        $unique = (!$is_edit) ? "|unique:contact_groups,title,NULL,id,user_id,{$user_id}" : '';
        return [
            'title' => "required|max:50".$unique,
            'description' => 'max:250'
        ];
    }

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
        $groups = Auth::user()->contact_groups()->where('status', 0)->with(['contacts'])->get();
        return $groups;
        // return view('contacts.groups.index')->with(['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createGroup', new ContactGroup)) abort('404');
        return view('contacts.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createGroup', new ContactGroup)) abort('403');
        $this->validate($request, $this->validate_terms());
        Auth::user()->contact_groups()->create($request->all());
        return [
            'result' => 'success',
            'message' => trans('contact_group_created'),
            'reset' => true
        ];
        // return redirect()->route('contacts.groups.index');
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
        $group = ContactGroup::whereId($id)->first();
        if(!$group || Auth::user()->cannot('editContactGroup', $group)) abort('404');
        return $group;
        // return view('contacts.groups.edit')->with(['group' => $group]);
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
        $group = ContactGroup::whereId($id)->first();
        if(!$group || Auth::user()->cannot('editContactGroup', $group)) abort('403');
        $this->validate($request, $this->validate_terms(true));
        $group->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        return [
            'result' => 'success',
            'message' => trans('contact_group_updated')
        ];
        // return redirect()->route('contacts.groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = ContactGroup::whereId($id)->first();
        if(!$group || Auth::user()->cannot('deleteContactGroup', $group)) abort('403');
        $group->update(['status' => '-1']);
    }
}
