<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Poll;

class PollPolicy
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

    public function createPoll(User $user, Poll $poll){
        return true;
    }

    public function editPoll(User $user, Poll $poll){
        return ($poll->user_id == $user->id);
    }

    public function deletePoll(User $user, Poll $poll){
        return ($poll->user_id == $user->id);
    }
}
