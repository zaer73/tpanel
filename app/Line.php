<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
	protected $fillable = ['number', 'value', 'status', 'user_id', 'agent_id', 'user_expires_at', 'agent_expires_at', 'general', 'rahyab', 'notifier'];

    public function agent(){
    	return $this->hasOne('\App\User', 'id', 'agent_id');
    }

    public function user(){
    	return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function getAgentExpiresAtAttribute($value){
    	return jalali($value);
    }

    public function getUserExpiresAtAttribute($value){
    	return jalali($value);
    }

    public function receivers(){
        return $this->hasOne('\App\SMSReceiver');
    }

    public function setExpiresAtAttribute($val){
        $this->attributes['expires_at'] = shamsi_to_greg($val);
    }

    public function setAgentExpiresAtAttribute($val){
        $this->attributes['agent_expires_at'] = shamsi_to_greg($val);
    }

    public function setUserExpiresAtAttribute($val){
        $this->attributes['user_expires_at'] = shamsi_to_greg($val);
    }
}
