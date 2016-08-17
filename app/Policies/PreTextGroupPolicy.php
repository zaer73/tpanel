<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User, \App\PreTextGroup as Group;

class PreTextGroupPolicy
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

    public function seeGroups(User $user, Group $group){
        return true;
    }

    public function createGroup(User $user, Group $group){
        return true;
    }

    public function editGroup(User $user, Group $group){
        return ($user->id == $group->user_id);
    }

    public function deleteGroup(User $user, Group $group){
        return ($user->id == $group->user_id);
    }
}
