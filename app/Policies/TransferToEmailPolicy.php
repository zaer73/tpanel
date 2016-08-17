<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\TransferToEmail as Transfer;

class TransferToEmailPolicy
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

    public function createTransfer(User $user, Transfer $transfer){
        return true;
    }

    public function editTransfer(User $user, Transfer $transfer){
        return ($user->id == $transfer->user_id);
    }

    public function deleteTransfer(User $user, Transfer $transfer){
        return ($user->id == $transfer->user_id);
    }
}
