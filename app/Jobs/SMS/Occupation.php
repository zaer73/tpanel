<?php

namespace App\Jobs\SMS;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\NumberBank as Bank;

class Occupation extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $message, $occupation, $user_id, $line_id, $schedule;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $line_id, $occupation, $user_id, $schedule)
    {
        $this->message = $message;
        $this->occupation = $occupation;
        $this->user_id = $user_id;
        $this->line_id = $line_id;
        $this->schedule = $schedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $numbers = Bank::whereJobId($this->occupation)->lists('number');
        foreach($numbers as $number){
            event(new \App\Events\SMS($number, $this->message, $this->line_id, $this->user_id, '', $this->schedule));
        }
    }
}
