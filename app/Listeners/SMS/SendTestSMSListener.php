<?php

namespace App\Listeners\SMS;

use App\Events\SMS\SendTestSMS;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class SendTestSMSListener
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
     * @param  SendTestSMS  $event
     * @return void
     */
    public function handle(SendTestSMS $event)
    {
        event(new \App\Events\SMS('', $event->receiver, $event->text, $event->line, Auth::id(), '', '', 'testSMS', false, $event->brand));
    }
}
