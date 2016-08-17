<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\SMS, App\User;

class SMSPolicy
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

    public function resendSMS(User $user, SMS $sms){
        if($user->role == 2) return true;
        if($sms->user_id == $user->id) return true;
    }

    public function deleteSMS(User $user, SMS $sms){
        if($user->role == 2) return true;
        if($sms->user_id == $user->id) return true;
    }

    public function restoreSMS(User $user, SMS $sms){
        if($user->role == 2) return true;
        if($sms->user_id == $user->id) return true;
    }
}
