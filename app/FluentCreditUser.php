<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FluentCreditUser extends Model
{
    protected $fillable = ['ceil', 'fee', 'group_hash'];
}
