<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Faq;

class FaqPolicy
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

    public function seeFaqs(User $user, Faq $Faq){
        return ($user->role == 1 || $user->role == 2);    
    }

     public function createFaq(User $user, Faq $Faq){
        return ($user->role == 1 || $user->role == 2);            
    }

     public function editFaq(User $user, Faq $Faq){
        return ($user->id == $Faq->user_id);            
    }

     public function deleteFaq(User $user, Faq $Faq){
        return ($user->id == $Faq->user_id);            
    }
}
