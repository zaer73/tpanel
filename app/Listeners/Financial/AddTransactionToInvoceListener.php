<?php

namespace App\Listeners\Financial;

use App\Events\Financial\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddTransactionToInvoceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Transaction  $event
     * @return void
     */
    public function handle(Transaction $event)
    {
        $active_invoice = $event->user->invoices()->where('status', 0)->first();
        if(!$active_invoice){
            $active_invoice = $event->user->invoices()->create([]);
        }
        $active_invoice->value = $active_invoice->value + $event->transaction->value;
        $active_invoice->save();
        $event->user->invoiceTransactionConnection()->create([
            'transaction_id' => $event->transaction->id,
            'invoice_id' => $active_invoice->id,
        ]);
    }
}
