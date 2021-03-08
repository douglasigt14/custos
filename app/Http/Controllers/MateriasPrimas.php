<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MateriasPrimas extends Controller
{
    public function index(){
        $sqlItens = "SELECT * FROM FOCCO3I.LJ_CUSTO_SISTEMA";
        $itens = DB::connection('oracle')->select($sqlItens);

        return view('materias_primas', compact(['itens']));
    }
}
