<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Brand extends Event
{
    use SerializesModels;

    public $input_id, $text, $brand, $numbers, $line_id, $schedule, $flash, $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $line_id, $numbers, $brand, $schedule, $flash, $request)
    {
        $this->input_id = $input_id;
        $this->text = $text;
        $this->brand = $brand;
        $this->numbers = $numbers;
        $this->line_id = $line_id;
        $this->schedule = $schedule;
        $this->flash = $flash;
        $this->request = $request;
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
