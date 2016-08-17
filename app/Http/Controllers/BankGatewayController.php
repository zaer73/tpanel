<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class BankGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(userRole(Auth::user()) == 'agent'){
            $gateway = \App\BankGateway::whereUserId(Auth::id())->first();
            if(json_decode($gateway->info)){
                return json_decode($gateway->info, true);
            }
        }
        return [
            'gateway' => [
                'username' => config('payment.gateways.mellat.username'),
                'password' => config('payment.gateways.mellat.password'),
                'terminal_id' => config('payment.gateways.mellat.terminal_id')
            ]
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(userRole(Auth::user()) == 'agent'){
            $gateway = \App\BankGateway::firstOrNew([
                'user_id' => Auth::id()
            ]);
            $gateway->bank = 'mellat';
            $gateway->info = json_encode($request->all());
            $gateway->save();
        } elseif(userRole(Auth::user()) == 'admin'){
            config('payment.gateways.mellat.username', $request->username);
            config('payment.gateways.mellat.password', $request->password);
            config('payment.gateways.mellat.terminal_id', $request->terminal_id);
        }
        return [
            'result' => 'success',
            'message' => trans('settings_successful')
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
        //
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
