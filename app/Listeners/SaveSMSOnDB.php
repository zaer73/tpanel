<?php

namespace App\Listeners;

use App\Events\SMS;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\SMSTextFilter;

class SaveSMSOnDB
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->filter = \App::make(SMSTextFilter::class);
    }

    /**
     * Handle the event.
     *
     * @param  SMS  $event
     * @return void
     */
    public function handle(SMS $event)
    {
        $this->filter->check($event->message);
        $user = \App\User::find($event->user_id);
        // $scheduled = ($event->scheduled_on > 0) ? date('Y-m-d H:i:s', $event->scheduled_on/1000) : '0000-00-00 00:00:00';       
        $sms = $user->sms()->create([
            'input_id' => $event->input_id,
            'queue_name' => $event->queueName,
            'reciever' => $event->to,
            'sender' => $event->line,
            'text' => $event->message,
            'type' => $event->type,
            'scheduled_on' => $event->scheduled_on,
            'group_hash' => ($event->group_hash) ? $event->group_hash : rand(100000000000000, 999999999999999) 
        ]);
        $event->sms_id = $sms->id;
        $international = ($event->type == 'international') ? true : false;
        $total_cost = total_cost([$event->to], $event->message, false, $international, $user);
        event(new \App\Events\Financial\CreditChanged($total_cost, 'minus', $user->id));
        // $price_group = $user->priceGroup()->first()->toArray()['irancell_reg'];
        // $credit = $user->credit - $price_group;
        // $user->update(['credit' => $credit]);
    }
}
