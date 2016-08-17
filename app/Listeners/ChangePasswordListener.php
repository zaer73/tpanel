<?php

namespace App\Listeners;

use App\Events\ChangePassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangePasswordListener
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
     * @param  ChangePassword  $event
     * @return void
     */
    public function handle(ChangePassword $event)
    {
        $password_reset = new \App\PasswordReset; 
        $password_reset->email = $event->email;
        $password_reset->token = $event->password;
        $password_reset->created_at = date('Y-m-d H:i:s');
        $password_reset->save();
    }
}
