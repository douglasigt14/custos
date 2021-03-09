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
        ,TITENS_CUSTOS.VLR_CST_MAT_DIR VALOR
        ,TGRP_CLAS_ITE.COD_GRP_ITE
        ,TGRP_CLAS_ITE.DESCRICAO
        ,TITENS_CUSTOS.DT_ATUALIZA
    FROM
         FOCCO3I.TITENS
        ,FOCCO3I.TITENS_EMPR
        ,FOCCO3I.TITENS_CUSTOS
        ,FOCCO3I.TGRP_CLAS_ITE
        ,FOCCO3I.TITENS_ENGENHARIA
    WHERE
        TITENS_EMPR.ITEM_ID         =  TITENS.ID
    AND TITENS_EMPR.ID              =  TITENS_CUSTOS.ITEMPR_ID  
    AND TGRP_CLAS_ITE.ID            =  TITENS_CUSTOS.GRP_CLAS_ID
    AND TITENS_ENGENHARIA.ITEMPR_ID = TITENS_EMPR.ID
    AND (  TGRP_CLAS_ITE.COD_GRP_ITE LIKE '10.01%'
        OR TGRP_CLAS_ITE.COD_GRP_ITE LIKE '10.02%'
        OR TGRP_CLAS_ITE.COD_GRP_ITE LIKE '10.03%')
    AND   (TITENS.SIT = 1)
    AND TITENS_CUSTOS.VLR_CST_MAT_DIR <> 0
    AND TITENS.DESC_TECNICA NOT LIKE '--%'
    AND TITENS_CUSTOS.DT_ATUALIZA BETWEEN SYSDATE-730 AND SYSDATE  
    --AND TITENS.COD_ITEM = 8203
    ORDER BY TGRP_CLAS_ITE.COD_GRP_ITE";
        $itens = DB::connection('oracle')->select($sqlItens);

        return view('materias_primas', compact(['itens']));
    }
}
