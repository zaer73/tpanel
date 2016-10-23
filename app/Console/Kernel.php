<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ScheduledMessages::class,
        Commands\ImportTables::class,
        Commands\UserIdContactsConverter::class,
        Commands\ImportUsers::class,
        Commands\ScanLinesExpiration::class,
        Commands\RetryMessages::class,
        Commands\SetApiKey::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
    }
}
