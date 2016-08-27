<?php

namespace App\Listeners\SMS;

use Auth;
use App\NumberBank;
use App\Events\SMS\Map;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMapSMS
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
     * @param  Map  $event
     * @return void
     */
    public function handle(Map $event)
    {
        $numbers = NumberBank::whereIn('polygon', $event->selectedRegions)->take($event->request['amount'])->lists('number')->toArray();
        // $numbers = $this->sendingLimit($event->request, $numbers);
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
