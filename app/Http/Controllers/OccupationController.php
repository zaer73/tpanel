<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Occupation, \App\NumberBank as Bank;
use Auth;

class OccupationController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    protected $validate_terms = [
        'title' => 'required|max:50'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seeOccups', new Occupation)) abort('404');
        $occupation_ids = Bank::where('job_id', '!=', 0)->groupBy('job_id')->lists('job_id');
        $occupations = Occupation::whereIn('id', $occupation_ids)->get();
        return $occupations;
        // return view('occupations.index')->with(['occupations' => $occupations]);
    }

    public function api(){
        return Occupation::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createOccups', new Occupation)) abort('404');
        return view('occupations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createOccups', new Occupation)) abort('403');
        $this->validate($request, $this->validate_terms);

        Occupation::create($request->all());
        return [
            'result' => 'success',
            'message' => trans('occupation_create')
        ];
        // return redirect()->route('occupations.create');
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
        $occupation = Occupation::whereId($id)->first();
        if(!$occupation || Auth::user()->cannot('editOccups', $occupation)) abort('404');
        return $occupation;
        // return view('occupations.edit')->with(['occupation' => $occupation]);
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
        $occupation = Occupation::whereId($id)->first();
        if(!$occupation || Auth::user()->cannot('editOccups', $occupation)) abort('403');
        $this->validate($request, $this->validate_terms);
        $occupation->update(['title' => $request->title]);
        return [
            'result' => 'success',
            'message' => trans('occupation_updated')
        ];
        // return redirect()->route('occupations.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $occupation = Occupation::whereId($id)->first();
        if(!$occupation || Auth::user()->cannot('deleteOccups', $occupation)) abort('403');
        $occupation->delete();
        // return redirect()->route('occupations.index');
    }

    public function getCount($id){
        $range = 5000;
        $count = Bank::select('id')->where('job_id', $id)->count('id');
        $start = 1;
        $ranges = [0 => ''];
        if(count($count) > 0){
            for($i=0;$i<=floor($count/$range);$i++){
                $ranges[$range*($i+1)] = trans('MAX_SENDING_COUNT_RANGE', ['from' => $range*($i)+1, 'to' => $range*($i+1)]);
            }
        }
        return [
            'ranges' => $ranges,
            'max' => $count
        ];
    }
}
