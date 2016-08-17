<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use \App\User;
use \App\News;

class NewsPolicy
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

    public function createNews(User $user, News $news){
        return ($user->role == 2);
    }

    public function showNews(User $user, News $news){
        return ($user->role == 2);
    }

    public function editNews(User $user, News $news){
        return ($user->role == 2);
    }

    public function deleteNews(User $user, News $news){
        return ($user->role == 2);
    }
}
