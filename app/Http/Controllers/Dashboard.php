<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Dashboard extends Controller
{
    public function index(){
        $sqlItens = "SELECT 
          COUNT(*) QTDE
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
    ORDER BY TGRP_CLAS_ITE.COD_GRP_ITE";
        $itens = DB::connection('oracle')->select($sqlItens);
        $qtde = (object) ['materias_primas' => $itens[0]->qtde ]; 
        
        return view('pagina_inicial', compact(["qtde"]));
    }
}
