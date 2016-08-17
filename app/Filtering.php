<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filtering extends Model
{
    protected $fillable = ['filtering_key'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    protected $appends = ['create_date'];

    public function getCreateDateAttribute(){
        $created_at = $this->attribute['created_at'];
        return jalali($created_at);
    }
}
