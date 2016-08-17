<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $fillable = ['ip'];

    protected $appends = ['date'];

    public function getDateAttribute(){
    	return jalali($this->attributes['created_at'], 'd F Y H:i:s');
    }
}
