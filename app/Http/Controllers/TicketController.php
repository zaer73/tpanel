<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ticket;
use Auth;

class TicketController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        return [
            'title' => 'required|max:50',
            'text' => 'required|max:3000',
            'priority' => 'required|in:1,2,3',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->cannot('seeTickets', new Ticket)) abort('404');
        $role = userRole(Auth::user());
        if($role == 'admin'){
            return [   
                'received' => Ticket::where(function($query){
                    $query->whereSupervisorId(Auth::id())
                        ->orWhere('supervisor_id', 0);
                })->where('status', '!=', '-1')->orderBy('id', 'desc')->get()
            ];
        }
        if($role == 'agent'){
            return [
                'received' => Ticket::whereSupervisorId(Auth::id())->whereStatus('0')->orderBy('id', 'desc')->get(),
                'sent' => Ticket::whereUserId(Auth::id())->orderBy('id', 'desc')->get(),
            ];
        }
        return [
            'sent' => Ticket::whereUserId(Auth::id())->orderBy('id', 'desc')->get()
        ];
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
        if(Auth::user()->cannot('createTicket', new Ticket)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $to_save['code'] = rand(100000, 999999);
        if(userRole(Auth::user()) == 'agent' && Auth::user()->parent == 0){
            $to_save['supervisor_id'] = -1;
        } else {
            $to_save['supervisor_id'] = Auth::user()->parent;
        }
        Auth::user()->tickets()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('ticket_created'),
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
        if(Auth::user()->role == 2){
            $ticket = \App\Ticket::where(function($query){
                $query->whereSupervisorId(Auth::id())
                    ->orWhere('supervisor_id', 0);
            })->whereId($id)->first();
        } elseif(Auth::user()->role == 1){
            $ticket = \App\Ticket::whereSupervisorId(Auth::id())->whereId($id)->first();
        } else {
            $ticket = \App\Ticket::whereUserId(Auth::id())->whereStatus(1)->whereId($id)->firstOrFail();
        }
        if(!$ticket) abort('404');
        return $ticket;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort('404');
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
        $ticket = Ticket::findOrFail($id);
        if(Auth::user()->cannot('answerTicket', $ticket)) abort('404');
        $this->validate($request, [
            'answer' => 'required|max:3000'
        ]);
        $ticket->update([
            'answer' => $request->answer,
            'status' => 1
        ]);
        $this->smsOnAnswer($ticket);
        return [
            'result' => 'success',
            'message' => trans('ticket_answered_successfully')
        ];
    }

    private function smsOnAnswer($ticket){
        $user = \App\User::whereId($ticket->user_id)->first();
        if( $user <= 0 ) return;
        if($user->settings()->where('sms_on_ticket', 1)->count() > 0 && !empty($user->mobile)){
            $system_number = \App\AdminSetting::whereKey('system_number')->first()->value;
            $line = \App\Line::whereNumber($system_number)->first()->id;
            event(new \App\Events\SMS(0, $user->mobile, trans('new_answer_to_ticket'), $line, $user->id, 'ticket'));
        }
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

    public function cancel($id){
        $ticket = Ticket::findOrFail($id);
        if(Auth::user()->cannot('cancelTicket', $ticket)) abort('404');
        $ticket->update(['status' => '-1']);
    }

    public function getDashboard()
    {
        return Ticket::whereUserId(Auth::id())->orderBy('id', 'desc')->take(2)->get();
    }
}
