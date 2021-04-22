<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AvaliacaoCusto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custo:avaliacao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Custo Avaliação';

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
        return 0;
    }
}
