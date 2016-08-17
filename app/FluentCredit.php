<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FluentCredit extends Model
{
    protected $fillable = ['fee', 'ceil', 'status', 'group_id'];
    protected $visible = ['fee', 'ceil', 'id', 'group_id', 'group'];

    public function group(){
    	return $this->belongsTo('App\FluentCreditGroup');
    }

}
