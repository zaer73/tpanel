<?php

namespace App\Listeners\SMS;

use App\Events\SMS\SystemSMS;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use cURL;

class SystemSMSListener
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

    public function provider($number){
        if(substr($number, 0, 4) == '1000' || substr($number, 0, 5) == '50001'){
            return 'gama';
        }
        if(substr($number, 0, 2) == '021' || substr($number, 0, 2) == '026'){
            return 'asanak';
        }
    }

    /**
     * Handle the event.
     *
     * @param  SystemSMS  $event
     * @return void
     */
    public function handle(SystemSMS $event)
    {
        $api_url = config('api.url');
        $line = \App\AdminSetting::whereKey('system_number')->first()->value;
        $response = cURL::post($api_url.'/send/system/'.$this->provider($line), [
            'mobile' => $event->mobile,
            'text' => $event->text,
            'line' => $line
        ]);
    }
}
