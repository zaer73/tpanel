<?php

namespace App\Listeners\SMS;

use App\Events\SMS\Group;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class SendGroupSMS
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
     * @param  Group  $event
     * @return void
     */
    public function handle(Group $event)
    {
        // $total_cost = total_cost($event->numbers, $event->text);
        // event(new \App\Events\Financial\CreditChanged($total_cost, 'minus'));
        $this->controlCredit($event->line, 'group', $event->numbers, $event->text);
        $group_hash = rand(100000000000000, 999999999999999);
        foreach($event->numbers as $number){
            if(empty($number)) continue;
            event(new \App\Events\SMS($event->input_id, $number, $event->text, $event->line, Auth::id(), '', $event->schedule, 'groupSMS', $event->flash, '', $group_hash));
        }
    }
}
