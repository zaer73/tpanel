<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {--t|table=irsp_user} {--c|connection=irsp}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports users from old table';

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

        $connection = $this->option('connection');
        $table = $this->option('table');

        $count = DB::connection($connection)->select('select count(*) as c from '.$table)[0]->c;

        $bar = $this->output->createProgressBar($count);
        
        foreach(DB::connection($connection)->select('select * from '.$table) as $oldUser) {
            $user = \App\User::firstOrNew([
                'username' => $oldUser->username,
            ]);
            $user->email = $oldUser->email;
            $user->first_name =  $oldUser->firstname;
            $user->last_name =  $oldUser->lastname;
            $user->name =  $oldUser->corporation;
            $user->username =  $oldUser->username;
            $user->national_code =  $oldUser->nationalcode;
            $user->date_of_birth =  date('Y-m-d H:i:s', strtotime($oldUser->birthdate));
            $user->mobile =  $oldUser->cellphone;
            $user->credit =  $oldUser->credit;
            try{
                $user->save();
            } catch(\Exception $e) {
                
            }

            $bar->advance();
        }

        $bar->finish();

    }
}
