<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User, \App\Customization as Custom;

class CustomizationPolicy
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

    public function showCustom(User $user, Custom $custom){
        return ($user->role == 2 || ($user->role == 1 && $custom->user_id == $user->id));
    }
}
