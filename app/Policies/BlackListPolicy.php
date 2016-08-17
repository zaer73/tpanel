<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\BlackList;

class BlackListPolicy
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

    public function createBlackList(User $user, BlackList $blacklist){
        return true;
    }

    public function editBlackList(User $user, BlackList $blacklist){
        return ($user->id == $blacklist->user_id);
    }

    public function deleteBlackList(User $user, BlackList $blacklist){
        return ($user->id == $blacklist->user_id);
    }
}
