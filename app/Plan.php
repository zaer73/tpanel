<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	protected $fillable = ['title', 'description', 'line_id', 'fluent_credit_group', 'permission_group', 'value', 'status', 'init_credit', 'expires_at', 'type'];

    public function line(){
    	return $this->hasMany('App\Line', 'id', json_decode('line_id'));
    }

    public function fluentCreditGroup(){
    	return $this->hasOne('App\FluentCreditGroup', 'id', 'fluent_credit_group');
    }

    public function permission_groups(){
    	return $this->hasOne('App\PermissionGroup', 'id', 'permission_group');
    }

    protected $appends = ['create_date'];

    public function getCreateDateAttribute(){
        $created_at = $this->attribute['created_at'];
        return jalali($created_at);
    }

    public function getLineIdAttribute(){
        $line_id = $this->attributes['line_id'];
        if(json_decode($line_id)){
            $line_ids = json_decode($line_id);
            if(!is_array($line_ids)) $line_ids = [$line_ids];
            return \App\Line::whereIn('id', $line_ids)->get();
        }
        return \App\Line::whereId($line_id)->first();
    }

    public function setExpiresAtAttribute($val){
        $this->attributes['expires_at'] = shamsi_to_greg($val);
    }

}
