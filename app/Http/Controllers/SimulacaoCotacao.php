<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SimulacaoCotacao extends Controller
{
    public function index(){
        $cliente_selected = $_GET['cliente_selected'] ?? NULL;

        $dt_inicial = date('Y-m-d');

        $dt_final = date('Y').'-12-31';

        $sqlClientes = "SELECT TCLIENTES1.COD_CLI COD_CLI,
        TCLIENTES1.COD_CLI||'-'||TCLIENTES1.DESCRICAO COD_E_DESCRICAO,
        TREPRESENTANTES.COD_REP||'-'||TREPRESENTANTES.DESCRICAO REPRESENTANTE
   FROM focco3i.TCLI_VINC_CLI TCLI_VINC_CLI,
        focco3i.TCLIENTES TCLIENTES1,
        focco3i.TESTABELECIMENTOS TESTABELECIMENTOS,
       -- focco3i.TCLIENTES TCLIENTES,
        focco3i.TEMP_CLI TEMP_CLI,
        focco3i.TEST_REP TEST_REP,
        focco3i.TREPRESENTANTES TREPRESENTANTES,
        focco3i.TCIDADES TCIDADES,
        focco3i.TEST_MICROREG TEST_MICROREG,
        focco3i.TMICROREGIOES TMICROREGIOES,
        focco3i.TREGIOES TREGIOES,
        focco3i.TEMP_EST TEMP_EST,
        focco3i.TUFS TUFS
  WHERE TCLIENTES1.ID = TCLI_VINC_CLI.CLI_ID_DEST
    --AND TCLIENTES.ID = TCLI_VINC_CLI.CLI_ID_ORIG
    AND TCLIENTES1.ID = TESTABELECIMENTOS.CLI_ID
    AND TCIDADES.ID = TESTABELECIMENTOS.CID_ID
    AND TCLIENTES1.ID = TEMP_CLI.CLI_ID
    AND TREPRESENTANTES.ID = TEST_REP.REP_ID
    AND TEMP_CLI.ID = TEST_REP.EMPCLI_ID
    AND TESTABELECIMENTOS.ID = TEST_REP.EST_ID
    AND TUFS.ID = TCIDADES.UF_ID
    AND TMICROREGIOES.ID = TEST_MICROREG.MREG_ID
    AND TESTABELECIMENTOS.ID = TEST_MICROREG.EST_ID
    AND TEMP_CLI.ID = TEST_MICROREG.EMPCLI_ID
    AND TREGIOES.ID = TMICROREGIOES.REG_ID
    AND TEMP_CLI.ID = TEMP_EST.EMPCLI_ID
    AND TESTABELECIMENTOS.ID = TEMP_EST.EST_ID
    AND (TESTABELECIMENTOS.COD_EST = 1)
    AND (TESTABELECIMENTOS.TP_PES = 'J')
    AND (TEMP_CLI.ATIVO = 1)
    AND (TEMP_EST.ATIVO = 1)
    AND (TCLI_VINC_CLI.ATIVO = 1)
    AND (TEST_REP.RANKING = 1)
    AND TEMP_CLI.EMPR_ID = 1
 GROUP BY 
     TCLIENTES1.COD_CLI,
        TCLIENTES1.COD_CLI||'-'||TCLIENTES1.DESCRICAO,
        TREPRESENTANTES.COD_REP||'-'||TREPRESENTANTES.DESCRICAO";
     
     $sql_itens = "SELECT TITENS.COD_ITEM
                        ,TITENS.COD_ITEM||'-'||TITENS.DESC_TECNICA DESCRICAO
                    ,REPLACE(TPRECOSVEN_IT.PRECO,',','.') PRECO
                    ,TPRECOSVEN.ID
                    FROM focco3i.TPRECOSVEN
                    ,focco3i.TPRECOSVEN_IT 
                    ,focco3i.TITENS_EMPR
                    ,focco3i.TITENS_COMERCIAL
                    ,focco3i.TITENS
                    ,focco3i.TGRP_CLAS_ITE
                    WHERE TPRECOSVEN.ID          =  TPRECOSVEN_IT.TPRVEN_ID
                    AND TITENS_EMPR.ID         =  TITENS_COMERCIAL.ITEMPR_ID
                    AND TPRECOSVEN_IT.ITCM_ID  =  TITENS_COMERCIAL.ID 
                    AND TITENS.ID              =  TITENS_EMPR.ITEM_ID
                    AND TGRP_CLAS_ITE.ID       =  TITENS_COMERCIAL.GRP_CLAS_ID
                    AND TGRP_CLAS_ITE.COD_GRP_ITE LIKE '60%'
                    AND TPRECOSVEN.COD_PREVEN IN (1,9005)
                    AND TPRECOSVEN_IT.SIT = 1";

        $itens =  DB::connection('oracle')->select($sql_itens);
    
        foreach ($itens as $key => $item) {
            $sql = "SELECT 
                        *
                    FROM custos_log
                    WHERE 
                        cod_item = $item->cod_item";

            $custos_log  = DB::connection('mysql')->select($sql);

            $item->custo_atual = $custos_log[0]->custo_manual ?? NULL;
            $item->custo_futuro = $custos_log[0]->custo_focco ?? NULL;
            $item->categoria = $custos_log[0]->categoria ?? NULL;
        }

     $clientes = DB::connection('oracle')->select($sqlClientes);
        return view('simulacao_cotacao', compact(['clientes','cliente_selected','dt_inicial','dt_final']));
    }
    public function buscar_clientes_info($cod_cli = null){
        $cliente_selected = $_GET['cliente_selected'] ?? NULL;

        $sqlClientes = "SELECT TCLIENTES1.COD_CLI COD_CLI,
        TCLIENTES1.COD_CLI||'-'||TCLIENTES1.DESCRICAO COD_E_DESCRICAO,
        TREPRESENTANTES.COD_REP||'-'||TREPRESENTANTES.DESCRICAO REPRESENTANTE
   FROM focco3i.TCLI_VINC_CLI TCLI_VINC_CLI,
        focco3i.TCLIENTES TCLIENTES1,
        focco3i.TESTABELECIMENTOS TESTABELECIMENTOS,
       -- focco3i.TCLIENTES TCLIENTES,
        focco3i.TEMP_CLI TEMP_CLI,
        focco3i.TEST_REP TEST_REP,
        focco3i.TREPRESENTANTES TREPRESENTANTES,
        focco3i.TCIDADES TCIDADES,
        focco3i.TEST_MICROREG TEST_MICROREG,
        focco3i.TMICROREGIOES TMICROREGIOES,
        focco3i.TREGIOES TREGIOES,
        focco3i.TEMP_EST TEMP_EST,
        focco3i.TUFS TUFS
  WHERE TCLIENTES1.ID = TCLI_VINC_CLI.CLI_ID_DEST
    --AND TCLIENTES.ID = TCLI_VINC_CLI.CLI_ID_ORIG
    AND TCLIENTES1.ID = TESTABELECIMENTOS.CLI_ID
    AND TCIDADES.ID = TESTABELECIMENTOS.CID_ID
    AND TCLIENTES1.ID = TEMP_CLI.CLI_ID
    AND TREPRESENTANTES.ID = TEST_REP.REP_ID
    AND TEMP_CLI.ID = TEST_REP.EMPCLI_ID
    AND TESTABELECIMENTOS.ID = TEST_REP.EST_ID
    AND TUFS.ID = TCIDADES.UF_ID
    AND TMICROREGIOES.ID = TEST_MICROREG.MREG_ID
    AND TESTABELECIMENTOS.ID = TEST_MICROREG.EST_ID
    AND TEMP_CLI.ID = TEST_MICROREG.EMPCLI_ID
    AND TREGIOES.ID = TMICROREGIOES.REG_ID
    AND TEMP_CLI.ID = TEMP_EST.EMPCLI_ID
    AND TESTABELECIMENTOS.ID = TEMP_EST.EST_ID
    AND (TESTABELECIMENTOS.COD_EST = 1)
    AND (TESTABELECIMENTOS.TP_PES = 'J')
    AND (TEMP_CLI.ATIVO = 1)
    AND (TEMP_EST.ATIVO = 1)
    AND (TCLI_VINC_CLI.ATIVO = 1)
    AND (TEST_REP.RANKING = 1)
    AND TEMP_CLI.EMPR_ID = 1
    AND TCLIENTES1.COD_CLI = $cod_cli
 GROUP BY 
     TCLIENTES1.COD_CLI,
        TCLIENTES1.COD_CLI||'-'||TCLIENTES1.DESCRICAO,
        TREPRESENTANTES.COD_REP||'-'||TREPRESENTANTES.DESCRICAO";

     $clientes = DB::connection('oracle')->select($sqlClientes);
     $dados_cliente =  $clientes[0] ?? NULL;
    
     return json_encode($dados_cliente);
    }
}
