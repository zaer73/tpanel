<?php

namespace App\Events\Financial;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Auth;

class CreditChanged extends Event
{
    use SerializesModels;

    public $value, $type, $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($value, $type, $user_id=null)
    {
        $this->value = $value;
        $this->type = ($type == 'minus') ? -1 : 1;
        $this->user = ($user_id) ? \App\User::find($user_id) : Auth::user();
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
