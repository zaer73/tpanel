<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FluentCreditGroup extends Model
{
    protected $fillable = ['title', 'description'];

    protected $appends = ['children'];

    public function getChildrenAttribute(){
    	$id = $this->attributes['id'];
    	return FluentCredit::whereGroupId($id)->whereStatus(0)->count('id');
    }

    public function fluentCredit(){
    	return $this->hasMany('App\FluentCredit', 'group_id', 'id');
    }
}
