<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Special;

class SpecialPolicy
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

    public function seeSpecials(User $user, Special $special){
        return ($user->role == 1 || $user->role == 2);
    }

    public function createSpecials(User $user, Special $special){
        return ($user->role == 1 || $user->role == 2);
    }

    public function editSpecials(User $user, Special $special){
        return ($user->id == $special->user_id);
    }

    public function deleteSpecials(User $user, Special $special){
        return ($user->id == $special->user_id);
    }

    public function disableSpecials(User $user, Special $special){
        return ($user->id == $special->user_id);
    }

    public function enableSpecials(User $user, Special $special){
        return ($user->id == $special->user_id);
    }
}
