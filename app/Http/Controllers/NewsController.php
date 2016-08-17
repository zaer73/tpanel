<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use \App\News;

class NewsController extends Controller
{

    private $validation_terms = [
        'title' => 'required|max:250',
        'body' => 'required|max:3000',
        'target' => 'required|in:0,1',
        'status' => 'in:0,1'
    ];

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(userRole(Auth::user()) == 'user'){
            return News::whereTarget('0')->whereUserId(Auth::user()->parent)->get();
        }
        if( userRole(Auth::user()) == 'agent' ){
            if( Auth::user()->parent == 0 )
            {
                return News::whereUserId( admin_id() )->whereTarget(1)->get();
            } 

            return News::whereUserId( Auth::user()->parent )->whereTarget(1)->get();
        }
        return News::whereUserId(Auth::id())->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(Auth::user()->cannot('createNews', new News)) abort('404');
        return view('news.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if(Auth::user()->cannot('createNews', new News)) abort('403');
        $this->validate($request, $this->validation_terms);
        Auth::user()->news()->create($request->all());
        return [
            'result' => 'success',
            'message' => trans('news_created_successfully'),
            'reset' => true
        ];
        // return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new = News::whereId($id)->first();
        if(!$new || Auth::user()->cannot('editNews', $new)) abort('404');
        return $new;
        // return view('news.edit')->with(['new' => $new]);
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
        // if(Auth::user()->cannot('editNews', New News)) abort('403');
        $new = News::whereId($id)->first();
        if(!$new) abort('403');
        $this->validate($request, $this->validation_terms);
        $to_save = array_intersect_key($request->all(), $this->validation_terms);
        $new->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('news_updated_successfully')
        ];
        // return redirect()->route('news.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new = News::whereId($id)->first();
        if(!$new) abort('403');
        $new->delete();
        // return redirect()->route('news.index');
    }
}
