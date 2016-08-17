<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberBank extends Model
{
    protected $fillable = ['province_id', 'city_id', 'job_id', 'postal_code_id', 'gender', 'number'];

    public function cities(){
    	return $this->belongsToMany('App\City', 'number_banks', 'city_id');
    }

    public function province(){
    	return $this->belongsToMany('App\Province', 'number_banks', 'province_id');
    }

    public function numberProvince(){
    	return $this->belongsTo('App\Province', 'province_id', 'id');
    }

    public function numberCity(){
    	return $this->belongsTo('App\City', 'city_id', 'id');
    }

    public function occupation(){
    	return $this->belongsTo('App\Occupation', 'job_id', 'id');
    }
}
