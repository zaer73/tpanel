<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreditTransformed extends Event
{
    use SerializesModels;

    public $from, $to, $value, $giver_balance, $getter_balance;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($from, $to, $value, $giver_balance, $getter_balance)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
        $this->giver_balance = $giver_balance;
        $this->getter_balance = $getter_balance;
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
