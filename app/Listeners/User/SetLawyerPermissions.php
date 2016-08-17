<?php

namespace App\Listeners\User;

use Cons;
use App\Permission;
use App\Events\User\LawyerCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetLawyerPermissions
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LawyerCreated  $event
     * @return void
     */
    public function handle(LawyerCreated $event)
    {
        $permissions = Permission::firstOrNew([
            'user_id' => $event->user->id
        ]);

        foreach ($permissions->toArray() as $permissionKey => $permissionValue) {

            if (!in_array($permissionKey, Cons::$permissions)) {
                continue;
            }

            $permissions->{$permissionKey} = 0;

        }

        foreach ($event->request->permissions as $permissionKey => $permissionValue) {

            if (!in_array($permissionKey, Cons::$permissions)) {
                continue;
            }

            if ($permissionValue == true || $permissionValue == 1) {
                $permissions->{$permissionKey} = 1;
            }

        }

        $permissions->save();
    }
}
