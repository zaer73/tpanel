<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\MarketingCode as Code;

class MarketingCodePolicy
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

    public function seeCodes(User $user, Code $code){
        return true;    
    }

    public function editPolicy(User $user, Code $code){
        return ($user->role == 1 && $code->user_id == $user->id);
    }

     public function createCode(User $user, Code $code){
        return ($user->role == 1 || $user->role == 2);            
    }

     public function editCode(User $user, Code $code){
        return ($user->id == $code->agent_id);            
    }

     public function deleteCode(User $user, Code $code){
        return ($user->id == $code->agent_id);            
    }
}
