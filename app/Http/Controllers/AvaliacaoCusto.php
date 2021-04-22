<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AvaliacaoCusto extends Controller
{
    public function index(){
    $dt_inicial = $_GET['dt_inicial'] ?? NULL;
    $dt_final = $_GET['dt_final'] ?? NULL;
    
    $dados = array();

    if($dt_inicial and $dt_inicial){
        $dt_inicial = implode("/",array_reverse(explode("-",$dt_inicial)));
        $dt_final = implode("/",array_reverse(explode("-",$dt_final)));

        // $sql = "SELECT 
        //     * 
        // FROM 
        //     FOCCO3I.AVALIACAO_CUSTO_SISTEMA 
        // WHERE 
        //     DT_ENT_DATA BETWEEN TO_DATE ('$dt_inicial','DD/MM/RRRR') 
        // AND TO_DATE ('$dt_final','DD/MM/RRRR')";
            
        // $dados = DB::connection('oracle')->select($sql);
    }

        return view('avaliacao_custo', compact(["dados","dt_inicial","dt_final"]));
    }
}
