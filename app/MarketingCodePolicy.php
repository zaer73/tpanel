<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingCodePolicy extends Model
{
    protected $fillable = ['signing_up_credit', 'marketer_credit'];
}
