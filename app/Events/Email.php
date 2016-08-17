<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Email extends Event
{
    use SerializesModels;

    public $to, $inputs, $type, $name, $title;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    
    public function __construct($to, $inputs, $type, $name, $title)
    {
        $this->to = $to;
        $this->inputs = $inputs;
        $this->type = $type;
        $this->name = $name;
        $this->title = $title;
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
