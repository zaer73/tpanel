<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\PreText;
use Auth;

class PreTextController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        $user_id = Auth::id();
        return [
            'text' => 'required|max:250',
            'group_id' => "required|exists:pre_text_groups,id,user_id,{$user_id}"
        ];
    }

    public function api(){
        return Auth::user()->pre_text_groups;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seePreTexts', new PreText)) abort('404');
        $pretexts = $this->getPreTexts();
        return $pretexts;
        // return view('pretexts.index')->with(['pretexts' => $pretexts]);
    }

    private function getPreTexts(){
        $user = Auth::user();
        if(isAdmin($user)){
            return PreText::whereStatus(0)->with(['group'])->get();
        }
        return PreText::whereUserId($user->id)->whereStatus(0)->with(['group'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createPreTexts', new PreText)) abort('404');
        $groups = Auth::user()->pre_text_groups;
        
        // return view('pretexts.create')->with(['pre_text_groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createPreTexts', new PreText)) abort('403');
        $this->validate($request, $this->validate_terms());

        Auth::user()->pre_texts()->create($request->all());
        return [
            'result' => 'success',
            'message' => trans('pre_text_created_successfully')
        ];
        // return redirect()->route('pre-texts.index');
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
        $pretext = PreText::whereId($id)->whereStatus(0)->first();
        if(!$pretext || Auth::user()->cannot('editPreTexts', $pretext)) abort('404');
        $groups = Auth::user()->pre_text_groups;
        return $pretext;
        // return view('pretexts.edit')->with(['pretext' => $pretext, 'pre_text_groups' => $groups]);
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
        $pretext = PreText::whereId($id)->whereStatus(0)->first();
        if(!$pretext || Auth::user()->cannot('editPreTexts', $pretext)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $pretext->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('pre_text_updated_successfully')
        ];
        // return redirect()->route('pre-texts.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pretext = PreText::whereId($id)->whereStatus(0)->first();
        if(!$pretext || Auth::user()->cannot('deletePreTexts', $pretext)) abort('403');
        $pretext->update(['status' => '-1']);
        // return redirect()->route('pre-texts.index');
    }
}
