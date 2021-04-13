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
                AND idcorpai = '48377'"; 
        
        $itens = DB::connection('oracle')->select($sql);
        
        $itens = $this->percorrer_itens($itens);
        
        
       //CUSTOS FUTUROS 
        
        return view('custo_item_comercial', compact(["itens"]));
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
                $sql = "SELECT valor FROM custos_futuros WHERE cod_item = $filho->codproduto";
                $custos_futuros = DB::connection('mysql')->select($sql);

                $filho->custo_futuro = $custos_futuros ? $custos_futuros[0]->valor : NULL;
            }
            return $filhos;
        }
        else{
            return [];
        }


    }   

    private function percorrer_itens($itens){
        foreach ($itens as $key => $pai) {
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
}
