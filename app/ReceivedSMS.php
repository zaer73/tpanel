<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivedSMS extends Model
{
    protected $table = 'received_s_m_s';

    protected $fillable = ['status'];

    public function getCreatedAtAttribute($date){
    	return jalali($date, '', true);
    }

    public function contact(){
    	return $this->belongsTo('\App\Contact', 'from', 'number')->select('number', 'id', 'user_id', 'group_id', 'name')->limit(10);
    }
}
