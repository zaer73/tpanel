<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class City extends Event
{
    use SerializesModels;

    public $input_id, $text, $line_id, $province, $city, $schedule, $request;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $line_id, $province, $city, $schedule, $request)
    {
        $this->input_id = $input_id;
        $this->text = $text;
        $this->line_id = $line_id;
        $this->province = $province;
        $this->city = $city;
        $this->schedule = $schedule;
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
