<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User, \App\PreText;

class PreTextPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function seePreTexts(User $user, PreText $pre){
        return true;
    }

    public function createPreTexts(User $user, PreText $pre){
        return true;
    }

    public function editPreTexts(User $user, PreText $pre){
        return ($user->id == $pre->user_id);
    }

    public function deletePreTexts(User $user, PreText $pre){
        return ($user->id == $pre->user_id);
    }
}
