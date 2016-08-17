<?php

namespace App\Listeners\Financial;

use App\Events\Financial\CreditChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreditChangedListener
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
     * @param  CreditChanged  $event
     * @return void
     */
    public function handle(CreditChanged $event)
    {
        $credit = $event->user->credit;
        $new_credit = $credit + $event->type*$event->value;
        $event->user->update(['credit' => $new_credit]);
    }
}
