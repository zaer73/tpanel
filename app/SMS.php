<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
	protected $table = 's_m_s';

    protected $fillable = ['reciever', 'text', 'scheduled_on', 'status', 'type', 'trashed', 'group_hash', 'input_id', 'queue_name', 'sender'];

    public function getCreatedAtAttribute($date){
    	return jalali($date, '', true);
    }

    public function getSmsStatusAttribute(){
    	return sms_status($this->attributes['status'], $this->attributes['trashed']);
    }

    public function getRecieverAttribute($reciever){
        return (isset($this->attributes['count']) && $this->attributes['count'] > 1) ? 0 : $reciever;
    }

    public function getSmsTypeAttribute(){
        $type = (isset($this->attributes['count']) && $this->attributes['count'] > 1) ? 1 : 0;
    	return sms_type($type);
    }

    protected $appends = ['sms_status', 'sms_type'];

    public function user(){
        return $this->belongsTo('\App\User')->select('username', 'name', 'id');
    }

    public function setScheduledOnAttribute($val){
        $this->attributes['scheduled_on'] = shamsi_to_greg($val);
    }

    public function line()
    {
        return $this->belongsTo('App\Line', 'sender', 'id');
    }
}
