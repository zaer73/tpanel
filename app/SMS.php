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

    protected $appends = ['sms_status', 'sms_type', 'selectBox', 'amount', 'actions', 'numbers'];

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

    public function getSelectBoxAttribute()
    {
        return '<input type="checkbox" id="selectAllRows">';
    }

    public function getAmountAttribute()
    {
        $count = $this->where('group_hash', $this->group_hash)->count();

        if ($count == 0) return 1;
    }

    public function getNumbersAttribute()
    {
        if ($this->reciever == 0) {
            '<a href="" ng-click="showGroupMessages(message.group_hash)">'.trans('NUMBERS').'</a>';
        }
        return '<span>'.$this->reciever.'</span>';
    }

    public function getActionsAttribute()
    {
        return '<a href="" ng-click="resend('.$this->queue_name.', '.$this->input_id.')">
                                    <i class="fa fa-send"></i>
                                </a>
                                <a href="" ng-click="delete(0,'.$this->id.')">
                                    <i class="fa fa-remove"></i>
                                </a>'; 
    }
}
