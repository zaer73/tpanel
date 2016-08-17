<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class International extends Event
{
    use SerializesModels;

    public $input_id, $text, $numbers, $schedule, $flash, $request, $line_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $line_id, $numbers, $schedule, $flash=false, $request)
    {
        $this->input_id = $input_id;
        $this->text = $text;
        $this->numbers = $numbers;
        $this->flash = $flash;
        $this->schedule = $schedule;
        $this->request = $request;
        $this->line_id = $line_id;
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
