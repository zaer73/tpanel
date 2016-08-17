<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MarketingCode as Code;
use Auth;

class MarketingCodeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        $user_id = Auth::id();
        // return [
        //     'code' => 'required|max:15|unique:marketing_codes,code',
        //     'user_credit' => 'required|regex:/[0-9]/|max:8',
        //     'client_credit' => 'required|regex:/[0-9]/|max:8',
        //     'user_id' => "required|numeric|exists:users,id,parent,{$user_id}"
        // ];
        return [
            'marketer_credit' => 'required|numeric',
            'signing_up_credit' => 'required|numeric'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seeCodes', new Code)) abort('404');
        if(userRole(Auth::user()) == 'user'){
            $marketing_codes = Auth::user()->marketingCodes;
            if(!$marketing_codes) $marketing_codes = $this->createNewCode();
            return $marketing_codes;
        } elseif(userRole(Auth::user()) == 'agent') {
            $policies = Auth::user()->marketingCodePolicies;
            if(!$policies) $policies = $this->createPolicy();
            return $policies;
        }
        return \App\MarketingCode::with([
            'agent' => function($query){
                $query->select('id', 'name');
            }, 
            'user' => function($query){
                $query->select('id', 'name');
            }
        ])->get();
        // $children = Auth::user()->children()->lists('id')->toArray();
        // $codes = Code::whereIn('user_id', $children)->get();
        // return view('marketing_codes.index')->with(['codes' => $codes]);
    }

    public function createNewCode(){
        $policy = \App\MarketingCodePolicy::where('user_id', Auth::user()->agent_id)->first();
        if(!$policy) {
            $s_credit = $n_credit = \App\AdminSetting::whereKey('marketing_code_credit')->first()->value;
        } else {
            $s_credit = $policy->signing_up_credit;
            $n_credit = $policy->marketer_credit;
        }
        return Auth::user()->marketingCodes()->create([
            'agent_id' => Auth::user()->agent_id,
            'code' => str_random(8),
            'user_credit' => $s_credit,
            'client_credit' => $n_credit
        ]);
    }

    public function createPolicy(){
        $s_credit = $n_credit = \App\AdminSetting::whereKey('marketing_code_credit')->first()->value;
        return Auth::user()->marketingCodePolicies()->create([
            'signing_up_credit' => $s_credit,
            'marketer_credit' => $n_credit
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createCode', new Code)) abort('404');
        return view('marketingCodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createCode', new Code)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $code = Code::create($request->all());
        $code->agent_id = Auth::id();
        $code->save();
        return redirect()->route('marketing-codes.index');
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
        $code = Code::whereId($id)->first();
        if(Auth::user()->cannot('editCode', $code)) abort('404');
        return view('marketing_codes.edit')->with(['code' => $code]);
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
        // $code = Code::whereId($id)->first();
        // if(Auth::user()->cannot('editCode', $code)) abort('403');
        // $terms = $this->validate_terms();
        // unset($terms['code']);
        // $this->validate($request, $terms);
        // $to_save = array_intersect_key($request->all(), $terms);
        // $code->update($to_save);
        // return redirect()->route('marketing-codes.edit', ['id' => $id]);
        // 
        $policy = Auth::user()->marketingCodePolicies;
        if(!$policy || Auth::user()->cannot('editPolicy', $policy)) abort('403');
        $terms = $this->validate_terms();
        $to_save = array_intersect_key($request->all(), $terms);
        Auth::user()->marketingCodePolicies()->update($to_save);
        \App\MarketingCode::whereAgentId(Auth::id())->update([
            'user_credit' => $request->marketer_credit,
            'client_credit' => $request->signing_up_credit
        ]);
        return [
            'result' => 'success',
            'message' => trans('marketing_code_updated')
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
        $code = Code::whereId($id)->first();
        if(Auth::user()->cannot('deleteCode', $code)) abort('403');
        $code->delete();
        return redirect()->route('marketing-codes.index');
    }
}
