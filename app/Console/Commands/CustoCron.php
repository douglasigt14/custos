<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\CustoItemComercial;

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
        ,CATEGORIAS
    FROM 
        FOCCO3I.LJ_VALOR_ITEM_CUSTO
    WHERE
        ITEM NOT LIKE '--%'
    AND ITEM NOT LIKE '(P)%'
    GROUP BY 
        COD_ITEM
        ,ITEM
        ,CATEGORIAS";

        $lista_itens  = DB::connection('oracle')->select($sql_lista_itens);
        
        $id_masc = NULL;
        DB::table('custos_log')->delete();
        foreach ($lista_itens as $key => $item) {
            $sql_lista_cores = "SELECT 
                                    *
                                FROM 
                                    FOCCO3I.LJ_VALOR_ITEM_CUSTO
                                WHERE 
                                    COD_ITEM = '$item->cod_item'
                                ORDER BY VALOR_MAT DESC";

            $lista_cores  = DB::connection('oracle')->select($sql_lista_cores);
            $id_masc =  $lista_cores[0]->id_cor ?? NULL;
            $cor =  $lista_cores[0]->cor ?? NULL;

            $sql = "SELECT 
                        * 
                    FROM 
                        FOCCO3i.LJ_EST_SISTEMA_CUSTO 
                    WHERE  
                        codprodutopai = '$item->cod_item' 
                    AND idcorpai = '$id_masc'"; 

            $itens = DB::connection('oracle')->select($sql);
            
            $custoObj = new CustoItemComercial();
            $itens = $custoObj->percorrer_itens($itens);
            $itens = $custoObj->somar_custos($itens);

            $custo_item_focco = 0;
            $custo_item_futuro = 0;
            foreach ($itens as $key => $volume) {
                $custo_item_focco += $volume->custo_focco_soma;
                $custo_item_futuro += $volume->custo_futuro_soma;          
            }

            $this->info('ITEM: '.$item->cod_item.' | CUSTO FOCCO: '.number_format($custo_item_focco,4,'.','').' | CUSTO MANUAL: '.number_format($custo_item_futuro,4,'.','').' | '.$cor);


            DB::table('custos_log')->insert([
                'cod_item' => $item->cod_item,
                'descricao' => $item->item,
                'id_masc' => $id_masc,
                'categoria' => $item->categorias,
                'cor' => $cor,
                'custo_focco' => number_format($custo_item_focco,4,'.',''),
                'custo_manual' => number_format($custo_item_futuro,4,'.','')
            ]);
        }
        $this->info('Finalizado: Logs de Custos Criados');

        return 0;
    }

    
}

//* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1
