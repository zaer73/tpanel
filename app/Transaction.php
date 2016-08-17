<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['value', 'description', 'code', 'type', 'target_id', 'status', 'last_credit', 'user_id'];

    protected $appends = ['date', 'type_title', 'abs_value'];

    public function getDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali($created_at, null, true);
    }

    public function getTypeTitleAttribute(){
    	$type = $this->attributes['type'];
    	return trans($type);
    }

    public function getAbsValueAttribute(){
        $value = $this->attributes['value'];
        return abs($value);
    }

    public function invoicesConnections(){
        return $this->belongsTo('\App\InvoiceTransactionConnection', 'id', 'transaction_id')->select('invoice_id', 'transaction_id', 'id');
    }
}
