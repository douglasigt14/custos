<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustoItemComercial extends Controller
{
    public function index(){
        $sql = "SELECT 
                    * 
                FROM 
                    FOCCO3i.LJ_EST_SISTEMA_CUSTO 
                WHERE  
                    codprodutopai = '6572' 
                AND idcorpai = '61239'"; 
        
        $itens = DB::connection('oracle')->select($sql);
        
        $itens = $this->percorrer_itens($itens);
        //dd($itens);
        // $itens = $this->somar_custos_futuros($itens,'tataranetos');
        // $itens = $this->somar_custos_futuros($itens,'bisnetos');
        // $itens = $this->somar_custos_futuros($itens,'netos');

        //dd($itens);
        
        return view('custo_item_comercial', compact(["itens"]));
    }
    
    private function percorrer_itens($itens){
        foreach ($itens as $key => $pai) {
            $pai->custo_futuro = null;
            $pai->custo_futuro_soma = null;
            $pai->filhos = $this->busca_filhos($pai->codproduto, $pai->idcorfilho,$pai->idcorpai);
            

            if($pai->filhos){
                foreach ($pai->filhos as $key => $filho) {
                    $filho->filhos = $this->busca_filhos($filho->codproduto, $filho->idcorfilho,$filho->idcorpai);

                    if($filho->filhos){
                        foreach ($filho->filhos as $key => $neto) {
                            $neto->filhos = $this->busca_filhos($neto->codproduto, $neto->idcorfilho,$neto->idcorpai);
                        
                            if($neto->filhos){
                                foreach ($neto->filhos as $key => $bisneto) {
                                    $bisneto->filhos = $this->busca_filhos($bisneto->codproduto, $bisneto->idcorfilho,$bisneto->idcorpai); 
                                    
                                    if($bisneto->filhos){
                                        foreach ($bisneto->filhos as $key => $tataraneto) {
                                            $tataraneto->filhos = $this->busca_filhos($tataraneto->codproduto, $tataraneto->idcorfilho,$tataraneto->idcorpai); 
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

    private function busca_filhos($codproduto,$idcorfilho,$idcorpai){
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
        
            $filhos = DB::connection('oracle')->select($sql_f);
        
        if($filhos){
            foreach ($filhos as $key => $filho) {
                $custos_futuros = $this->buscar_custo_futuro($filho->codproduto);

                $filho->custo_futuro = $custos_futuros ? $custos_futuros[0]->valor : NULL;

                $filho->custo_futuro_soma =  NULL;
            }
            return $filhos;
        }
        else{
            return [];
        }


    }   

    

    private function somar_custos_futuros($itens, $tipo){
        foreach ($itens as $key => $pai) {
            //dd($pai);

            if($pai->filhos){
                foreach ($pai->filhos as $key => $filho) {
                   //dd($filho);
                    
                    if($filho->filhos and ($tipo == 'netos' or $tipo == 'bisnetos' or $tipo == 'tataranetos')){
                        $filho->custo_futuro_soma = 0;
                        foreach ($filho->filhos as $key => $neto) {
                            $filho->custo_futuro_soma += $neto->custo_futuro ? ($neto->custo_futuro*$neto->qtde
                            *$filho->qtde
                            *$pai->qtde) : 
                                ($neto->custo_futuro_soma) ;

                            if($neto->filhos and ($tipo == 'bisnetos' or $tipo == 'tataranetos')){
                                $neto->custo_futuro_soma = 0;
                                foreach ($neto->filhos as $key => $bisneto) {
                                    $neto->custo_futuro_soma += $bisneto->custo_futuro ? ($bisneto->custo_futuro
                                    *$bisneto->qtde
                                    *$neto->qtde
                                    *$filho->qtde
                                    *$pai->qtde) : 
                                    ($bisneto->custo_futuro_soma) ;

                                    if($bisneto->filhos and $tipo == 'tataranetos'){
                                        $bisneto->custo_futuro_soma = 0;
                                        foreach ($bisneto->filhos as $key => $tataraneto) {
                                            $bisneto->custo_futuro_soma += ($tataraneto->custo_futuro
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
