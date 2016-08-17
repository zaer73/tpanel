<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Filtering;

class FilteringPolicy
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

    public function seeFilterings(User $user, Filtering $filtering){
        return ($user->role == 1 || $user->role == 2);    
    }

     public function createFiltering(User $user, Filtering $filtering){
        return ($user->role == 1 || $user->role == 2);            
    }

     public function editFiltering(User $user, Filtering $filtering){
        return ($user->id == $filtering->user_id);            
    }

     public function deleteFiltering(User $user, Filtering $filtering){
        return ($user->id == $filtering->user_id);            
    }
}
