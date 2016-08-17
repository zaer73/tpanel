<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['title', 'text', 'answer', 'priority', 'supervisor_id', 'code', 'status'];

    protected $appends = ['create_date', 'condition', 'ticket_priority'];

    public function getCreateDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali($created_at);
    }

    public function getConditionAttribute(){
    	$answer = $this->attributes['answer'];
    	$status = $this->attributes['status'];
    	if($status == -1) return trans('ticket_canceled');
    	if(!$answer) return trans('ticket_pending_answer');
    	return trans('ticket_answered');
    }

    public function getTicketPriorityAttribute(){
        $priority = $this->attributes['priority'];
        if($priority == 1) return trans('high');
        if($priority == 2) return trans('medium');
        return trans('low');
    }
}
