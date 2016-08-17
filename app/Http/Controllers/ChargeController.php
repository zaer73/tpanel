<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Charge;
use Auth;

class ChargeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        return [
            'code' => 'required|max:15|unique:charges,code',
            'credit' => 'required|max:8',
            'expires_at' => '',
            'value' => 'required|numeric'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seeCharges', new Charge)) abort('404');
        $charges = Auth::user()->charges;
        return $charges;
        // return view('charges.index')->with(['charges' => $charges]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(Auth::user()->cannot('createCharge', new Charge)) abort('404');
        // return str_random(8);
        // return view('charges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createCharge', new Charge)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $request->merge(['expires_at' => date('Y-m-d H:i:s', strtotime($request->get('expires_at')))]);
        Auth::user()->charges()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('charge_created'),
            'link' => route('charges.index')
        ];
        // return redirect()->route('charges.index');
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
        $charge = Charge::whereId($id)->first();
        if(Auth::user()->cannot('editCharge', $charge)) abort('404');
        return $charge;
        // return view('charges.edit')->with(['charge' => $charge]);
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
        $charge = Charge::whereId($id)->first();
        if(Auth::user()->cannot('editCharge', $charge)) abort('403');
        $terms = $this->validate_terms();
        unset($terms['code']);
        $this->validate($request, $terms);
        $to_save = array_intersect_key($request->all(), $terms);
        $charge->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('charge_updated'),
        ];
        // return redirect()->route('charges.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $charge = Charge::whereId($id)->first();
        if(Auth::user()->cannot('deleteCharge', $charge)) abort('403');
        $charge->delete();
        return redirect()->route('charges.index');
    }
}
