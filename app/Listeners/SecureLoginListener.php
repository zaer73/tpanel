<?php

namespace App\Listeners;

use App\Events\SecureLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SecureLoginListener
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
     * @param  SecureLogin  $event
     * @return void
     */
    public function handle(SecureLogin $event)
    {
        $temp_password = str_random(8);
        $secure_login = \App\SecureLogin::firstOrNew(['user_id' => $event->id]);
        $secure_login->user_id = $event->id;
        $secure_login->expired = 0;
        $secure_login->password = bcrypt($temp_password);
        $secure_login->expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $secure_login->save();
        $message = 'کلمه عبور موقت شما:‌ ' . $temp_password;
        $to = \App\User::select('mobile')->whereId($event->id)->first()->mobile;
        event(new \App\Events\SMS\SystemSMS($to, $message));
    }
}
