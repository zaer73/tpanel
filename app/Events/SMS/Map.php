<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Map extends Event
{
    use SerializesModels;

    public $input_id, $text, $selectedRegions, $line_id, $schedule, $request, $flash;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $text, $line_id, $selectedRegions, $schedule, $request, $flash=false)
    {
        $this->input_id = $input_id;
        $this->text = $text;
        $this->line_id = $line_id;
        $this->schedule = $schedule;
        $this->selectedRegions = $selectedRegions;
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
