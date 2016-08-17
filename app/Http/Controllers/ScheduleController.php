<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, Cons;

class ScheduleController extends Controller
{

    use \App\Helpers\SMS\NextTimeGenerator;

    private function validate_terms(){
        $repeat = implode(',', array_keys(Cons::schedules()));
        return [
            'title' => 'required|max:35',
            'repeat' => 'required|in:'.$repeat,
            'daterange' => 'required',
            'clock' => 'required_if:repeat,2,3,4,5',
            'week_day' => 'required_if:repeat,3',
            'month_day' => 'required_if:repeat,4,5',
            'month' => 'required_if:repeat,5'
        ];
    }

    private function save($schedule, $request){
        $this->validate($request, $this->validate_terms());
        $start_date = shamsi_to_greg($request->daterange['startDate']);
        $finish_date = shamsi_to_greg($request->daterange['endDate']);
        $schedule->user_id = Auth::id();
        $schedule->type = Cons::schedules()[$request->repeat];
        $schedule->title = $request->title;
        $schedule->day = ($request->month_day) ? $request->month_day : $request->week_day;
        $schedule->clock = $request->clock;
        $schedule->month = $request->month;
        $schedule->start_at = $start_date;
        $schedule->next_time = $this->nextTimeGenerator($start_date, $schedule->type, $schedule->clock, $request->week_day, $request->month_day, $request->month);
        $schedule->finish_at = $finish_date;
        $schedule->inputs = serialize($request->all());
        $schedule->save();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->schedules()->where('status', '!=', '-2')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return [
            'repeats' => Cons::schedules(),
            'week_days' => Cons::week_days(),
            'monthes' => Cons::$monthes
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->save(new \App\Schedule, $request);
        return [
            'result' => 'success',
            'message' => trans('schedule_created_successfully'),
            'reset' => 'true'
        ];
    }

    public function enable(Request $request){
        \App\Schedule::whereUserId(Auth::id())->whereStatus('-1')->update(['status' => 0]);
    }

    public function disable(Request $request){
        \App\Schedule::whereUserId(Auth::id())->whereStatus('0')->update(['status' => -1]);
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
        $schedule = Auth::user()->schedules()->whereId($id)->firstOrFail();
        return unserialize($schedule->inputs);
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
        $schedule = Auth::user()->schedules()->whereId($id)->firstOrFail();
        $this->save($schedule, $request);
        return [
            'result' => 'success',
            'message' => trans('schedule_updated_successfully'),
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
        \App\Schedule::whereUserId(Auth::id())->whereId($id)->update(['status' => -2]);
    }
}
