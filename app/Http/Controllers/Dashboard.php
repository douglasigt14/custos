<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Dashboard extends Controller
{
    public function index(){
        // $sqlClientes = "SELECT * FROM FOCCO3I.TCLIENTES WHERE COD_CLI = 51";
        // $clientes = DB::connection('oracle')->select($sqlClientes);
        // dd($clientes);

        return view('pagina_inicial', compact([]));
    }
}
