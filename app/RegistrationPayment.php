<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationPayment extends Model
{
    protected $fillable = ['user_id', 'payment_id', 'status', 'plan_id'];
}
