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
    	$messages = Auth::user()->sms()->selectRaw('count(group_hash) as amount')->where('trashed', 0)->orderBy('id', 'desc')->get();
        return $messages;
    	// return view('sms.report.index')->with(['messages' => $messages]);
    }

    public function received(){
    	$messages = Auth::user()->received;
        return $messages;
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
        Auth::user()->received()->whereId($id)->delete();
    }

}
