<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\MarketingCodePolicy as Code;

class MarketingCodePolicyPolicy
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

    public function editPolicy(User $user, Code $code){
        return ($user->role == 1 && $code->user_id == $user->id);
    }
}
