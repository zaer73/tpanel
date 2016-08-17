<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SMS extends Event
{
    use SerializesModels;

    public $input_id, $to, $message, $line, $scheduled_on, $type, $user_id, $sms_id, $scheduled, $queueName, $flash, $brand, $group_hash, $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($input_id, $to, $message, $line, $user_id, $type=0, $scheduled_on='0000-00-00 00:00:00', $queueName='singleSMS', $flash=false, $brand=null, $group_hash=null, $user=null)
    {
        $this->input_id = $input_id;
        $this->to = $to;
        $this->message = $message;
        $this->user_id = $user_id;
        $this->type = $type;
        $this->line = $line;
        $this->scheduled_on = $scheduled_on;
        $this->queueName = $queueName;
        $this->brand = $brand;
        $this->group_hash = $group_hash;
        $this->flash = ($flash) ? true : false;
        $this->user = $user;
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
