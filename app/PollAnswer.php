<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollAnswer extends Model
{
    public function replies(){
    	return $this->hasOne('App\ReceivedSMS', 'id', 'reply_id');
    }

    public function user(){
    	return $this->belongsTo('App\User')->select('username', 'id');
    }
}
