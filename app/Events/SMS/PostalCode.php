<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostalCode extends Event
{
    use SerializesModels;

    public $input_id, $text, $postal_code, $line_id, $schedule, $request, $flash;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $line_id, $postal_code, $schedule, $request, $flash=false)
    {
        $this->input_id = $input_id;
        $this->text = $text;
        $this->line_id = $line_id;
        $this->schedule = $schedule;
        $this->postal_code = $postal_code;
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
