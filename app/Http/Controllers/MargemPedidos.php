<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MargemPedidos extends Controller
{
    public function index(){
        $filtros = $_GET;


        $sql = "SELECT  CLI.COD_CLI
                ,CLI.DESCRICAO
                ,PDV.EMPR_ID
                ,PDV.NUM_PEDIDO
                ,NFS.NUM_NF
                ,NFS.VLR_TOTAL_FATURADO VLR_TOTAL_NF
                ,NFS.DT_EMIS  AS DT_FAT
                ,IT.COD_ITEM
                ,IT.DESC_TECNICA ITEM
                ,ITNFS.QTDE
                ,ITNFS.VLR_TOTAL_FATURADO VLR_FT_ITEM
        FROM FOCCO3I.TNFS_SAIDA NFS,
            FOCCO3I.TITENS_NFS ITNFS,
            FOCCO3I.THIST_MOV_ITE_PDV HIST,
            FOCCO3I.TITENS_PDV ITPDV,
            FOCCO3I.TPEDIDOS_VENDA PDV,
            FOCCO3I.TCLIENTES CLI,
            FOCCO3I.TITENS_COMERCIAL ITCM,
            FOCCO3I.TITENS_EMPR ITEMP,
            FOCCO3I.TITENS IT,  
            FOCCO3I.TDIVISOES_VENDAS DIV                  
        WHERE ITPDV.PDV_ID  = PDV.ID
        AND HIST.ITPDV_ID = ITPDV.ID
        AND ITNFS.ID = HIST.ITNFS_ID
        AND NFS.ID   = ITNFS.NFS_ID
        AND CLI.ID   = NFS.CLI_ID
        AND CLI.ID   = PDV.CLI_ID
        AND CLI.ID   = NFS.CLI_ID
        AND ITCM.ID  = ITPDV.ITCM_ID
        AND ITEMP.ID = ITCM.ITEMPR_ID
        AND IT.ID    = ITEMP.ITEM_ID
        AND DIV.ID   = PDV.DIVD_ID
        AND HIST.TP  = 'A'
        AND DIV.COD_DIVD = 1";
        
        $is_filtro = false;
        if(isset($filtros['dt_inicial']) and isset($filtros['dt_final'])){
            $dt_inicial_br = implode("/",array_reverse(explode("-",$filtros['dt_inicial'])));

            $dt_final_br = implode("/",array_reverse(explode("-",$filtros['dt_final'])));
            
            $sql = $sql." AND NFS.DT_EMIS BETWEEN TO_DATE('$dt_inicial_br','DD/MM/RRRR') AND TO_DATE('$dt_final_br','DD/MM/RRRR')";
            $is_filtro = true;
        }
        if(isset($filtros['num_pedido']) and $filtros['num_pedido'] != ''){
           $sql = $sql. " and PDV.num_pedido = ".$filtros['num_pedido'];
           $is_filtro = true;
        }

       $pedidos_itens = $is_filtro ?  DB::connection('oracle')->select($sql) : [] ;
        $pedidos = [];
       $pedidos_validations = [];
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

            if (in_array($ped_itens->num_pedido, $pedidos_validations)) { 
                $key = array_search($ped_itens->num_pedido, $pedidos_validations);
            array_push($pedidos[$key]['itens'], $ped_itens);
            }
            else{
                $partes = explode(" ",$ped_itens->dt_fat);
                $dt_fat = implode("/",array_reverse(explode("-",$partes[0])));

                array_push($pedidos,['num_pedido' => $ped_itens->num_pedido, 
                                    'dt_fat' => $dt_fat,
                'itens' => [$ped_itens] ]);
                array_push($pedidos_validations, $ped_itens->num_pedido);
            }

       }   
       //dd($pedidos);

        return view('margem_pedidos', compact(['filtros','pedidos']));;
    }
}
