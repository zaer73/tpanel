<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class UserIdContactsConverter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:contacts {table : Name of table} {--c|connection=mysql : Name of database connection to get data} {--uId|userid=userid : Userid column name in table} {--uName|username=username : Username column name in table} {--uTable|usersTable=irsp_user : Users table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts old userId to current one';

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

        $table = $this->argument('table');
        $connection = $this->option('connection');
        $userIdColumnName = $this->option('userid');
        $usernameColumnName = $this->option('username');
        $usersTable = $this->option('usersTable');

        $connection = DB::connection($connection);
        $count = $connection->select("select count(*) as c from {$table}")[0]->c;

        $bar = $this->output->createProgressBar($count);

        $counter = 0;
        foreach ($connection->select("select * from $table") as $record) {

            $userid = $record->{$userIdColumnName};

            $username = $connection->select("select {$usernameColumnName} from {$usersTable} where {$userIdColumnName} = {$userid}");

            if (!count($username)) {
                continue;
            }

            $username = $username[0]->{$usernameColumnName};

            $primaryUserId = \App\User::whereUsername($username)->first();

            if (!$primaryUserId) {
                continue;
            }

            $contact = new \App\Contact;
            $contact->user_id = $primaryUserId->id;
            $contact->name = $record->firstname.' '.$record->lastname;
            $contact->number = $record->mobileno;
            $contact->group_id = $record->groupid;
            $contact->save();
            
            $bar->advance();

            $counter++;
            if ($counter > 100) {
                die();
            }
            
        }

        $bar->finish();
        
    }
}
