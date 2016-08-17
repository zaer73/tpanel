<?php

namespace App\Listeners\SMS;

use App\Events\SMS\Single;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class SendSingleSMS
{
    use \App\Helpers\SMS\creditControl;
    
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
     * @param  Single  $event
     * @return void
     */
    public function handle(Single $event)
    {
        $this->controlCredit($event->line, 'single', [$event->receiver], $event->text);
        event(new \App\Events\SMS($event->input_id, $event->receiver, $event->text, $event->line, Auth::id(), '', $event->schedule, 'singleSMS', $event->flash));
    }
}
