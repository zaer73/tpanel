<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditUpgrade extends Model
{
    protected $fillable = ['value', 'payment_id', 'status'];
}
