<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Occupation extends Event
{
    use SerializesModels;

    public $input_id, $text, $occupation, $line_id, $schedule, $request, $flash;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $line_id, $occupation, $schedule, $request, $flash=false)
    {
        $this->input_id = $input_id;
        $this->text = $text;
        $this->line_id = $line_id;
        $this->schedule = $schedule;
        $this->occupation = $occupation;
        $this->request = $request;
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
