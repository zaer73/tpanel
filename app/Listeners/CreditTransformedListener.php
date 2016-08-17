<?php

namespace App\Listeners;

use App\Events\CreditTransformed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Transaction;

class CreditTransformedListener
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
     * @param  CreditTransformed  $event
     * @return void
     */
    public function handle(CreditTransformed $event)
    {
        $to_user = \App\User::select('username')->whereId($event->to)->first();
        Transaction::create([
            'user_id' => $event->from,
            'code' => rand(10000000, 99999999),
            'status' => 1,
            'value' => -1*$event->value,
            'description' => trans('credit_change_by_agent_to_user', [
                'user' => $to_user->username
            ]),
            'type' => 'credit',
            'last_credit' => $event->giver_balance
        ]);
        Transaction::create([
            'user_id' => $event->to,
            'code' => rand(10000000, 99999999),
            'status' => 1,
            'value' => $event->value,
            'description' => trans('credit_change_by_agent'),
            'type' => 'credit',
            'last_credit' => $event->getter_balance
        ]);
    }
}
