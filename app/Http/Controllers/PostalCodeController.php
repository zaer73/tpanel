<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\PostalCode, \App\NumberBank as Bank;
use Auth;

class PostalCodeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    protected $validate_terms = [
        'title' => 'required|max:50|unique:postal_codes,title'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
       if(Auth::user()->cannot('seePostalCodes', new PostalCode)) abort('404');
       $postal_code_ids = Bank::where('city_id', $request->get('city'))->where('postal_code_id', '!=', 0)->lists('postal_code_id');
       $postal_codes = PostalCode::whereIn('id', $postal_code_ids)->get();
       return $postal_codes;
       // return view('postal_codes.index')->with(['postal_codes' => $postal_codes]); 
    }

    public function api(){
        return PostalCode::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createPostalCodes', new PostalCode)) abort('404');
        return view('postal_codes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createPostalCodes', new PostalCode)) abort('403');
        $this->validate($request, $this->validate_terms);
        PostalCode::create($request->all());
        return [
            'result' => 'success',
            'message' => trans('postal_code_created')
        ];
        // return redirect()->route('postal-code.index');
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
        $postal_code = PostalCode::whereId($id)->first();
        if(!$postal_code || Auth::user()->cannot('editPostalCodes', $postal_code)) abort('404');
        return $postal_code;
        // return view('postal_codes.edit')->with(['postal_code' => $postal_code]);
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
        $postal_code = PostalCode::whereId($id)->first();
        if(!$postal_code || Auth::user()->cannot('editPostalCodes', $postal_code)) abort('403');
        $this->validate($request, $this->validate_terms);
        $postal_code->update([
            'title' => $request->title
        ]);
        return [
            'result' => 'success',
            'message' => trans('postal_code_updated')
        ];
        // return redirect()->route('postal-code.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postal_code = PostalCode::whereId($id)->first();
        if(!$postal_code || Auth::user()->cannot('deletePostalCodes', $postal_code)) abort('403');
        $postal_code->delete();
        // return redirect()->route('postal-code.index');
    }
}
