<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferToEmail extends Model
{
    protected $fillable = ['number', 'email', 'status'];

    protected $appends = ['create_date'];

    public function getCreateDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali($created_at);
    }
}
