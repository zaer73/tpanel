<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SetApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets api key for users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $usersCount = User::count();

        $bar = $this->output->createProgressBar($usersCount);

        $users = User::all();

        foreach ($users as $user) {

            if (!$user->apikey()->count()) {

                $user->apikey()->create([
                    'public_key' => str_random(25),
                    'secret_key' => str_random(30)
                ]);
                
            }

            $bar->advance();
        }

        $bar->finish();

    }
}
