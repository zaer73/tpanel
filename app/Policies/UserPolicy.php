<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User;
class UserPolicy
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

    public function activateUser(User $user){ // check if user can change user's activity
        return ($user->role == 2 || $user->role == 1);
    }

    public function changeUserRole(User $loggedin, User $user){  // check if user can change user's role
        return ($loggedin->role == 2 || ($loggedin->role == 1 && $user->parent == $loggedin->id));
    }

    public function changeUserParent(User $user){ // check if user can change user's parent
        return ($user->role == 2 || $user->role == 1);
    }

    public function deleteUser(User $loggedin, User $user){ // check if user can delete another user
        return ($loggedin->role == 2 && $user->role != 2);
    }

    public function editSetting(User $loggedin, User $user){ // check if user can edit some other user's setting
        return ($loggedin->role == 2 || ($loggedin->role == 1 && $user->parent == $loggedin->id));
    }

    public function lineToUser(User $loggedin, User $user){ // check if user can give lines to other user
        return ($loggedin->role == 2 || ($loggedin->role == 1 && $user->parent == $loggedin->id)); 
    }

    public function editCredit(User $loggedin, User $user){
        return ($loggedin->role == 2 || ($loggedin->role == 1 && $user->parent == $loggedin->id));
    }

    public function loginForUser(User $loggedin, User $user){
        return ($loggedin->role == 2);
    }

    public function createPriceGroup(User $loggedin){
        return ($loggedin->role == 2);
    }

}
