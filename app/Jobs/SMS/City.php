<?php

namespace App\Jobs\SMS;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\NumberBank as Bank;

class City extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $message, $province, $city, $user_id, $schedule, $line_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $line_id, $province, $city, $user_id, $schedule)
    {
        $this->message = $message;
        $this->province = $province;
        $this->city = $city;
        $this->line_id = $line_id;
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
        $numbers = Bank::whereCityId($this->city)->whereProvinceId($this->province)->lists('number');
        foreach($numbers as $number){
            event(new \App\Events\SMS($number, $this->message, $this->line_id, $this->user_id, '', $this->schedule));
        }
    }
}
