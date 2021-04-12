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
        
       
        
        foreach ($itens as $key => $pai) {
            $pai->filhos = $this->busca_filhos($pai->codproduto, $pai->idcorfilho);

            if($pai->filhos){
                foreach ($pai->filhos as $key => $filho) {
                    $filho->filhos = $this->busca_filhos($filho->codproduto, $filho->idcorfilho);

                    if($filho->filhos){
                        foreach ($filho->filhos as $key => $neto) {
                            $neto->filhos = $this->busca_filhos($neto->codproduto, $neto->idcorfilho);
                        }
                    }

                }
            }
        }

        dd($itens);
        
        return view('custo_item_comercial', compact(["itens"]));
    }

    private function busca_filhos($codproduto,$idcorfilho){
            $sql_f = "SELECT 
                    * 
                FROM 
                    FOCCO3i.LJ_EST_SISTEMA_CUSTO 
                WHERE  
                    codprodutopai = '$codproduto'
                AND idcorpai = '$idcorfilho'";
                
                // if($idcorfilho){
                //     $sql_f = $sql_f." AND idcorpai = '$idcorfilho'";
                // }
                // else{
                //     $sql_f = $sql_f." AND idcorpai IS NOT NULL";
                // }
        
            $filhos = DB::connection('oracle')->select($sql_f);
        
        if($filhos){
            return $filhos;
        }
        else{
            return [];
        }


    }   
}
