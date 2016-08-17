<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Special;
use Auth;

class SpecialController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        return [
            'title' => 'required|max:50',
            'description' => 'max:250',
            'value' => 'required|numeric',
            'texts' => 'required|numeric',
            'global' => 'in:0,1'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seeSpecials', new Special)) abort('404');
        $specials = Auth::user()->specials()->where('status', '!=', '-2')->get();
        return $specials;
        // return view('specials.index')->with(['specials' => $specials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createSpecials', new Special)) abort('404');
        return view('specials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    // if doesnt care who target is type equals to zero
    // if target is agents only type is one
    // if target is users only type is two
    {
        if(Auth::user()->cannot('createSpecials', new Special)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        Auth::user()->specials()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('special_created'),
            'url' => route('specials.index')
        ];
        // return redirect()->route('specials.index');
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
        $special = Special::whereId($id)->whereStatus(0)->first();
        if(!$special || Auth::user()->cannot('editSpecials', $special)) abort('404');
        return $special;
        // return view('specials.edit')->with(['special' => $special]);
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
        $special = Special::whereId($id)->whereStatus(0)->first();
        if(!$special || Auth::user()->cannot('editSpecials', $special)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $special->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('special_updated')
        ];
        // return redirect()->route('specials.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $special = Special::whereId($id)->first();
        if(!$special || Auth::user()->cannot('deleteSpecials', $special)) abort('403');
        $special->update(['status' => '-2']);
        // return redirect()->route('specials.index');
    }

    public function disable($id)
    {
        $special = Special::whereId($id)->whereStatus(0)->first();
        if(!$special || Auth::user()->cannot('disableSpecials', $special)) abort('403');
        $special->update(['status' => '-1']);
        // return redirect()->route('specials.index');
    }

    public function enable($id)
    {
        $special = Special::whereId($id)->whereStatus('-1')->first();
        if(!$special || Auth::user()->cannot('enableSpecials', $special)) abort('403');
        $special->update(['status' => '0']);
        // return redirect()->route('specials.index');
    }
}
