<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Ticket;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function seeTickets(User $user, Ticket $ticket){
        return true;
    }

    public function createTicket(User $user, Ticket $ticket){
        return true;
    }

    public function cancelTicket(User $user, Ticket $ticket){
        return ($user->role == 2 || $ticket->user_id == $user->id);
    }

    public function answerTicket(User $user, Ticket $ticket){
        return ($user->role == 2 || $ticket->supervisor_id == $user->id);
    }
}
