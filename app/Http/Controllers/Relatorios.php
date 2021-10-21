<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Relatorios extends Controller
{
    public function rel_itens_reajustados(){
        $sqlItens = "SELECT 
        TITENS.COD_ITEM
        ,TITENS.DESC_TECNICA
        ,ROUND(TITENS_CUSTOS.VLR_CST_MAT_DIR,4) CUSTO
        ,TGRP_CLAS_ITE.COD_GRP_ITE
        ,TGRP_CLAS_ITE.DESCRICAO CLASS_DESC
        ,TITENS_CUSTOS.DT_ATUALIZA
        ,TUNID_MED.COD_UNID_MED UNID_MED
    FROM
         FOCCO3I.TITENS
        ,FOCCO3I.TITENS_EMPR
        ,FOCCO3I.TITENS_CUSTOS
        ,FOCCO3I.TGRP_CLAS_ITE
        ,FOCCO3I.TITENS_ESTOQUE
        ,FOCCO3I.TUNID_MED
    WHERE
        TITENS_EMPR.ITEM_ID         =  TITENS.ID
    AND TITENS_EMPR.ID              =  TITENS_CUSTOS.ITEMPR_ID  
    AND TGRP_CLAS_ITE.ID            =  TITENS_CUSTOS.GRP_CLAS_ID
    AND TITENS_ESTOQUE.ITEMPR_ID = TITENS_EMPR.ID
    AND TITENS_ESTOQUE.UNID_MED_ID = TUNID_MED.ID
    AND (  TGRP_CLAS_ITE.COD_GRP_ITE LIKE '10.01%'
        OR TGRP_CLAS_ITE.COD_GRP_ITE LIKE '10.02%'
        OR TGRP_CLAS_ITE.COD_GRP_ITE LIKE '10.03%')
    AND   (TITENS.SIT = 1)
    AND TITENS_EMPR.EMPR_ID = 1
    AND TITENS_CUSTOS.VLR_CST_MAT_DIR <> 0
    AND TITENS.DESC_TECNICA NOT LIKE '--%'
    AND TITENS.DESC_TECNICA NOT LIKE '(P)%'
    AND TITENS_CUSTOS.OBSER =  1
    ORDER BY TITENS.DESC_TECNICA";
        $itens = DB::connection('oracle')->select($sqlItens);
    
    $lista_class_desc = array();

    foreach ($itens as $key => $item) {
        $sql = "SELECT valor FROM custos_futuros WHERE cod_item = $item->cod_item";
        $custos_futuros = DB::connection('mysql')->select($sql);

        $item->custo_futuro = $custos_futuros ? $custos_futuros[0]->valor : $item->custo;

        $sqlFor = "SELECT fornecedor FROM fornecedores WHERE cod_item = $item->cod_item";
        $fornecedor = DB::connection('mysql')->select($sqlFor);
        $item->fornecedor = $fornecedor[0]->fornecedor ?? NULL;
        
        $perc = ($item->custo / $item->custo_futuro *100)-100;
        $item->perc = number_format( $perc,2,',','.');

        $reload = false;
        if($custos_futuros){
            // if($custos_futuros[0]->valor < $item->custo){
            //     DB::table('custos_futuros')
            //     ->where('cod_item', $item->cod_item)
            //     ->update([
            //             'valor' => $item->custo
            //     ]);
            // }
        }
        else{
            DB::table('custos_futuros')->insert([
                'cod_item' => $item->cod_item,
                'valor' => $item->custo
            ]);
        }

        $custos_futuros = DB::connection('mysql')->select($sql);

        $item->custo_futuro = $custos_futuros ? $custos_futuros[0]->valor : $item->custo;
        
        $perc = ($item->custo / $item->custo_futuro *100)-100;
        $item->perc = number_format( $perc,2,',','.');
        
        $item->custo_futuro = number_format($item->custo_futuro,4,',','.');
        $item->custo = number_format($item->custo,4,',','.');


        $item->cor_perc = '';
        if($perc > 0 ){
            $item->cor_perc = 'perc-aumento';
        }
        else if ($perc < 0) {
            $item->cor_perc = 'perc-desconto';
        }	
        else{
            $item->cor_perc = 'perc-zerado';
            unset($itens[$key]);
        }
        $item->class_desc = str_replace("_"," ",$item->class_desc);

        array_push($lista_class_desc, $item->class_desc);
    }
    $lista_class_desc = array_unique($lista_class_desc);

        return view('relatorios.rel_itens_reajustados',compact(["itens","lista_class_desc"]));
    }
}
