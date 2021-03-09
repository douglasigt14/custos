<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MateriasPrimas extends Controller
{
    public function index(){
        $sqlItens = "SELECT 
        TITENS.COD_ITEM
        ,TITENS.DESC_TECNICA
        ,TITENS_CUSTOS.VLR_CST_MAT_DIR CUSTO
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
    AND TITENS_CUSTOS.VLR_CST_MAT_DIR <> 0
    AND TITENS.DESC_TECNICA NOT LIKE '--%'
    AND TITENS.DESC_TECNICA NOT LIKE '(P)%'
    AND TITENS_CUSTOS.DT_ATUALIZA BETWEEN SYSDATE-1095 AND SYSDATE  
    --AND TITENS.COD_ITEM = 8203
    ORDER BY TGRP_CLAS_ITE.COD_GRP_ITE";
        $itens = DB::connection('oracle')->select($sqlItens);

    foreach ($itens as $key => $item) {
        $sql = "SELECT valor FROM custos_futuros WHERE cod_item = $item->cod_item";
        $custos_futuros = DB::connection('mysql')->select($sql);
        $item->custo_futuro = $custos_futuros ? $custos_futuros[0]->valor : $item->custo;
    }

        return view('materias_primas', compact(['itens']));
    }
}
