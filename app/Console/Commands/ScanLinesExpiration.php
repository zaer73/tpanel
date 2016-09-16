<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScanLinesExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scans lines expiration';

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
        $lines = \App\Line::all();

        $bar = $this->output->createProgressBar(count($lines));

        foreach ($lines as $line) {

            if ($line->general == 1) continue;

            if (strtotime($line->user_expires_at) < strtotime('now')) {

                $line->update([
                    'user_expires_at' => null,
                    'user_id' => null
                ]);

            }

            if (strtotime($line->agent_expires_at) < strtotime('now')) {

                $line->update([
                    'agent_expires_at' => null,
                    'agent_id' => null
                ]);

            }


            $bar->advance();
            

        }
        echo "\n";
        $bar->finish();
        echo "\n";

    }
}
