<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BlackList;
use Auth;

class BlackListController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        $user_id = Auth::id();
        return [
            'number' => "required|regex:/[0-9]/|max:25|unique:black_lists,number,NULL,id,user_id,{$user_id},status,0"
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blacklists = Auth::user()->blacklists()->whereStatus(0)->get();
        return $blacklists;
        // return view('blacklists.index')->with(['blacklists' => $blacklists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createBlackList', new BlackList)) abort('404');
        return view('blacklists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createBlackList', new BlackList)) abort('403');
        $this->validate($request, $this->validate_terms());
        Auth::user()->blacklists()->create([
            'number' => $request->number
        ]);
        return [
            'result' => 'success',
            'message' => trans('blacklist_created'),
            'link' => route('blacklist.index')
        ];
        // return redirect()->route('blacklist.index');
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
        $blacklist = BlackList::whereId($id)->whereStatus(0)->first();
        if(!$blacklist || Auth::user()->cannot('editBlackList', $blacklist)) abort('404');
        return $blacklist;
        // return view('blacklists.edit')->with(['blacklist' => $blacklist]);
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
        $blacklist = BlackList::whereId($id)->whereStatus(0)->first();
        if(!$blacklist || Auth::user()->cannot('editBlackList', $blacklist)) abort('403');
        $this->validate($request, $this->validate_terms());
        $blacklist->update([
            'number' => $request->number
        ]);
        return [
            'result' => 'success',
            'message' => trans('blacklist_updated')
        ];
        // return redirect()->route('blacklist.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blacklist = BlackList::whereId($id)->whereStatus(0)->first();
        if(!$blacklist || Auth::user()->cannot('deleteBlackList', $blacklist)) abort('403');
        $blacklist->update([
            'status' => '-1'
        ]);
        // return redirect()->route('blacklist.index');
    }
}
