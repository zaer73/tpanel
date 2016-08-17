<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User;
use \App\PriceGroup;

class PriceGroupPolicy
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

    public function editGroup(User $user, PriceGroup $group){
        return ($user->role == 2 || ($user->role == 1 && $group->user_id == $user->id));
    }

    public function deleteGroup(User $user, PriceGroup $group){
        return ($user->role == 2 || ($user->role == 1 && $group->user_id == $user->id));
    }
}
