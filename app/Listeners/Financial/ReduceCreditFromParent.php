<?php

namespace App\Listeners\Financial;

use App\Events\Financial\CreditChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class ReduceCreditFromParent
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
        
    }
}
