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
        $sql_lista_itens = "SELECT 
        COD_ITEM
        ,ITEM 
    FROM 
        FOCCO3I.LJ_VALOR_ITEM_CUSTO
    GROUP BY 
        COD_ITEM
        ,ITEM";

        $lista_itens  = DB::connection('oracle')->select($sql_lista_itens);
        
        //dd($lista_itens);
        foreach ($lista_itens as $key => $item) {
            dd($item);
        }
        //$this->info('Example Cron comando rodando com êxito');

        return 0;
    }
}

//* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1
