<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledMessage extends Model
{
    protected $fillable = ['text', 'receivers', 'line_id', 'flash', 'schedule_id', 'user_id'];
}
