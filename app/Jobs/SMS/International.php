<?php

namespace App\Jobs\SMS;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class International extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $message, $number, $user_id, $line_id, $schedule;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $line_id, $number, $user_id, $schedule)
    {
        $this->message = $message;
        $this->user_id = $user_id;
        $this->number = $number;
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
        event(new \App\Events\SMS($this->number, $this->message, $this->line_id, $this->user_id, '', $this->schedule));
    }
}
