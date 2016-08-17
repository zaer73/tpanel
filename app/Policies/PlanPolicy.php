<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User, App\Plan;

class PlanPolicy
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

    public function seePlans(User $user, Plan $plan){
        return ($user->role == 2 || $user->role == 1);
    }

    public function createPlans(User $user, Plan $plan){
        return ($user->role == 2 || $user->role == 1);
    }

    public function editPlans(User $user, Plan $plan){
        return ($user->id == $plan->user_id);
    }

    public function deletePlans(User $user, Plan $plan){
        return ($user->id == $plan->user_id);
    }

    public function usePlan(User $user, Plan $plan)
    {

        return ($user->role == $plan->type);

    }
}
