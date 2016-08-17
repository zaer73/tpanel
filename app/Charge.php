<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $fillable = ['code', 'credit', 'expires_at', 'expired', 'value'];

    protected $appends = ['create_date', 'expiration_date', 'expired_bool'];

    public function getCreateDateAttribute(){
        $created_at = $this->attributes['created_at'];
        return jalali($created_at);
    }

    public function getExpirationDateAttribute(){
        $expires_at = $this->attributes['expires_at'];
        return jalali($expires_at);
    }

    public function getExpiredBoolAttribute(){
        return $this->attributes['expired'];
    }

    public function getExpiredAttribute($expired){
        return ($expired) ? trans('yes') : trans('no');
    }

    public function setExpiresAtAttribute($val){
        $this->attributes['expires_at'] = shamsi_to_greg($val);
    }
}
