<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Plan;
use Auth;

class PlanController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms($request){
        $lines = \App\Line::whereGeneral('1')->get();
        $availableLines = collect($lines)->pluck('number')->all();
        $requestedLines = collect($request->line_id)->pluck('number')->all();
        if(count(array_filter($requestedLines))){
            $diff = array_diff($requestedLines, $availableLines);
            if(count($diff)){
                die(json_encode([
                    'result' => 'exception',
                    'errors' => 'invalid number'
                ]));
            }
        }
        $user_id = Auth::id();
        return [
            'title' => 'required|max:50',
            'description' => 'max:250',
            'line_id' => '',
            'fluent_credit_group' => "required|exists:fluent_credit_groups,id,user_id,{$user_id}",
            'permission_group' => "required|exists:permission_groups,id,user_id,{$user_id}",
            'value' => 'required|regex:/[0-9]/',
            'init_credit' => 'max:4|regex:/[0-9]/',
            'expires_at' => '',
            'type' => 'required|in:0,1'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Auth::user()->plans()->with(['fluentCreditGroup' => function($query){
            $query->select('title', 'id');
        }, 'permission_groups' => function($query){
            $query->select('title', 'id');
        }])->where('status', '!=', '-2')->get();
        return $plans;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createPlans', new Plan)) abort('404');
        $pollController = new PollController;
        $lines = \App\Line::where('general', 1)->get();
        $fluent_credit_groups = Auth::user()->fluentCreditGroups()->where('status', '0')->get();
        $permission_groups = Auth::user()->permission_groups()->where('status', '0')->get();
        return ['lines' => $lines, 'fluent_credit_groups' => $fluent_credit_groups, 'permission_groups' => $permission_groups];
        // return view('plans.create')->with(['lines' => $lines, 'price_groups' => $price_groups, 'permission_groups' => $permission_groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createPlans', new Plan)) abort('403');
        $this->validate($request, $this->validate_terms($request));
        $to_save = array_intersect_key($request->all(), $this->validate_terms($request));
        $to_save['line_id'] = json_encode(collect($to_save['line_id'])->pluck('id')->all());
        Auth::user()->plans()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('plan_created'),
            'link' => route('plans.index'),
            'reset' => true
        ];
        // return redirect()->route('plans.index');
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
        $plan = Plan::whereId($id)->where('status', '!=', '-2')->first();
        if(!$plan || Auth::user()->cannot('editPlans', $plan)) abort('404');
        $pollController = new PollController;
        $lines = \App\Line::where('general', 1)->get();
        $fluent_credit_groups = Auth::user()->fluentCreditGroups;
        $permission_groups = Auth::user()->permission_groups;
        return ['plan' => $plan, 'lines' => $lines, 'fluent_credit_groups' => $fluent_credit_groups, 'permission_groups' => $permission_groups];
        // return view('plans.edit')->with(['plan' => $plan, 'lines' => $lines, 'price_groups' => $price_groups, 'permission_groups' => $permission_groups]);
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
        $plan = Plan::whereId($id)->where('status', '!=', '-2')->first();
        if(!$plan || Auth::user()->cannot('editPlans', $plan)) abort('403');
        $this->validate($request, $this->validate_terms($request));
        $to_save = array_intersect_key($request->all(), $this->validate_terms($request));
        $to_save['line_id'] = json_encode(collect($to_save['line_id'])->pluck('id')->all());
        $plan->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('plan_updated')
        ];
        // return redirect()->route('plans.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::whereId($id)->first();
        if(!$plan || Auth::user()->cannot('deletePlans', $plan)) abort('403');
        $plan->update(['status' => -2]);
        // return redirect()->route('plans.index');
    }

    public function disable($id)
    {
        $plan = Plan::whereId($id)->where('status', 0)->first();
        if(!$plan || Auth::user()->cannot('deletePlans', $plan)) abort('403');
        $plan->update(['status' => -1]);
        // return redirect()->route('plans.index');
    }

    public function enable($id)
    {
        $plan = Plan::whereId($id)->whereStatus('-1')->first();
        if(!$plan || Auth::user()->cannot('deletePlans', $plan)) abort('403');
        $plan->update(['status' => 0]);
        // return redirect()->route('plans.index');
    }
}
