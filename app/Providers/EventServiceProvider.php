<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Email' => [
            'App\Listeners\SendEmail',
        ],
        'App\Events\ChangePassword' => [
            'App\Listeners\ChangePasswordListener'
        ],
        'App\Events\SecureLogin' => [
            'App\Listeners\SecureLoginListener'
        ],
        'App\Events\SMS' => [
            'App\Listeners\SaveSMSOnDB',
            'App\Listeners\SMSListener',
        ],
        'App\Events\ProfilePasswordChanged' => [
            'App\Listeners\ProfilePasswordChangedListener'
        ],
        'App\Events\CreditTransformed' => [
            'App\Listeners\CreditTransformedListener'
        ],
        'App\Events\SMS\Single' => [
            'App\Listeners\SMS\SendSingleSMS'
        ],
        'App\Events\SMS\Group' => [
            'App\Listeners\SMS\SendGroupSMS'
        ],
        'App\Events\SMS\City' => [
            'App\Listeners\SMS\SendCitySMS'
        ],
        'App\Events\SMS\Occupation' => [
            'App\Listeners\SMS\SendOccupationSMS'
        ],
        'App\Events\SMS\PostalCode' => [
            'App\Listeners\SMS\SendPostalCodeSMS'
        ],
        'App\Events\SMS\Gender' => [
            'App\Listeners\SMS\SendGenderSMS'
        ],
        'App\Events\SMS\Brand' => [
            'App\Listeners\SMS\SendBrandSMS'
        ],
        'App\Events\SMS\International' => [
            'App\Listeners\SMS\SendInternationalSMS'
        ],
        'App\Events\Financial\CreditChanged' => [
            'App\Listeners\Financial\CreditChangedListener'
        ],
        'App\Events\Financial\Transaction' => [
            'App\Listeners\Financial\TransactionListener',
            'App\Listeners\Financial\AddTransactionToInvoceListener'
        ],
        'App\Events\SMS\ScheduledMessage' => [
            'App\Listeners\SMS\ScheduledMessageListener'
        ],
        'App\Events\SMS\SendTestSMS' => [
            'App\Listeners\SMS\SendTestSMSListener'
        ],
        'App\Events\SMS\SystemSMS' => [
            'App\Listeners\SMS\SystemSMSListener'
        ],
        'App\Events\User\UserDeleted' => [
            'App\Listeners\User\Deleted\ReturnCreditToSupervisor',
            'App\Listeners\User\Deleted\ReturnLinesToSupervisor'
        ],
        'App\Events\User\LawyerCreated' => [
            'App\Listeners\User\SetLawyerCredit',
            'App\Listeners\User\SetLawyerPermissions',
            'App\Listeners\User\CreateLawyersRecord',
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
