<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScheduledMessage extends Event
{
    use SerializesModels;

    public $text, $receivers, $line, $flash, $schedule_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text, $receivers, $line, $flash=false, $schedule_id)
    {
        $this->text = $text;
        $this->receivers = $receivers;
        $this->line = $line;
        $this->flash = $flash;
        $this->schedule_id = $schedule_id;

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
