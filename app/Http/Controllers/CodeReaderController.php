<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CodeReader;
use Auth;

class CodeReaderController extends Controller
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
            'condition_text.0' => "required_if:condition_type,2",
            'condition_text' => '',
            'condition_type' => 'required|in:2',
            'reaction_type' => 'required|in:1,2,3',
            'reaction_text.0' => 'required_if:reaction_type,3',
            'reaction_text' => '',
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
        $codereaders = Auth::user()->codereaders()->where('status', '!=', '-2')->with(
            [
                'line' => function($query){
                    $query->select('number', 'id');
                }, 
                'group' => function($query){
                    $query->select('title', 'id');
                }
            ]
        )->get();
        return $codereaders;
        // return view('codereaders.index')->with(['codereaders' => $codereaders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PollController $pollController)
    {
        if(Auth::user()->cannot('createCodeReader', new CodeReader)) abort('404');
        $lines = $pollController->getLines();
        $groups = Auth::user()->contact_groups()->where('status', '>=', 0)->get();
        return view('codereaders.create')->with(['lines' => $lines, 'groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createCodeReader', new CodeReader)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $to_save['reaction_text'] = json_encode($to_save['reaction_text']);
        $to_save['condition_text'] = json_encode($to_save['condition_text']);
        Auth::user()->codereaders()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('codereader_created'),
            'link' => route('codereaders.index'),
            'reset' => true
        ];
        // return redirect()->route('codereaders.index');
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
        $codereader = CodeReader::whereId($id)->whereStatus(0)->first();
        if(!$codereader || Auth::user()->cannot('editCodeReader', $codereader)) abort('404');
        return $codereader;
        // $pollController = new PollController;
        // $lines = $pollController->getLines();
        // $groups = Auth::user()->contact_groups()->where('status', '>=', 0)->get();
        // return view('codereaders.edit')->with(['codereader' => $codereader, 'lines' => $lines, 'groups' => $groups]);
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
        $codereader = CodeReader::whereId($id)->whereStatus(0)->first();
        if(!$codereader || Auth::user()->cannot('editCodeReader', $codereader)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $to_save['reaction_text'] = json_encode($to_save['reaction_text']);
        $to_save['condition_text'] = json_encode($to_save['condition_text']);
        $codereader->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('codereader_updated'),
            'link' => route('codereaders.edit', ['id' => $id])
        ];
        // return redirect()->route('codereaders.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $codereader = CodeReader::whereId($id)->whereStatus(0)->first();
        if(!$codereader || Auth::user()->cannot('deleteCodeReader', $codereader)) abort('403');
        $codereader->update(['status' => '-1']);
        // return redirect()->route('codereaders.index');
    }

    public function enable($id){
        $codereader = CodeReader::whereId($id)->whereStatus('-1')->first();
        if(!$codereader || Auth::user()->cannot('enableCodeReader', $codereader)) abort('403');
        $codereader->update(['status' => '0']);
        // return redirect()->route('codereaders.index');
    }

    public function trash($id){
        $codereader = CodeReader::whereId($id)->first();
        if(!$codereader || Auth::user()->cannot('trashCodeReader', $codereader)) abort('403');
        $codereader->update(['status' => '-2']);
        // return redirect()->route('codereaders.index');
    }
}
