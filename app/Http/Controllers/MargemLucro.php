<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MargemLucro extends Controller
{
    public function index(){
        $sql = "SELECT 
                    *
                FROM custos_log";

            $itens  = DB::connection('mysql')->select($sql);

        $itens_sem_valor = [];
        foreach ($itens as $key => $item) {
            $sql_preco = "SELECT TITENS.COD_ITEM
                                ,TITENS.DESC_TECNICA
                                ,TPRECOSVEN_IT.PRECO     AS PRECO_TABELA
                                ,TDESC_IPCMD.VLR_MAXIMO  AS VALOR_DESC
                                ,ROUND(TPRECOSVEN_IT.PRECO - ((TPRECOSVEN_IT.PRECO * TDESC_IPCMD.VLR_MAXIMO)/100),2) AS VALOR_C_DESC
                        FROM TPOLITICA_COM_DESC 
                            ,TITENS_PCMD
                            ,TDESC_IPCMD
                            ,TITENS_COMERCIAL
                            ,TITENS_EMPR
                            ,TITENS
                            ,TPRECOSVEN
                            ,TPRECOSVEN_IT
                        WHERE TITENS_PCMD.PCMD_ID         =  TPOLITICA_COM_DESC.ID
                        AND   TDESC_IPCMD.IPCMD_ID        =  TITENS_PCMD.ID
                        AND   TITENS_COMERCIAL.ID         =  TITENS_PCMD.ITCM_ID
                        AND   TITENS_COMERCIAL.ITEMPR_ID  =  TITENS_EMPR.ID
                        AND   TITENS.ID                   =  TITENS_EMPR.ITEM_ID
                        AND   TITENS_PCMD.TPRVEN_ID       =  TPRECOSVEN.ID
                        AND   TPRECOSVEN.ID               =  TPRECOSVEN_IT.TPRVEN_ID
                        AND   TPRECOSVEN_IT.ITCM_ID       =  TITENS_COMERCIAL.ID
                        AND   TDESC_IPCMD.DESCRICAO LIKE '%DESC COMISSÃO 5%'
                        AND   TPRECOSVEN.COD_PREVEN = 1
                        AND   TPRECOSVEN_IT.SIT = 1
                        AND   TITENS.COD_ITEM = $item->cod_item
                        --AND   RANKING = 80
                        ORDER BY DESC_TECNICA";
            
            $precos = DB::connection('oracle')->select($sql_preco);
            
            $item->preco_com_5 = $precos[0]->valor_c_desc ?? NULL;

            if(!$item->preco_com_5){
                unset($itens[$key]);
            }
            else{
                $item->margem_manual = (( 100-54.6-$item->custo_manual*100/$item->preco_com_5)/100)*100;

                $item->margem_focco = (( 100-54.6-$item->custo_focco*100/$item->preco_com_5)/100)*100;
            }
        }

        return view('margem_lucro', compact(["itens"]));
    }
}
