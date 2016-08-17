<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TransferToEmail as Transfer;
use Auth;

class TransferToEmailController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms($is_edit=false){
        $pollController = new PollController;
        $line_validation = $pollController->lineValidation(true);
        $user_id = Auth::id();
        $unique = (!$is_edit) ? "|unique:transfer_to_emails,number,NULL,id,user_id,{$user_id},status,0" : '';
        return [
            'number' => "required|{$line_validation}".$unique,
            'email' => 'required|max:50|email'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers = Auth::user()->transfers()->whereStatus(0)->get();
        return $transfers;
        // return view('transfer_to_email.index')->with(['transfers' => $transfers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createTransfer', new Transfer)) abort('404');
        $pollController = new PollController;
        $already_lines = Auth::user()->transfers()->lists('number')->toArray();
        $lines = $pollController->getLines($already_lines);
        return view('transfer_to_email.create')->with(['lines' => $lines]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createTransfer', new Transfer)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        Auth::user()->transfers()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('transfer_to_email_created'),
            'link' => route('transfer-to-email.index')
        ];
        // return redirect()->route('transfer-to-email.index');
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
        $transfer = Transfer::whereId($id)->first();
        if(!$transfer || Auth::user()->cannot('editTransfer', $transfer)) abort('404');
        $transfered_lines = Auth::user()->transfers()->whereStatus(0)->lists('number')->toArray();
        unset($transfered_lines[array_search($transfer->number, $transfered_lines)]);
        $lines = Auth::user()->lines()->select('number')->whereNotIn('number', $transfered_lines)->get();
        // $pollController = new PollController;
        // $already_lines = Auth::user()->transfers()->lists('number')->toArray();
        // $transfer_line_key = array_search($transfer->number, $already_lines);
        // unset($already_lines[$transfer_line_key]);
        // $lines = $pollController->getLines($already_lines);

        return ['transfer' => $transfer, 'lines' => $lines];
        // return view('transfer_to_email.edit', ['transfer' => $transfer, 'lines' => $lines]);
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
        $transfer = Transfer::whereId($id)->first();
        if(!$transfer || Auth::user()->cannot('editTransfer', $transfer)) abort('403');
        $this->validate($request, $this->validate_terms(true));
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $transfer->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('transfer_to_email_updated'),
        ];
        // return redirect()->route('transfer-to-email.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transfer = Transfer::whereId($id)->first();
        if(!$transfer || Auth::user()->cannot('deleteTransfer', $transfer)) abort('403');
        $transfer->delete();
        // return redirect()->route('transfer-to-email.index');
    }
}
