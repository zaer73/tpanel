<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SystemSMS extends Event
{
    use SerializesModels;

    public $mobile, $text;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($mobile, $text)
    {
        $this->mobile = $mobile;
        $this->text = $text;
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
