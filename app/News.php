<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'body', 'target', 'status'];

    public function getCreatedAtAttribute($val){
    	return jalali($val);
    }
}
