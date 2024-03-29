<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MargemLucro extends Controller
{
    public function index(){

        $item_buscar = $_GET['item_buscar'] ?? NULL;
        
        $sql = "SELECT 
                    *
                FROM custos_log";

        $itens_todos  = DB::connection('mysql')->select($sql);

        $sql = "SELECT 
                    *
                FROM custos_log
                WHERE 1";
        if($item_buscar){
            $sql = $sql." AND cod_item = $item_buscar";
        }

            $itens  = DB::connection('mysql')->select($sql);
        
        $sql = "SELECT * FROM parametros";
        $parametros =  DB::connection('mysql')->select($sql);

        $categorias = array();
        foreach ($itens as $key => $item) {
            $sql_preco = "SELECT TITENS.COD_ITEM
                                ,TITENS.DESC_TECNICA
                                ,TPRECOSVEN_IT.PRECO     AS PRECO_TABELA
                                ,TDESC_IPCMD.VLR_MAXIMO  AS VALOR_DESC
                                ,ROUND(TPRECOSVEN_IT.PRECO - ((TPRECOSVEN_IT.PRECO * TDESC_IPCMD.VLR_MAXIMO)/100),2) AS VALOR_C_DESC
                                ,TDESC_IPCMD.DESCRICAO tipo
                        FROM FOCCO3I.TPOLITICA_COM_DESC 
                            ,FOCCO3I.TITENS_PCMD
                            ,FOCCO3I.TDESC_IPCMD
                            ,FOCCO3I.TITENS_COMERCIAL
                            ,FOCCO3I.TITENS_EMPR
                            ,FOCCO3I.TITENS
                            ,FOCCO3I.TPRECOSVEN
                            ,FOCCO3I.TPRECOSVEN_IT
                        WHERE TITENS_PCMD.PCMD_ID         =  TPOLITICA_COM_DESC.ID
                        AND   TDESC_IPCMD.IPCMD_ID        =  TITENS_PCMD.ID
                        AND   TITENS_COMERCIAL.ID         =  TITENS_PCMD.ITCM_ID
                        AND   TITENS_COMERCIAL.ITEMPR_ID  =  TITENS_EMPR.ID
                        AND   TITENS.ID                   =  TITENS_EMPR.ITEM_ID
                        AND   TITENS_PCMD.TPRVEN_ID       =  TPRECOSVEN.ID
                        AND   TPRECOSVEN.ID               =  TPRECOSVEN_IT.TPRVEN_ID
                        AND   TPRECOSVEN_IT.ITCM_ID       =  TITENS_COMERCIAL.ID
                        AND   TDESC_IPCMD.DESCRICAO LIKE '%DESC COMISSÃO%'
                        AND   TPRECOSVEN.COD_PREVEN = 1
                        AND   TPRECOSVEN_IT.SIT = 1
                        AND   TITENS.COD_ITEM = $item->cod_item
                        --AND   RANKING = 80
                        ORDER BY DESC_TECNICA";
            
            $precos = DB::connection('oracle')->select($sql_preco);
            
            $item->preco_com_5 = NULL;
            $item->preco_com_4 = NULL;
            $item->preco_com_3 = NULL;
            foreach ($precos as $key => $preco) {
                if($preco->tipo == 'DESC COMISSÃO 5%')
                    $item->preco_com_5 = $preco->valor_c_desc ?? NULL;
                else if($preco->tipo == 'DESC COMISSÃO 4%')
                    $item->preco_com_4 = $preco->valor_c_desc ?? NULL;
                else if($preco->tipo == 'DESC COMISSÃO 3%')
                    $item->preco_com_3 = $preco->valor_c_desc ?? NULL;
            }
           
            $item->margem_manual_5 = NULL;
            $item->margem_focco_5 = NULL;

            $item->margem_manual_4 = NULL;
            $item->margem_focco_4 = NULL;

            $item->margem_manual_3 = NULL;
            $item->margem_focco_3 = NULL;

            $item->fator = 54.6;
            array_push($categorias,$item->categoria);

            $cod_itens_exceto = explode(',',$parametros[1]->valor);

            if(in_array($item->cod_item, $cod_itens_exceto)){
                $item->fator = $item->fator-$parametros[0]->valor;
            }

            if($item->preco_com_5){
                $item->margem_manual_5 = (( 100-($item->fator)-$item->custo_manual*100/$item->preco_com_5)/100)*100;

                $item->margem_focco_5 = (( 100-($item->fator)-$item->custo_focco*100/$item->preco_com_5)/100)*100;
            }

            if($item->preco_com_4){
                $item->margem_manual_4 = (( 100-($item->fator-1)-$item->custo_manual*100/$item->preco_com_4)/100)*100;

                $item->margem_focco_4 = (( 100-($item->fator-1)-$item->custo_focco*100/$item->preco_com_4)/100)*100;
            }

            if($item->preco_com_3){
                $item->margem_manual_3 = (( 100-($item->fator-2)-$item->custo_manual*100/$item->preco_com_3)/100)*100;

                $item->margem_focco_3 = (( 100-($item->fator-2)-$item->custo_focco*100/$item->preco_com_3)/100)*100;
            }

            if(!$item->preco_com_3 and !$item->preco_com_4 and !$item->preco_com_3){
                unset($itens[$key]);
            }
            
        }
        $categorias = array_unique($categorias);

        return view('margem_lucro', compact(["itens","categorias","itens_todos","item_buscar"]));
    }
}
