<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $hidden = ['email', 'token'];

    public $timestamps = false;
}
