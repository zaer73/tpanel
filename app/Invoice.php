<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['value', 'status'];

    protected $appends = ['abs_value'];

    public function transactionsConnections(){
    	return $this->hasMany('\App\InvoiceTransactionConnection');
    }

    public function getAbsValueAttribute(){
    	return abs($this->attributes['value']);
    }
}
