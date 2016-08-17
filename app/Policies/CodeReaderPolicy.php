<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\CodeReader;

class CodeReaderPolicy
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

    public function createCodeReader(User $user, CodeReader $auto){
        return true;
    }

    public function editCodeReader(User $user, CodeReader $auto){
        return ($user->id == $auto->user_id);
    }

    public function deleteCodeReader(User $user, CodeReader $auto){
        return ($user->id == $auto->user_id);
    }

    public function enableCodeReader(User $user, CodeReader $auto){
        return ($user->id == $auto->user_id);
    }

    public function trashCodeReader(User $user, CodeReader $auto){
        return ($user->id == $auto->user_id);
    }
}
