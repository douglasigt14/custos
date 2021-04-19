<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MargemLucro extends Controller
{
    public function index(){
        $sql = "SELECT 
                    *
                FROM custos_log";

            $itens  = DB::connection('mysql')->select($sql);

        

        return view('margem_lucro', compact(["itens"]));
    }
}
