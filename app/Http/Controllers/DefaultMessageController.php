<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class DefaultMessageController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        return [
            'title' => 'required|max:50',
            'text' => 'required|max:500'
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $defaultMessages = Auth::user()->defaultMessages()->whereStatus(0)->get();
        if($request->get('type') != 'directive') return $defaultMessages;
        $preTexts = \App\PreText::whereUserId(supervisor_id(Auth::user()));
        if(Auth::user()->role == 0){
            $preTexts = $preTexts->orWhere('user_id', admin_id());
        }
        $preTexts = $preTexts->with(['group'])->get()->groupBy('group_id');
        return [
            'defaults' => $defaultMessages->all(),
            'preTexts' => $preTexts
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort('404');
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
        Auth::user()->defaultMessages()->create($request->all());
        return [
            'result' => 'success',
            'message' => trans('default_message_created'),
            'reset' => true
        ];
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
        return Auth::user()->defaultMessages()->whereId($id)->whereStatus(0)->firstOrFail();
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
        $this->validate($request, $this->validate_terms());
        Auth::user()->defaultMessages()->whereId($id)->whereStatus(0)->update($request->all());
        return [
            'result' => 'success',
            'message' => trans('default_message_updated')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->defaultMessages()->whereId($id)->whereStatus(0)->update([
            'status' => -1
        ]);
    }
}
