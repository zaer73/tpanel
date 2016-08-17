<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Charge;

class ChargePolicy
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

    public function seeCharges(User $user, Charge $Charge){
        return ($user->role == 1 || $user->role == 2);    
    }

     public function createCharge(User $user, Charge $Charge){
        return ($user->role == 1 || $user->role == 2);            
    }

     public function editCharge(User $user, Charge $Charge){
        return ($user->id == $Charge->user_id);            
    }

     public function deleteCharge(User $user, Charge $Charge){
        return ($user->id == $Charge->user_id);            
    }
}
