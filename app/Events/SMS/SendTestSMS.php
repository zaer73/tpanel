<?php

namespace App\Events\SMS;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendTestSMS extends Event
{
    use SerializesModels;

    public $text, $receiver, $line, $brand, $international;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text, $receiver, $line, $brand, $international=null)
    {
        $this->text = $text;
        $this->receiver = $receiver;
        $this->line = $line;
        $this->brand = (!empty($international)) ? 'Test SMS' : $brand;
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
