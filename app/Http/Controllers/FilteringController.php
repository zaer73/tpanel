<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Filtering;
use Auth;

class FilteringController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        return [
            'filtering_key' => 'required|max:15'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seeFilterings', new Filtering)) abort('404');
        $filterings = Auth::user()->filterings;
        return $filterings;
        // return view('filterings.index')->with(['filterings' => $filterings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createFiltering', new Filtering)) abort('404');
        return view('filterings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createFiltering', new Filtering)) abort('403');
        $this->validate($request, $this->validate_terms());
        Auth::user()->filterings()->create([
            'filtering_key' => $request->filtering_key
        ]);
        return [
            'result' => 'success',
            'message' => trans('filtering_created'),
            'link' => route('filterings.index')
        ];
        // return redirect()->route('filterings.index');
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
        $filtering = Filtering::whereId($id)->first();
        if(Auth::user()->cannot('editFiltering', $filtering)) abort('404');
        return $filtering;
        // return view('filterings.edit')->with(['filtering' => $filtering]);
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
        $filtering = Filtering::whereId($id)->first();
        if(Auth::user()->cannot('editFiltering', $filtering)) abort('403');
        $this->validate($request, $this->validate_terms());
        $filtering->update([
            'filtering_key' => $request->filtering_key
        ]);
        return [
            'result' => 'success',
            'message' => trans('filtering_updated')
        ];
        // return redirect()->route('filterings.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filtering = Filtering::whereId($id)->first();
        if(Auth::user()->cannot('deleteFiltering', $filtering)) abort('403');
        $filtering->delete();
        // return redirect()->route('filterings.index');
    }
}
