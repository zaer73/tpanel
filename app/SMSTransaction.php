<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSTransaction extends Model
{
    protected $fillable = ['value', 'type', 'last_credit'];

    protected $appends = ['date', 'type_title'];

    public function getDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali($created_at, null, true);
    }

    public function getTypeTitleAttribute(){
    	$type = $this->attributes['type'];
    	return trans('sms_type_'.$type);
    }
}
