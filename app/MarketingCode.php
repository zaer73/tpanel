<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingCode extends Model
{
    protected $fillable = ['code', 'user_credit', 'client_credit', 'user_id'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function agent(){
    	return $this->belongsTo('App\User', 'agent_id', 'id');
    }
}
