<?php

namespace App\Listeners;

use App\Events\SMS;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
// use \App\SMS as SMSModel;
use Auth;
use Redis, cURL;

class SMSListener
{
    use \App\Helpers\API\SMS;

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
     * @param  SMS  $event
     * @return void
     */
    public function handle(SMS $event)
    {
        $this->sendSMS($event->to, $event->message, $event->line, $event->sms_id, $event->scheduled_on, $event->queueName, $event->flash, $event->brand, $event->group_hash, $event->user);
        // $res = cURL::post('http://192.168.33.21/api/public/send', [
        //     'receiver' => '09379010826',
        //     'key' => 'sdaa',
        //     'secret' => 'sdasdasd',
        //     'line_id' => $event->line
        // ]);
        // echo $res->body;
    }
}
