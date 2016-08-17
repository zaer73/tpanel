<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User, \App\NumberBank as Bank;

class NumberBankPolicy
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

    public function seeNumbers(User $user, Bank $bank){
        return ($user->role == 2);
    }

    public function defineCities(User $user, Bank $bank){
        return ($user->role == 2);
    }

    public function defineOccupations(User $user, Bank $bank){
        return ($user->role == 2);
    }
}
