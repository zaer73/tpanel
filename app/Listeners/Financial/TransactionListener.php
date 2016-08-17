<?php

namespace App\Listeners\Financial;

use App\Events\Financial\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionListener
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
        $sign = ($event->sign == 'minus') ? -1 : 1;
        $event->transaction = $event->user->transactions()->create([
            'value' => $sign*$event->value,
            'last_credit' => $event->user->credit ?: 0,
            'type' => $event->type,
            'target_id' => $event->target_id,
            'description' => $event->description,
            'code' => rand(10000000, 99999999)
        ]);
    }
}
