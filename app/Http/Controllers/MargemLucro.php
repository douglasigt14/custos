<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MargemLucro extends Controller
{
    public function index(){
        $sql = "SELECT 
                    COD_ITEM
                    ,ITEM 
                FROM 
                    FOCCO3I.LJ_VALOR_ITEM_CUSTO
                GROUP BY 
                    COD_ITEM
                    ,ITEM";

            $itens  = DB::connection('oracle')->select($sql);

        return view('margem_lucro', compact(["itens"]));
    }
}
