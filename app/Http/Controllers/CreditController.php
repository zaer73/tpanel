<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\User;
use Auth, Validator;

class CreditController extends Controller
{

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
        abort('404');
    }

    public function api($id){
        $user = User::whereId($id)->first();
        return ['credit' => $user->credit];
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
        abort('404');
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
        $user = User::whereId($id)->first();
        if(!$user || Auth::user()->cannot('editCredit', $user)) abort('404');
        return view('users.credit.edit')->with(['user' => $user]);
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
        $user = User::whereId($id)->first();
        if(!$user || Auth::user()->cannot('editCredit', $user)){
            return [
                'result' => 'exception',
                'errors' => 'error'
            ];
        }

        $validate = Validator::make($request->all(), [
            'credit' => 'required|regex:/[0-9]/'
        ])
        ->after(function($validate) use ($request, $user){
            if(
                isAgent(Auth::user()) 
                && ($request->credit - $user->credit) > Auth::user()->credit
            ) {
                $validate->errors()->add(trans('credit'), trans('credit_not_enough'));
            }
        });

        if($validate->fails()){
            return [
                'result' => 'fail',
                'errors' => $validate->errors()->all()
            ];
            // return redirect()
            //         ->route('users.credit.edit', ['id' => $user->id])
            //         ->withErrors($validate)
            //         ->withInput();
        }
        $creditBalance = $request->credit - $user->credit;
        $giver_balance = Auth::user()->credit;
        $getter_balance = $user->credit;
        Auth::user()->credit = Auth::user()->credit - $creditBalance;
        Auth::user()->save();
        $user->credit = $request->credit;
        $user->save();
        event(new \App\Events\CreditTransformed(Auth::id(), $user->id, $creditBalance, $giver_balance, $getter_balance));
        return [
            'result' => 'success',
            'message' => trans('credit_successfully_changed')
        ];
        // return redirect()->route('users.credit.edit', ['id' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
