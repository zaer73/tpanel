<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $appends = ['contact'];

    public function getContactAttribute(){
    	$user_id = $this->attributes['user_id'];
    	return \App\User::select('name')->whereId($user_id)->first()->name;
    }
}
