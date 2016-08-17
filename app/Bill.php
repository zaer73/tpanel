<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['number', 'bank_name', 'bank_code', 'value', 'description'];

    public function getCreatedAtAttribute($created_at)
    {
    	return Jalali::stampToDate($created_at, 'Y-m-d H:i:s');
    }
}
