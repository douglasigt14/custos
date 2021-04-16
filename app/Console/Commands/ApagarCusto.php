<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ApagarCusto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custo:apagar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apagar Custo Manual';

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
        DB::table('custos_futuros')->delete();
        return 0;
    }
}
