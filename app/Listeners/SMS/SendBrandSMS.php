<?php

namespace App\Listeners\SMS;

use App\Events\SMS\Brand;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class SendBrandSMS
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
     * @param  Brand  $event
     * @return void
     */
    public function handle(Brand $event)
    {
        $totalCost = $this->controlCredit($event->line_id, 'brand', $event->numbers, $event->text, false, 'no_trans');
        if(isset($event->request['is_confirmed']) && $event->request['is_confirmed'] != 'on'){
            die(json_encode( [
                'result' => 'group_confirm',
                'totalCost' => $totalCost,
                'numbers' => count($event->numbers)
            ]));
        }
        $this->controlCredit($event->line_id, 'brand', $event->numbers, $event->text);
        $group_hash = rand(100000000000000, 999999999999999);
        foreach($event->numbers as $number){
            event(new \App\Events\SMS($event->input_id, $number, $event->text, $event->line_id, Auth::id(), '', $event->schedule, 'brandSMS', $event->flash, $event->brand, $group_hash));
        }
    }
}
