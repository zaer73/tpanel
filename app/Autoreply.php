<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Autoreply extends Model
{
    protected $fillable = ['title', 'line_id', 'condition_text', 'condition_type', 'reaction_type', 'reaction_text', 'reaction_group', 'status'];

    public function line(){
    	return $this->belongsTo('App\Line');
    }

    public function group(){
    	return $this->belongsTo('App\ContactGroup', 'reaction_group', 'id');
    }

    public function getConditionAttribute(){
    	$type = $this->attributes['condition_type'];
    	return condition_type($type);
    }

    public function getReactionAttribute(){
    	$type = $this->attributes['reaction_type'];
    	return reaction_type($type);
    }

    public function getCreateDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali('created_at');
    }

    public function getGroupsAttribute(){
    	return Auth::user()->contact_groups()->where('status', '>=', 0)->get();
    }

    public function getLinesAttribute(){
    	return Auth::user()->lines()->where('status', '>=', 0)->get();
    }

    protected $appends = ['condition', 'reaction', 'create_date', 'groups', 'lines'];
}
