<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $fillable = ['title', 'description', 'value', 'texts', 'status', 'global'];

    protected $appends = ['type_name', 'create_date'];

    public function getTypeNameAttribute(){
    	$type = $this->attributes['type'];
    	if($type == 1) return trans('special_target_agent');
    	if($type == 2) return trans('special_target_user');
    	return trans('special_target_everybody');
    }

    public function getCreateDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali($created_at);
    }

    public function getGlobalAttribute($global){
    	if($global == 0) return false;
    	return true;
    }

}
