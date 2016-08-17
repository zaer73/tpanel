<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Faq;
use Auth;

class FaqController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        return [
            'question' => 'required|max:500',
            'answer' => 'required|max:2500'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(Auth::user()->cannot('seeFaqs', new Faq)) abort('404');
        if(Auth::user()->role == 2){
            return Auth::user()->faqs;
        }
        if(Auth::user()->role == 1 || (Auth::user()->role == 0 && Auth::user()->agent_id == 0)){
            return \App\User::find(admin_id())->faqs;
        }
        return \App\User::find(Auth::user()->agent_id)->faqs;
        // return view('faqs.index')->with(['faqs' => $faqs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createFaq', new Faq)) abort('404');
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createFaq', new Faq)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        Auth::user()->faqs()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('faq_created'),
            'link' => route('faqs.index')
        ];
        // return redirect()->route('faqs.index');
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
        $faq = Faq::whereId($id)->first();
        if(Auth::user()->cannot('editFaq', $faq)) abort('404');
        return $faq;
        // return view('faqs.edit')->with(['faq' => $faq]);
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
        $faq = Faq::whereId($id)->first();
        if(Auth::user()->cannot('editFaq', $faq)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $faq->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('faq_updated')
        ];
        // return redirect()->route('faqs.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::whereId($id)->first();
        if(Auth::user()->cannot('deleteFaq', $faq)) abort('403');
        $faq->delete();
        // return redirect()->route('faqs.index');
    }
}
