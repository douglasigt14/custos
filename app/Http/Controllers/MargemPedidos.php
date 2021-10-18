<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MargemPedidos extends Controller
{
    public function index(){
        $filtros = $_GET;


        $sql = "SELECT TCLIENTES.COD_CLI
        ,TCLIENTES.DESCRICAO CLIENTE
        ,TPEDIDOS_VENDA.NUM_PEDIDO
        ,THIST_MOV_ITE_PDV.DT AS DT_FAT
        ,TITENS.COD_ITEM
        ,TITENS.DESC_TECNICA ITEM
        ,TMASC_ITEM.MASCARA
        ,TITENS_PDV.QTDE
        ,TITENS_PDV.PERC_COMIS
        ,TPEDIDOS_VENDA.VLR_LIQ
        ,ROUND(SUM((TITENS_PDV.QTDE * TITENS_PDV.VLR_LIQ) - (TITENS_PDV.QTDE * TITENS_PDV.VLR_DESC_ZF) - (TITENS_PDV.QTDE * TITENS_PDV.VLR_PIS_ZF) - (TITENS_PDV.QTDE * TITENS_PDV.VLR_COFINS_ZF)
         - ROUND(TPEDIDOS_VENDA.VLR_DESC_PDV - (SELECT SUM((TITENS_PDV.QTDE * TITENS_PDV.VLR_PIS_ZF) + (TITENS_PDV.QTDE * TITENS_PDV.VLR_DESC_ZF) + (TITENS_PDV.QTDE * TITENS_PDV.VLR_COFINS_ZF))
         FROM FOCCO3I.TITENS_PDV  WHERE TITENS_PDV.PDV_ID = TPEDIDOS_VENDA.ID),3 ) / (SELECT COUNT(TITENS_PDV.NUM_ITEM) FROM FOCCO3I.TITENS_PDV WHERE TPEDIDOS_VENDA.ID   = TITENS_PDV.PDV_ID)),2) vlr_ft_item
    FROM FOCCO3I.TPEDIDOS_VENDA
        ,FOCCO3I.TITENS_PDV
        ,FOCCO3I.TITENS_COMERCIAL
        ,FOCCO3I.TITENS_EMPR
        ,FOCCO3I.TMASC_ITEM
        ,FOCCO3I.TITENS
        ,FOCCO3I.TDIVISOES_VENDAS
        ,FOCCO3I.TCLIENTES
        ,FOCCO3I.THIST_MOV_ITE_PDV
   WHERE TPEDIDOS_VENDA.ID   = TITENS_PDV.PDV_ID
     AND TCLIENTES.ID        = TPEDIDOS_VENDA.CLI_ID
     AND TDIVISOES_VENDAS.ID = TPEDIDOS_VENDA.DIVD_ID
     AND TITENS_COMERCIAL.ID = TITENS_PDV.ITCM_ID
     AND TITENS_EMPR.ID      = TITENS_COMERCIAL.ITEMPR_ID
     AND TITENS.ID           = TITENS_EMPR.ITEM_ID
     AND TITENS_PDV.ID       = THIST_MOV_ITE_PDV.ITPDV_ID
     AND TMASC_ITEM.ID       = TITENS_PDV.TMASC_ITEM_ID
     AND TPEDIDOS_VENDA.POS_PDV = 'A'
     AND TDIVISOES_VENDAS.COD_DIVD = 1";
        
        $is_filtro = false;
        if(isset($filtros['dt_inicial']) and isset($filtros['dt_final']) and $filtros['dt_inicial'] != '' and $filtros['dt_final'] != '' ){
            $dt_inicial_br = implode("/",array_reverse(explode("-",$filtros['dt_inicial'])));

            $dt_final_br = implode("/",array_reverse(explode("-",$filtros['dt_final'])));
            
            $sql = $sql." AND THIST_MOV_ITE_PDV.DT BETWEEN TO_DATE('$dt_inicial_br','DD/MM/RRRR') AND TO_DATE('$dt_final_br','DD/MM/RRRR')";
            $is_filtro = true;
        }
        if(isset($filtros['num_pedido']) and $filtros['num_pedido'] != ''){
           $sql = $sql. " and TPEDIDOS_VENDA.NUM_PEDIDO IN (".$filtros['num_pedido'].")";
           $is_filtro = true;
        }

        $sql = $sql." GROUP BY TCLIENTES.COD_CLI
        ,TCLIENTES.DESCRICAO
        ,TPEDIDOS_VENDA.NUM_PEDIDO
        ,THIST_MOV_ITE_PDV.DT
        ,TITENS.COD_ITEM
        ,TITENS_PDV.PERC_COMIS
        ,TPEDIDOS_VENDA.VLR_LIQ
        ,TITENS.DESC_TECNICA
        ,TMASC_ITEM.MASCARA
        ,TITENS_PDV.QTDE";

       $pedidos_itens = $is_filtro ?  DB::connection('oracle')->select($sql) : [] ;
        $pedidos = [];
       $pedidos_validations = [];

       $sql = "SELECT * FROM parametros";
       $parametros =  DB::connection('mysql')->select($sql);

       foreach ($pedidos_itens as $key => $ped_itens) {
            $cod_item = $ped_itens->cod_item;
            
            $sql = "SELECT 
                        *
                    FROM custos_log
                    WHERE 
                        cod_item = $cod_item";

            $custos_log  = DB::connection('mysql')->select($sql);

            $ped_itens->custo_atual = $custos_log[0]->custo_manual ?? NULL;
            $ped_itens->custo_futuro = $custos_log[0]->custo_focco ?? NULL;
            $ped_itens->categoria = $custos_log[0]->categoria ?? NULL;

            

            $ped_itens->fator = 54.6;
            $ped_itens->fator = $ped_itens->fator - (5-$ped_itens->perc_comis);
            //Itens que tira os 
            $cod_itens_exceto = explode(',',$parametros[1]->valor);

            if(in_array($cod_item, $cod_itens_exceto) ){
                $ped_itens->fator = $ped_itens->fator-$parametros[0]->valor;
            }

            $ped_itens->margem_atual = (( 100-($ped_itens->fator)-$ped_itens->custo_atual*100/($ped_itens->vlr_ft_item/$ped_itens->qtde))/100)*100;

            $ped_itens->margem_futuro = (( 100-($ped_itens->fator)-$ped_itens->custo_futuro*100/ ($ped_itens->vlr_ft_item/$ped_itens->qtde))/100)*100;

            if(isset( $filtros['ml']) and  $filtros['ml'] != '' ){
                if($ped_itens->margem_atual >= $filtros['ml']){
                    continue;
                }
            }
            
            if (in_array($ped_itens->num_pedido, $pedidos_validations)) { 
                $key = array_search($ped_itens->num_pedido, $pedidos_validations);
            array_push($pedidos[$key]['itens'], $ped_itens);
            }
            else{
                $partes = explode(" ",$ped_itens->dt_fat);
                $dt_fat = implode("/",array_reverse(explode("-",$partes[0])));

                array_push($pedidos,['num_pedido' => $ped_itens->num_pedido, 
                                    'dt_fat' => $dt_fat,
                                    'vlr_liq' => $ped_itens->vlr_liq,
                                    'cliente' => $ped_itens->cod_cli.'-'.$ped_itens->cliente,
                'itens' => [$ped_itens] ]);
                array_push($pedidos_validations, $ped_itens->num_pedido);
            }
       }   

        return view('margem_pedidos', compact(['filtros','pedidos']));;
    }
}
