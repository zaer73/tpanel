<?php

namespace App\Jobs\SMS;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Group extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $message, $numbers, $user_id, $line, $schedule;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $numbers, $line, $user_id, $schedule)
    {
        $this->message = $message;
        $this->numbers = $numbers;
        $this->line = $line;
        $this->user_id = $user_id;
        $this->schedule = $schedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->numbers as $number){
            event(new \App\Events\SMS($number, $this->message, $this->line, $this->user_id, '', $this->schedule));
        }
    }
}
