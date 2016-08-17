<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceTransactionConnection extends Model
{
    protected $fillable = ['transaction_id', 'invoice_id'];

    public function transaction(){
    	return $this->hasOne('\App\Transaction', 'id', 'transaction_id');
    }

    public function payment(){
    	return $this->belongsTo('\App\Payment', 'invoice_id', 'invoice_id')->select('RefId', 'id', 'invoice_id');
    }
}
