<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
    protected $fillable = ['number', 'status'];

    public function getCreateDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali($created_at);
    }

    protected $appends = ['create_date'];
}
