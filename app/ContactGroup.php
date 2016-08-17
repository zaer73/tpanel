<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    protected $fillable = ['title', 'description', 'status'];

    public function contacts(){
    	return $this->hasMany('App\Contact', 'group_id', 'id');
    }
}
