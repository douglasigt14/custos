<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustoItemComercial extends Controller
{
    public function index(){

        $cod_item = $_GET['cod_item'] ?? NULL;
        $id_masc = $_GET['id_masc'] ?? NULL;


        $sql_lista_itens = "SELECT 
                                    COD_ITEM
                                    ,ITEM 
                                FROM 
                                    FOCCO3I.LJ_VALOR_ITEM_CUSTO
                                WHERE
                                    ITEM NOT LIKE '--%'
                                AND ITEM NOT LIKE '(P)%'
                                GROUP BY 
                                    COD_ITEM
                                    ,ITEM";

        $lista_itens  = DB::connection('oracle')->select($sql_lista_itens);

        $lista_cores = NULL;
        if($cod_item){
           $sql_lista_cores = "SELECT 
                                    *
                                FROM 
                                    FOCCO3I.LJ_VALOR_ITEM_CUSTO
                                WHERE 
                                    COD_ITEM = '$cod_item'
                                ORDER BY VALOR_MAT DESC";

            $lista_cores  = DB::connection('oracle')->select($sql_lista_cores);
        }

        $sql = "SELECT 
                    * 
                FROM 
                    FOCCO3i.LJ_EST_SISTEMA_CUSTO 
                WHERE  
                    codprodutopai = '$cod_item' 
                AND idcorpai = '$id_masc'"; 
        
        $itens = DB::connection('oracle')->select($sql);
        
        $itens = $this->percorrer_itens($itens);
        $itens = $this->somar_custos($itens);
        
        if($itens){
          //  dd($itens[0]->filhos);
        }
        
        $custo_item_focco = 0;
        $custo_item_futuro = 0;
        foreach ($itens as $key => $volume) {
            $custo_item_focco += $volume->custo_focco_soma;
            $custo_item_futuro += $volume->custo_futuro_soma;          
        }
        
        
        return view('custo_item_comercial', compact(["itens","custo_item_focco","custo_item_futuro","cod_item","id_masc","lista_itens","lista_cores"]));
    }
    
    public  function percorrer_itens($itens){
        foreach ($itens as $key => $pai) {
            $pai->custo_futuro = null;
            $pai->custo_futuro_soma = null;
            $pai->filhos = $this->busca_filhos($pai->codproduto, $pai->idcorfilho,$pai->idcorpai,$pai->tp);
            

            if($pai->filhos){
                foreach ($pai->filhos as $key => $filho) {
                    $filho->filhos = $this->busca_filhos($filho->codproduto, $filho->idcorfilho,$filho->idcorpai,$filho->tp);

                    if($filho->filhos){
                        foreach ($filho->filhos as $key => $neto) {
                            $neto->filhos = $this->busca_filhos($neto->codproduto, $neto->idcorfilho,$neto->idcorpai,$neto->tp);
                        
                            if($neto->filhos){
                                foreach ($neto->filhos as $key => $bisneto) {
                                    $bisneto->filhos = $this->busca_filhos($bisneto->codproduto, $bisneto->idcorfilho,$bisneto->idcorpai,$bisneto->tp); 
                                    
                                    if($bisneto->filhos){
                                        foreach ($bisneto->filhos as $key => $tataraneto) {
                                            $tataraneto->filhos = $this->busca_filhos($tataraneto->codproduto, $tataraneto->idcorfilho,$tataraneto->idcorpai,
                                            $tataraneto->tp); 
                                        }
                                    }
                                }
                            }
                            
                        }
                    }

                }
            }
        }

        return $itens;
    }

    public  function busca_filhos($codproduto,$idcorfilho,$idcorpai,$tp){
        
        $sql_f = NULL;

        // $sql_f = "SELECT 
        //                 * 
        //             FROM 
        //                 FOCCO3i.LJ_EST_SISTEMA_CUSTO
        //             WHERE  
        //                 codprodutopai = '$codproduto'";
                    
        //             if($idcorfilho){
        //                 $sql_f = $sql_f." AND idcorpai = '$idcorfilho'";
        //             }
        //             else{
        //                 $sql_f = $sql_f." AND idcorpai = '$idcorpai' ";
        //             }
            if($tp == 'N'){
            $sql_f = "SELECT 
                    * 
                FROM 
                    FOCCO3i.LJ_EST_SISTEMA_CUSTO 
                WHERE  
                    codprodutopai = '$codproduto'";

                if($idcorfilho){
                    $sql_f = $sql_f." AND idcorpai = '$idcorfilho'";
                }
                else{
                    $sql_f = $sql_f." AND idcorpai = '$idcorpai'";
                }
        }
        else if ($tp == 'F') {
            if($idcorfilho){
                $sql_f = "SELECT 
                        * 
                    FROM 
                        FOCCO3i.LJ_EST_SISTEMA_CUSTO_02 
                    WHERE  
                        codprodutopai = '$codproduto'";

                    if($idcorfilho){
                        $sql_f = $sql_f." AND idcorpai = '$idcorfilho'";
                    }
                    else{
                        $sql_f = $sql_f." AND idcorpai = 'NULL'";
                    }
            }
            else{
                $sql_f = "SELECT 
                * 
                    FROM 
                        FOCCO3i.LJ_EST_SISTEMA_CUSTO 
                    WHERE  
                        codprodutopai = '$codproduto'";

                    if($idcorfilho){
                        $sql_f = $sql_f." AND idcorpai = '$idcorfilho'";
                    }
                    else{
                        $sql_f = $sql_f." AND idcorpai = '$idcorpai'";
                    }
            }

        }
        
            $filhos = DB::connection('oracle')->select($sql_f);
        
        if($filhos){
            foreach ($filhos as $key => $filho) {
                $custos_futuros = $this->buscar_custo_futuro($filho->codproduto);

                $filho->custo_futuro = $custos_futuros ? $custos_futuros[0]->valor : NULL;

                $filho->custo_futuro_soma =  NULL;
                $filho->custo_focco_soma =  NULL;
            }
            return $filhos;
        }
        else{
            return [];
        }


    }   

    

    public  function somar_custos($itens){
        foreach ($itens as $key => $pai) {
            
            $pai->custo_futuro_soma = 0;
            $pai->custo_focco_soma = 0;

            if($pai->filhos){
                foreach ($pai->filhos as $key => $filho) {
                        $filho->custo_futuro_soma = 0;
                        $filho->custo_focco_soma = 0;
                        
                        if($filho->custo_futuro){
                            $filho->custo_futuro_soma +=  (
                            $filho->custo_futuro
                            *$filho->qtde
                            *$pai->qtde) ;

                        
                            $filho->custo_focco_soma +=  (
                            $filho->valor_filho
                            *$filho->qtde
                            *$pai->qtde) ;
                        }

                    if($filho->filhos){
                        
                        foreach ($filho->filhos as $key => $neto) {
                           
                            $filho->custo_futuro_soma +=  ($neto->custo_futuro*$neto->qtde
                            *$filho->qtde
                            *$pai->qtde) ;

                            if($neto->custo_futuro){
                                $filho->custo_focco_soma +=  ($neto->valor_filho*$neto->qtde
                                *$filho->qtde
                                *$pai->qtde) ;
                            }

                            if($neto->filhos){
                                foreach ($neto->filhos as $key => $bisneto) {
                                        $filho->custo_futuro_soma += ($bisneto->custo_futuro
                                        *$bisneto->qtde
                                        *$neto->qtde
                                        *$filho->qtde
                                        *$pai->qtde);

                                        if($bisneto->custo_futuro){
                                            $filho->custo_focco_soma += ($bisneto->valor_filho
                                            *$bisneto->qtde
                                            *$neto->qtde
                                            *$filho->qtde
                                            *$pai->qtde);
                                        }

                                    if($bisneto->filhos){
                                        foreach ($bisneto->filhos as $key => $tataraneto) {
                                            $filho->custo_futuro_soma += ($tataraneto->custo_futuro
                                            *$tataraneto->qtde
                                            *$bisneto->qtde
                                            *$neto->qtde
                                            *$filho->qtde
                                            *$pai->qtde);

                                            if($tataraneto->custo_futuro){
                                                $filho->custo_focco_soma += ($tataraneto->valor_filho
                                                *$tataraneto->qtde
                                                *$bisneto->qtde
                                                *$neto->qtde
                                                *$filho->qtde
                                                *$pai->qtde);
                                            }
                                        }
                                    }
                                }
                            }
                            
                        }
                    }

                    $pai->custo_futuro_soma += $filho->custo_futuro_soma;
                    $pai->custo_focco_soma += $filho->custo_focco_soma;
                }
            }
        }

        return $itens;
    }


    public function buscar_custo_futuro($codproduto){
        $sql = "SELECT valor FROM custos_futuros WHERE cod_item = $codproduto";
        $custos_futuros = DB::connection('mysql')->select($sql);

        return $custos_futuros;
    }
}
