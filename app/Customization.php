<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    protected $fillable = ['title', 'contact_us', 'logo', 'about_us', 'our_services', 'marketing_code'];
}
