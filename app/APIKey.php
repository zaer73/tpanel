<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class APIKey extends Model
{
    protected $fillable = ['public_key', 'secret_key'];
}
