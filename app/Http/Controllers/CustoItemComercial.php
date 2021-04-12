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
        dd($itens);
        

        return view('custo_item_comercial', compact(["itens"]));
    }
}
