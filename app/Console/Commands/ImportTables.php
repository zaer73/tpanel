<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ImportTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tables {folder : Folder of files to be imported} {table? : Table of database that data will be placed} {--D|database=irsp : Name of database} {--U|username=homestead : MySQL username} {--P|password=secret : MySQL password} {--T|truncate : Truncate data after import ?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import old tables';

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

        $folder = $this->argument('folder');
        $table = $this->argument('table');
        $database = $this->option('database');
        $username = $this->option('username');
        $password = $this->option('password');
        $truncate = $this->option('truncate') ? true : false;

        $files = scandir('./old_db/'.$folder);

        $bar = $this->output->createProgressBar(count($files));

        foreach ($files as $file) {
            if (strpos($file, '.sql') === false) {
                continue;
            }

            echo "\n Working on {$file} \n ";

            exec("mysql -u {$username} -p{$password} {$database} < ./old_db/{$folder}/{$file}");

            if ($truncate) {
                DB::connection($database)->delete("delete from {$table}");
            }

            $bar->advance();

            echo "\n ------------- \n";

        }

        $bar->finish();

        die();
    }
}
