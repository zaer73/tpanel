<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $fillable, $visible;

	public function __construct(){
		$this->fillable = $this->visible = [
			'sms_on_login',
    		'sms_on_ticket',
    		'sms_balance'
		];
	}

	public function getSmsOnLoginAttribute($val){
		if($val == 1) return true;
	}

	public function getSmsOnTicketAttribute($val){
		if($val == 1) return true;
	}

	public function getSmsBalanceAttribute($val){
		if($val == 1) return true;
	}
}
