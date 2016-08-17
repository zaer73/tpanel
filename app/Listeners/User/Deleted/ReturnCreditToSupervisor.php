<?php

namespace App\Listeners\User\Deleted;

use App\Events\User\UserDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Events\CreditTransformed;

class ReturnCreditToSupervisor
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
     * @param  UserDeleted  $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        if( !$event->user->parent ) return;
        $credit = $event->user->credit;
        $supervisor = User::find($event->user->parent);
        event(new CreditTransformed(
            $event->user->id, 
            $supervisor->id,
            $event->user->credit,
            $event->user->credit,
            $supervisor->credit
        ));
        $supervisor->credit += $credit;
        $supervisor->save();
        
    }
}
