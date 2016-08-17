<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User, \App\Occupation;

class OccupationPolicy
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

    public function seeOccups(User $user, Occupation $occupation){
        return ($user->role == 2);
    }

    public function createOccups(User $user, Occupation $occupation){
        return ($user->role == 2);
    }

    public function editOccups(User $user, Occupation $occupation){
        return ($user->role == 2);
    }

    public function deleteOccups(User $user, Occupation $occupation){
        return ($user->role == 2);
    }
}
