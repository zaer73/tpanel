<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Group extends Event
{
    use SerializesModels;

    public $input_id, $text, $numbers, $line, $schedule, $flash;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $numbers, $line, $schedule=null, $flash=false)
    {
        $this->input_id = $input_id;
        $this->text = $text;
        $this->numbers = $numbers;
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
