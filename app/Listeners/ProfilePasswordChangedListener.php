<?php

namespace App\Listeners;

use App\Events\ProfilePasswordChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfilePasswordChangedListener
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
     * @param  ProfilePasswordChanged  $event
     * @return void
     */
    public function handle(ProfilePasswordChanged $event)
    {
        //
    }
}
