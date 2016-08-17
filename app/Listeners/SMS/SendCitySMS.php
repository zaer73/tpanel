<?php

namespace App\Listeners\SMS;

use App\Events\SMS\City;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class SendCitySMS
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
     * @param  City  $event
     * @return void
     */
    public function handle(City $event)
    {
        if(!empty($event->city)){
            $city_id = [$event->city];
        } else {
            $city_id = \App\City::whereProvinceId($event->province)->lists('id')->toArray();
        }
        $numbers = \App\NumberBank::whereIn('city_id', $city_id)->lists('number');
        $numbers = $this->sendingLimit($event->request, $numbers);
        $totalCost = $this->controlCredit($event->line_id, 'city', $numbers, $event->text, false, 'no_trans');
        if(isset($event->request['is_confirmed']) && $event->request['is_confirmed'] != 'on'){
            die(json_encode( [
                'result' => 'group_confirm',
                'totalCost' => $totalCost,
                'numbers' => count($numbers)
            ]));
        }
        $this->controlCredit($event->line_id, 'city', $numbers, $event->text);
        $group_hash = rand(100000000000000, 999999999999999);
        foreach($numbers as $number){
            event(new \App\Events\SMS($event->input_id, $number, $event->text, $event->line_id, Auth::id(), '', $event->schedule, 'citySMS', false, '', $group_hash));
        }
    }
}
