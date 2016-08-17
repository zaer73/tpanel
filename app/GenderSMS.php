<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\GenderSMSService as Gender;
use jalali;

class GenderSMS extends Model
{
    protected $table = 'gender_s_m_s';

    protected $fillable = ['canceled'];

    protected $appends = ['status'];

    public function getCreatedAtAttribute($created_at){
    	return jalali($created_at);
    }

    public function getStatusAttribute(){
    	$gender = \App::make(Gender::class);
    	return $gender->getStatus($this->attributes['returnId']);
    }
}
