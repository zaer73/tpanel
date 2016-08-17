<?php

namespace App\Listeners\User\Deleted;

use App\Events\User\UserDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Line;

class ReturnLinesToSupervisor
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
     * @param  UserDeleted  $event
     * @return void
     */
    public function handle(UserDeleted $event)
    {
        if( !$event->user->parent ) return;
        $role = userRole($event->user);
        $lines = Line::where($role.'_id', $event->user->id)
                        ->update([
                            $role.'_id' => 0]
                        );
    }
}
