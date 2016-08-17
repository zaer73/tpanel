<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrashedSMS extends Model
{
    protected $table = 'trashed_s_m_s';

    protected $fillable = ['sms_id', 'type', 'text', 'status', 'trashed'];

    public function getCreatedAtAttribute($date){
    	return jalali($date);
    }

    public function getTrashTypeAttribute(){
    	return trashed_sms_type($this->attributes['type']);
    }

    protected $appends = ['trash_type'];
}
