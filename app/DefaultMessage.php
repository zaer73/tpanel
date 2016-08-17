<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultMessage extends Model
{
    protected $fillable = ['title', 'status', 'text'];
}
