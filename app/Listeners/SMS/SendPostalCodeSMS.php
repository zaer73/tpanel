<?php

namespace App\Listeners\SMS;

use App\Events\SMS\PostalCode;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class SendPostalCodeSMS
{
    use \App\Helpers\SMS\creditControl;

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
     * @param  PostalCode  $event
     * @return void
     */
    public function handle(PostalCode $event)
    {
        // $this->dispatch(new \App\Jobs\SMS\PostalCode($event->text, $event->line_id, $event->postal_code, Auth::id(), $event->schedule));
        $numbers = \App\NumberBank::wherePostalCodeId($event->postal_code)->lists('number');
        $numbers = $this->sendingLimit($event->request, $numbers);
        $totalCost = $this->controlCredit($event->line_id, 'postalCode', $numbers, $event->text, false, 'no_trans');
        if(isset($event->request['is_confirmed']) && $event->request['is_confirmed'] != 'on'){
            die(json_encode( [
                'result' => 'group_confirm',
                'totalCost' => $totalCost,
                'numbers' => count($numbers)
            ]));
        }
        $this->controlCredit($event->line_id, 'postalCode', $numbers, $event->text);
        $group_hash = rand(100000000000000, 999999999999999);
        foreach($numbers as $number){
            event(new \App\Events\SMS($event->input_id, $number, $event->text, $event->line_id, Auth::id(), '', $event->schedule, 'postalCodeSMS', $event->flash, '', $group_hash));
        }
    }
}
