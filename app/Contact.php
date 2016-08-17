<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['group_id', 'name', 'number', 'trashed', 'description'];

    public function group(){
    	return $this->belongsTo('\App\ContactGroup', 'group_id', 'id');
    }
}
