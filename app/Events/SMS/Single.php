<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Single extends Event
{
    use SerializesModels;

    public $input_id, $receiver, $text, $line, $schedule, $flash=false;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $receiver, $line, $schedule=null, $flash=false)
    {
        $this->input_id = $input_id;
        $this->receiver = $receiver;
        $this->text = $text;
        $this->line = $line;
        $this->schedule = $schedule;
        $this->flash = $flash;
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
