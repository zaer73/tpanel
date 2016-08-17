<?php

namespace App\Listeners;

use App\Events\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use cURL;

class SendEmail
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
     * @param  Email  $event
     * @return void
     */
    public function handle(Email $event)
    {
        // Queue::push(function($job) use ($event){
        //     Mail::send('emails.' . $event->type, $event->inputs, function($message) use ($event)
        //     {
        //         $message->to($event->to, $event->name)->subject($event->title);
        //     });
        //     $job->delete();
        // });
        $api_url = config('api.url');
        $response = cURL::post($api_url.'/mail', [
            'to' => $event->to,
            'name' => $event->name,
            'subject' => $event->title,
            'type' => $event->type,
            'inputs' => $event->inputs
        ]);
    }
}
