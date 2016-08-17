<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Queue;
use Redis;
use Validator;
use App\Validation\NationalCodeValidation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function (JobProcessed $event) {
            
        });

        Validator::extend('nationalCode', function($attribute, $value){
            
            if( (new NationalCodeValidation($value))->validate() ) return true;

            return false;

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
