<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\ContactGroup as Group;

class ContactGroupPolicy
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

    public function createGroup(User $user, Group $group){
        return true;
    }

    public function editContactGroup(User $user, Group $group){
        return ($group->user_id == $user->id);
    }

    public function deleteContactGroup(User $user, Group $group){
        return ($group->user_id == $user->id);
    }
}
