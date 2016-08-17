<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    protected $fillable = ['plan_id', 'expires_at'];

    public function getExpiresAtAttribute($expires_at){
    	return jalali($expires_at);
    }
}
