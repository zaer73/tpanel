<?php

namespace App\Listeners\User;

use App\Lawyer;
use App\Events\User\LawyerCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateLawyersRecord
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
        Lawyer::firstOrcreate([
            'user_id' => $event->user->id,
            'parent_id' => auth()->id()
        ]);
    }
}
