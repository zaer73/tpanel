<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivedSMS extends Model
{
    protected $table = 'received_s_m_s';

    protected $fillable = ['status'];

    protected $appends = ['select_box', 'forward', 'reply', 'delete'];

    public function getCreatedAtAttribute($date){
    	return jalali($date, '', true);
    }

    public function contact(){
    	return $this->belongsTo('\App\Contact', 'from', 'number')->select('number', 'id', 'user_id', 'group_id', 'name')->limit(10);
    }

    public function getSelectBoxAttribute()
    {
        return '<input type="checkbox" id="selectAllRows">';
    }

    public function getForwardAttribute()
    {
    	return '<a href="" ng-click="forward($event, message)">
            <i class="fa fa-mail-forward"></i>
        </a>';
    }

    public function getReplyAttribute()
    {
    	return '<a href="" ng-click="reply($event, message)">
                                <i class="fa fa-send"></i>
                            </a>';
    }

    public function getDeleteAttribute()
    {
    	return '<a href="" ng-click="delete($event,message.id)">
                                <i class="fa fa-remove"></i>
                            </a>';
    }
}
