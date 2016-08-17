<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{

	protected $role, $maxVal;

	public function __construct(){
		$this->middleware('auth');
		$this->role = userRole(Auth::user());
	}

    public function index(){
    	return [
    		'total_income' => number_format($this->total_income()),
    		'total_messages' => number_format($this->total_messages()),
    		'total_received_messages' => number_format($this->total_received_messages()),
    		'total_users' => number_format($this->total_users()),
    		'messages_chart' => $this->messages_chart(),
    		'messages_chart_max_val' => $this->maxVal,
    		'received' => Auth::user()->received()->with(['contact'])->limit(10)->get(),
    		'latest_messages' => $this->latest_messages()
    	];
    }

    protected function total_income(){
    	if($this->role == 'admin'){
    		return \App\Invoice::select('value')->whereStatus('1')->sum('value');
    	}
    }

    protected function total_messages(){
    	if($this->role == 'admin'){
    		return \App\SMS::select('id')->count('id');
    	}
        return \App\SMS::select('id')->whereUserId(Auth::id())->count('id');
    }

    protected function total_received_messages(){
    	if($this->role == 'admin'){
    		return \App\ReceivedSMS::select('id')->count('id');
    	}
        return \App\ReceivedSMS::select('id')->whereUserId(Auth::id())->count('id');
    }

    protected function total_users(){
    	if($this->role == 'admin'){
    		return \App\User::select('id')->count('id');
    	}
    }

    protected function messages_chart(){
        $role = ($this->role == 'admin') ? 'admin' : 'user';
    	return $this->last_thirty($role);
    	if($this->role == 'admin'){
    		$msgs = \App\SMS::whereRaw("created_at between '{$month_earlier}' and '{$current_date}'")->get();
    	}
    }

    protected function last_thirty($type){
    	$return = [];
    	$vals = [];
    	for($i=30; $i>=0; $i--){
    		$today = date('Y-m-d H:i:s', strtotime("-{$i} day"));
    		$yesterday_i = $i+1;
    		$yesterday = date('Y-m-d H:i:s', strtotime("-{$yesterday_i} day"));
    		$val = $this->{'messages_chart_'.$type}($yesterday, $today);
    		array_push($return, [strtotime($today)*1000, $val]);
    		array_push($vals, $val);
    	}
    	$this->maxVal($vals);
    	return $return;
    }

    protected function messages_chart_admin($yesterday, $today){
    	return \App\SMS::whereRaw("created_at between '{$yesterday}' and '{$today}'")->count('id');
    }

    protected function messages_chart_user($yesterday, $today){
        return \App\SMS::whereUserId(Auth::id())->whereRaw("created_at between '{$yesterday}' and '{$today}'")->count('id');
    }

    protected function maxVal($vals){
    	$this->maxVal = ceil(max($vals)/10)*10;
    }

    protected function latest_messages(){
    	if($this->role == 'admin'){
    		return \App\SMS::select('status', 'created_at', 'user_id', 'trashed', 'type', 'user_id')->orderBy('id', 'desc')->limit(10)->with(['user'])->get()->toArray();
    	}
        return \App\SMS::select('status', 'created_at', 'user_id', 'trashed', 'type', 'user_id')->whereUserId(Auth::id())->orderBy('id', 'desc')->limit(10)->with(['user'])->get()->toArray();
    }
}
