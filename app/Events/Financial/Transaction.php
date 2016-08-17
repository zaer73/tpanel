<?php

namespace App\Events\Financial;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Transaction extends Event
{
    use SerializesModels;

    public $value, $sign, $type, $user, $description, $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($value, $sign, $user, $type, $target_id, $description=null)
    {
        $this->value = $value;
        $this->sign = $sign;
        $this->user = $user;
        $this->type = $type;
        $this->target_id = $target_id;
        $this->description = $description;
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
