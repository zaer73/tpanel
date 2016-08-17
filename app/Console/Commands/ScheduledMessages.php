<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScheduledMessages extends Command
{

    use \App\Helpers\SMS\NextTimeGenerator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduledMessages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Scheduled Messages';

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
        $now = date('Y-m-d H:i:s');
        $minuteLater = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $schedules = \App\Schedule::whereStatus('0')->whereRaw("`next_time` between '{$now}' and '{$minuteLater}'")->lists('id');
        $messages = \App\ScheduledMessage::whereIn('schedule_id', $schedules)->get();
        foreach($messages as $message){
            $receivers = unserialize($message->receivers);
            foreach($receivers as $receiver){
                event(new \App\Events\SMS(0, $receiver, $message->text, $message->line_id, $message->user_id, 0, '0000-00-00 00:00:00', 'scheduledSMS', $message->flash));
            }
            $schedule = \App\Schedule::whereId($message->schedule_id)->first();
            $schedule->next_time = $this->nextTimeGenerator($schedule->next_time, $schedule->type, $schedule->clock, $schedule->week_day, $schedule->month_day, $schedule->month);
            $schedule->save();
        }
    }
}
