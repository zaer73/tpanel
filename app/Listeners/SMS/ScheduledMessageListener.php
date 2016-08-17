<?php

namespace App\Listeners\SMS;

use App\Events\SMS\ScheduledMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class ScheduledMessageListener
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
     * @param  ScheduledMessage  $event
     * @return void
     */
    public function handle(ScheduledMessage $event)
    {
        \App\ScheduledMessage::create([
            'user_id' => Auth::id(),
            'schedule_id' => $event->schedule_id,
            'text' => $event->text,
            'receivers' => serialize($event->receivers),
            'line_id' => $event->line,
            'flash' => ($event->flash) ? 1 : 0
        ]);
    }
}
