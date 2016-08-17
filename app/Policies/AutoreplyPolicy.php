<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Autoreply;

class AutoreplyPolicy
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

    public function createAutoreply(User $user, Autoreply $auto){
        return true;
    }

    public function editAutoreply(User $user, Autoreply $auto){
        return ($user->id == $auto->user_id);
    }

    public function deleteAutoreply(User $user, Autoreply $auto){
        return ($user->id == $auto->user_id);
    }

    public function enableAutoreply(User $user, Autoreply $auto){
        return ($user->id == $auto->user_id);
    }

    public function trashAutoreply(User $user, Autoreply $auto){
        return ($user->id == $auto->user_id);
    }
    
}
