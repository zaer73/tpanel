<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Autoreply;
use Auth;

class AutoreplyController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        $poll = new PollController;
        $line_validation = $poll->lineValidation();
        return [
            'title' => 'required|max:50',
            'line_id' => "required|{$line_validation}",
            'condition_text' => "required_if:condition_type,2",
            'condition_type' => 'required|in:1,2',
            'reaction_type' => 'required|in:1,2,3',
            'reaction_text' => 'required_if:reaction_type,3',
            'reaction_group' => 'required_if:reaction_type,1,reaction_type,2'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $autoreplies = Auth::user()->autoreplies()->where('status', '!=', '-2')->with(
            [
                'line' => function($query){
                    $query->select('number', 'id');
                }, 
                'group' => function($query){
                    $query->select('title', 'id');
                }
            ]
        )->get();
        return $autoreplies;
        // return view('autoreplies.index')->with(['autoreplies' => $autoreplies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PollController $pollController)
    {
        if(Auth::user()->cannot('createAutoreply', new Autoreply)) abort('404');
        $lines = $pollController->getLines();
        $groups = Auth::user()->contact_groups()->where('status', '>=', 0)->get();
        // return view('autoreplies.create')->with(['lines' => $lines, 'groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createAutoreply', new Autoreply)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        Auth::user()->autoreplies()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('autoreply_created'),
            'reset' => true,
            'link' => redirect()->route('autoreplies.index')
        ];
        // return redirect()->route('autoreplies.index');
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
        $autoreply = Autoreply::whereId($id)->where('status', '!=', '-2')->first();
        if(!$autoreply || Auth::user()->cannot('editAutoreply', $autoreply)) abort('404');
        return $autoreply;
        // $pollController = new PollController;
        // $lines = $pollController->getLines();
        // $groups = Auth::user()->contact_groups()->where('status', '>=', 0)->get();
        // return view('autoreplies.edit')->with(['autoreply' => $autoreply, 'lines' => $lines, 'groups' => $groups]);
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
        $autoreply = Autoreply::whereId($id)->whereStatus(0)->first();
        if(!$autoreply || Auth::user()->cannot('editAutoreply', $autoreply)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $autoreply->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('autoreply_updated'),
            'link' => route('autoreplies.edit', ['id' => $id])
        ];
        // return redirect()->route('autoreplies.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $autoreply = Autoreply::whereId($id)->whereStatus(0)->first();
        if(!$autoreply || Auth::user()->cannot('deleteAutoreply', $autoreply)) abort('403');
        $autoreply->update(['status' => '-1']);
        // return redirect()->route('autoreplies.index');
    }

    public function enable($id){
        $autoreply = Autoreply::whereId($id)->whereStatus('-1')->first();
        if(!$autoreply || Auth::user()->cannot('enableAutoreply', $autoreply)) abort('403');
        $autoreply->update(['status' => '0']);
        // return redirect()->route('autoreplies.index');
    }

    public function trash($id)
    {
        $autoreply = Autoreply::whereId($id)->first();
        if(!$autoreply || Auth::user()->cannot('trashAutoreply', $autoreply)) abort('403');
        $autoreply->update(['status' => '-2']);
        // return redirect()->route('autoreplies.index');
    }
}
