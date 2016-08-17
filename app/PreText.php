<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreText extends Model
{
    protected $fillable = ['text', 'group_id', 'status'];

    public function group(){
    	return $this->belongsTo('\App\PreTextGroup', 'group_id', 'id');
    }
}
