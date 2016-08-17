<?php

namespace App\Jobs\SMS;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Queue;

class Single extends Job/* implements ShouldQueue*/
{
    use InteractsWithQueue, SerializesModels;

    public $text, $receiver, $user_id, $line_id, $schedule;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text, $receiver, $line_id, $user_id, $schedule)
    {
        $this->text = $text;
        $this->receiver = $receiver;
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
        event(new \App\Events\SMS($this->receiver, $this->text, $this->line_id, $this->user_id, '', $this->schedule));
    }
}
