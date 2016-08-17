<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class FluentCreditController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function validate_terms($update=false){
        $min = 1;
        if(userRole(Auth::user())){
            $min = \App\FluentCredit::whereGroupId(Auth::user()->fluent_group_id)->min('fee');
        }
        $unique = ($update) ? '' : '|unique:fluent_credits,ceil,NULL,id,user_id,'.Auth::id().',status,0';
        return [
            'ceil' => 'required|numeric|min:10000|max:10000000'.$unique,
            'fee' => 'required|numeric|min:'.$min,
            'group_id' => 'required'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->fluentCredits()->with(['group'])->get();
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
        Auth::user()->fluentCredits()->create($request->all());
        return [
            'result' => 'success',
            'message' => trans('fluent_credit_created'),
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
        $user = \App\User::findOrFail($id);
        $result = [];
        if($user->custom_fluent_group){
            $result['custom'] = \App\FluentCreditUser::whereGroupHash($user->custom_fluent_group)->get();
        }
        $result['group'] = $user->fluent_group_id;
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fluent_credit = Auth::user()->fluentCredits()->whereId($id)->firstOrFail();
        return $fluent_credit;
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
        $this->validate($request, $this->validate_terms(true));
        Auth::user()->fluentCredits()->whereId($id)->update($request->all());
        return [
            'result' => 'success',
            'message' => trans('fluent_credit_updated')
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
        Auth::user()->fluentCredits()->whereId($id)->update(['status' => '-1']);
    }

    public function getForUser(){
        if(Auth::user()->custom_fluent_group){
            $fluent_credits = \App\FluentCreditUser::whereGroupHash(Auth::user()->custom_fluent_group)->lists('fee', 'ceil');
        } else {
            $fluent_credits = \App\FluentCredit::whereGroupId(Auth::user()->fluent_group_id)->lists('fee', 'ceil');
        }
        return $fluent_credits;
    }
}
