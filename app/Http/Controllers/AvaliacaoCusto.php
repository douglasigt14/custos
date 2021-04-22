<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AvaliacaoCusto extends Controller
{
    public function index(){
    $dt_inicial = $_GET['dt_inicial'] ?? NULL;
    $dt_final = $_GET['dt_inicial'] ?? NULL;
    
    $dados = array();

    if($dt_inicial and $dt_inicial){
        $sql = "SELECT 
            * 
        FROM 
            FOCCO3I.AVALIACAO_CUSTO_SISTEMA 
        WHERE 
            DT_ENT_DATA BETWEEN TO_DATE ('$dt_inicial','DD/MM/RRRR') 
        AND TO_DATE ('$dt_final','DD/MM/RRRR')";
            
        $dados = DB::connection('oracle')->select($sql);
        dd($dados);
    }

        return view('avaliacao_custo', compact(["dados","dt_inicial","dt_final"]));
    }
}
