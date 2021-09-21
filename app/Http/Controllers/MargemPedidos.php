<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MargemPedidos extends Controller
{
    public function index(){
        $filtros = $_GET;


        $sql = "SELECT SUM((titens_pdv.qtde * titens_pdv.vlr_liq) - (titens_pdv.qtde * titens_pdv.vlr_desc_zf) - (titens_pdv.qtde  *titens_pdv.vlr_pis_zf) - (titens_pdv.qtde * titens_pdv.vlr_cofins_zf)
                - round(tpedidos_venda.vlr_desc_pdv - (select sum((titens_pdv.qtde * titens_pdv.vlr_pis_zf) + (titens_pdv.qtde * titens_pdv.vlr_desc_zf) + (titens_pdv.qtde * titens_pdv.vlr_cofins_zf))
                from FOCCO3I.titens_pdv  where titens_pdv.pdv_id = tpedidos_venda.id),3 ) / (select count(titens_pdv.num_item) from FOCCO3I.titens_pdv where tpedidos_venda.id   = titens_pdv.pdv_id)) valor
                ,tpedidos_venda.num_pedido
                ,titens.cod_item||'-'||titens_pdv.descricao  item
                ,TPEDIDOS_VENDA.DT_EMIS
            from FOCCO3I.tpedidos_venda
                ,FOCCO3I.titens_pdv
                ,FOCCO3I.tmasc_item
                ,FOCCO3I.testabelecimentos
                ,FOCCO3I.tcidades
                ,FOCCO3I.tclientes
                ,FOCCO3I.tclientes cliente
                ,FOCCO3I.tcli_vinc_cli
                ,FOCCO3I.tdivisoes_vendas
                ,FOCCO3I.titens_comercial
                ,FOCCO3I.titens_empr
                ,FOCCO3I.titens
                ,FOCCO3I.trepresentantes
                ,FOCCO3I.tgrp_clas_ite
                ,FOCCO3I.ttipos_nf
                ,FOCCO3I.temp_rep
                ,FOCCO3I.tufs
                ,FOCCO3I.temp_cli
                ,FOCCO3I.test_microreg
                ,FOCCO3I.tmicroregioes
                ,FOCCO3I.tregioes
                ,FOCCO3I.tcargas
                ,FOCCO3I.tplc_pdv
                ,FOCCO3I.LJ_CASE_REPRESENTANTES
            where  tpedidos_venda.id            =   titens_pdv.pdv_id
            and    LJ_CASE_REPRESENTANTES.ID    =   trepresentantes.id
            and    tpedidos_venda.cli_id        =   tclientes.id
            and    testabelecimentos.cli_id     =   tclientes.id
            and    cliente.id(+)                =   tcli_vinc_cli.cli_id_dest
            and    tcli_vinc_cli.id(+)          =   NVL(tpedidos_venda.cli_v_cli_id,tpedidos_venda.cli_id)
            and    test_microreg.est_id         =   testabelecimentos.id
            and    test_microreg.empcli_id      =   temp_cli.id
            and    test_microreg.mreg_id        =   tmicroregioes.id(+)
            and    tmicroregioes.reg_id         =   tregioes.id
            and    temp_cli.cli_id              =   tclientes.id
            and    tcidades.id                  =   testabelecimentos.cid_id
            and    tcidades.uf_id               =   tufs.id
            and    tpedidos_venda.divd_id       =   tdivisoes_vendas.id
            and    tpedidos_venda.rep_id        =   trepresentantes.id
            and    titens_pdv.itcm_id           =   titens_comercial.id
            and    titens_comercial.itempr_id   =   titens_empr.id
            and    titens_empr.item_id          =   titens.id
            and    tgrp_clas_ite.id             =   titens_comercial.grp_clas_id
            and    ttipos_nf.id                 =   titens_pdv.tpnf_id  
            and    temp_rep.rep_id              =   trepresentantes.id
            and    titens_pdv.tmasc_item_id     =   tmasc_item.id
            AND TPEDIDOS_VENDA.ID          =  TPLC_PDV.PDV_ID(+)
            AND TCARGAS.ID(+)              =  TPLC_PDV.PLC_ID 
            and    (temp_rep.ativo = 1)
            and    tdivisoes_vendas.cod_divd = 1
            and    testabelecimentos.cod_est = 1
            and    tpedidos_venda.pos_pdv <> 'C'
            and    (tgrp_clas_ite.cod_grp_ite LIKE '60%')
            and    (ttipos_nf.receita IN (1,2,81,82,13,71,157,158))";
        
        if(isset($filtros['dt_inicial']) and isset($filtros['dt_final'])){
            $dt_inicial_br =   $data = implode("/",array_reverse(explode("-",$filtros['dt_inicial'])));

            $dt_final_br =   $data = implode("/",array_reverse(explode("-",$filtros['dt_final'])));
            
            $sql = $sql." AND    TPEDIDOS_VENDA.DT_EMIS BETWEEN TO_DATE('$dt_inicial_br','DD/MM/RRRR') AND TO_DATE('$dt_final_br','DD/MM/RRRR')";
        }

        if(isset($filtros['num_pedido']) and $filtros['num_pedido'] != ''){
           $sql = $sql. " and tpedidos_venda.num_pedido = ".$filtros['num_pedido'];
        }

        $sql = $sql ." GROUP by
            tpedidos_venda.num_pedido
            ,titens.cod_item||'-'||titens_pdv.descricao
            ,TPEDIDOS_VENDA.DT_EMIS
        ORDER BY 2";

       $pedidos_itens = DB::connection('oracle')->select($sql);
       $pedidos = [];
       $pedidos_validations = [];
       foreach ($pedidos_itens as $key => $ped_itens) {
        if (in_array($ped_itens->num_pedido, $pedidos_validations)) { 
            $key = array_search($ped_itens->num_pedido, $pedidos_validations);
           array_push($pedidos[$key]['itens'], $ped_itens);
        }
        else{
            array_push($pedidos,['num_pedido' => $ped_itens->num_pedido, 
                                 'dt_emis' => $ped_itens->dt_emis,
            'itens' => [$ped_itens] ]);
            array_push($pedidos_validations, $ped_itens->num_pedido);
        }

       }   

        return view('margem_pedidos', compact(['filtros','pedidos']));;
    }
}
