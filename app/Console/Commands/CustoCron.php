<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CustoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Custo';

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
     * @return int
     */
    public function handle()
    {
        DB::table('teste')->insert([
            'desc' => 'SHOW RAPAZ'
        ]);
        return 0;
    }
}

//* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1
