<?php

namespace App\Jobs\Email;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $to, $type, $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $type, $subject)
    {
        $this->to = $to;
        $this->type = $type;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = \App\User::find($this->to);
        Mail::send('emails.reminder', ['to' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject($this->subject);
        });
    }
}
