<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\PriceGroup' => 'App\Policies\PriceGroupPolicy',
        'App\News' => 'App\Policies\NewsPolicy',
        'App\Customization' => 'App\Policies\CustomizationPolicy',
        'App\Line' => 'App\Policies\LinePolicy',
        'App\PreText' => 'App\Policies\PreTextPolicy',
        'App\PreTextGroup' => 'App\Policies\PreTextGroupPolicy',
        'App\Permission' => 'App\Policies\PermissionPolicy',
        'App\NumberBank' => 'App\Policies\NumberBankPolicy',
        'App\Occupation' => 'App\Policies\OccupationPolicy',
        'App\PostalCode' => 'App\Policies\PostalCodePolicy',
        'App\SMS' => 'App\Policies\SMSPolicy',
        'App\ContactGroup' => 'App\Policies\ContactGroupPolicy',
        'App\Contact' => 'App\Policies\ContactPolicy',
        'App\Poll' => 'App\Policies\PollPolicy',
        'App\Autoreply' => 'App\Policies\AutoreplyPolicy',
        'App\CodeReader' => 'App\Policies\CodeReaderPolicy',
        'App\BlackList' => 'App\Policies\BlackListPolicy',
        'App\TransferToEmail' => 'App\Policies\TransferToEmailPolicy',
        'App\Special' => 'App\Policies\SpecialPolicy',
        'App\Plan' => 'App\Policies\PlanPolicy',
        'App\Filtering' => 'App\Policies\FilteringPolicy',
        'App\Faq' => 'App\Policies\FaqPolicy',
        'App\Charge' => 'App\Policies\ChargePolicy',
        'App\MarketingCode' => 'App\Policies\MarketingCodePolicy',
        'App\MarketingCodePolicy' => 'App\Policies\MarketingCodePolicyPolicy',
        'App\Ticket' => 'App\Policies\TicketPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
