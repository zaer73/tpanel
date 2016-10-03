<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SMS;
use Auth;

class SMSReportController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
    	// $messages = Auth::user()->sms()->selectRaw('count(group_hash) as amount')->where('trashed', 0)->orderBy('id', 'desc')->with(['line'])->get();
        $dataTable = \Yajra\Datatables\Facades\Datatables::usingEloquent(
            SMS::where([
                'trashed' => 0,
                'user_id' => auth()->id()
            ])->with(['line'])
        )->make(true);
        return $dataTable;
    	// return view('sms.report.index')->with(['messages' => $messages]);
    }

    public function received(){
        $dataTable = \Yajra\Datatables\Facades\Datatables::usingEloquent(
            \App\ReceivedSMS::where('status', '!=', -1)
        )->make(true);
        return $dataTable;
    	// $messages = Auth::user()->received()->where('status', '!=', -1)->get();
     //    return $messages;
    	// return view('sms.report.received')->with(['messages' => $messages]);
    }

    public function trash(){
    	$messages = Auth::user()->trashed()->whereStatus('-1')->get();
        return $messages;
    	// return view('sms.report.trashed')->with(['messages' => $messages]);
    }

    public function getGroup($id){
        return Auth::user()->inGroupSMS()->where('group_hash', $id)->get();
    }

    public function deleteReceived($id){
        Auth::user()->received()->whereId($id)->update(['status' => -1]);
    }

}
