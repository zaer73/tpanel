<?php

namespace App\Listeners\User;

use App\Events\User\LawyerCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetLawyerCredit
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
     * @param  LawyerCreated  $event
     * @return void
     */
    public function handle(LawyerCreated $event)
    {
        $event->user->credit = $event->request->credit;
        $event->user->save();

        auth()->user()->transactions()->create([
            'value' => $event->request->credit,
            'last_credit' => auth()->user()->credit ?: 0,
            'type' => 'CREATE_LAWYER',
            'target_id' => $event->user->id,
            'description' => 'transfer_to_lawyer',
            'code' => rand(10000000, 99999999)
        ]);
        event(new \App\Events\Financial\CreditChanged($event->request->get('credit'), 'minus'));
    }
}
