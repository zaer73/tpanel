<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
    	'title',
		'type',
		'line_id',
		'started_at',
		'finished_at',
		'question',
		'answer',
		'reply',
		'status'
    ];

    public function getStartDateAttribute(){
    	$started_at = $this->attributes['started_at'];
    	return jalali($started_at);
    }

    public function getFinishDateAttribute(){
    	$finished_at = $this->attributes['finished_at'];
    	return jalali($finished_at);
    }

    public function getTypeNameAttribute(){
    	$type = $this->attributes['type'];
    	if($type == 1) return trans('poll');
    	return trans('contest');
    }

    public function getStartedAtAttribute($started_at){
    	return jalali($started_at, 'Y-m-d H:i:s');
    }

    public function getFinishedAtAttribute($finish_date){
    	$time = strtotime($finish_date);
    	if($time < 0) return '';
    	return date('Y-m-d', strtotime($finish_date));
    }

    public function getAnswersAttribute(){
        if(!json_decode($this->attributes['answer'])){
            return [$this->attributes['answer']];
        }
        return json_decode($this->attributes['answer']);
    }

    public function getAnswerAttribute(){
        if(!json_decode($this->attributes['answer'])){
            return [$this->attributes['answer']];
        }
        return json_decode($this->attributes['answer']);
    }

    protected $appends = ['type_name', 'start_date', 'finish_date', 'answers'];

    public function answers(){
        return $this->hasMany('App\PollAnswer');
    }

    public function setStartedAtAttribute($val){
        $this->attributes['started_at'] = shamsi_to_greg($val);
    }

    public function setFinishedAtAttribute($val){
        $this->attributes['finished_at'] = shamsi_to_greg($val);
    }
}
