<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User, \App\PostalCode as Code;

class PostalCodePolicy
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

    public function seePostalCodes(User $user, Code $code){
        return ($user->role == 2);
    }

    public function createPostalCodes(User $user, Code $code){
        return ($user->role == 2);
    }

    public function editPostalCodes(User $user, Code $code){
        return ($user->role == 2);
    }

    public function deletePostalCodes(User $user, Code $code){
        return ($user->role == 2);
    }
}
