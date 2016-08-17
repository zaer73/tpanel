<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecureLogin extends Model
{
	protected $hidden = ['password', 'expires_at', 'expired', 'user_id'];

	protected $fillable = ['expired'];
}
