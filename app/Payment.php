<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['invoice_id', 'gateway', 'RefId', 'ResCode', 'saleOrderId', 'SaleReferenceId', 'CardHolderInfo'];
}
