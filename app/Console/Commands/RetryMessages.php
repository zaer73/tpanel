<?php

namespace App\Console\Commands;

use App\Helpers\API\SMS;
use Illuminate\Console\Command;

class RetryMessages extends Command
{

    use SMS;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:retry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry sending failed messages';

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
        $failedMessages = \App\SMS::where('status', '-1')->orderBy('id', 'asc')->get();
        foreach($failedMessages as $message){
            try {
                $this->sendSMS($message->reciever, $message->text, $message->sender, $message->id, '0000-00-00 00:00:00', 'singleSMS');
            } catch (\Exception $e) {
               
            }
        }
    }
}
