<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Contact;

class ContactPolicy
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

    public function createContact(User $user, Contact $contact){
        return true;
    }   

    public function editContact(User $user, Contact $contact){
        return ($user->id == $contact->user_id);
    }

    public function deleteContact(User $user, Contact $contact){
        return ($user->id == $contact->user_id);
    }

    public function restoreContact(User $user, Contact $contact){
        return ($user->id == $contact->user_id);
    }

    public function explodeContact(User $user, Contact $contact){
        return ($user->id == $contact->user_id);
    }
}
