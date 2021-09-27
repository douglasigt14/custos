<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Parametros extends Controller
{
    public function index(){
        $sql = "SELECT * FROM parametros";
        $parametros =  DB::connection('mysql')->select($sql);
        return view('parametros', compact(['parametros']));
    }
    public function salvar(Request $request){
        $dados = (object) $request->all();
        DB::table('parametros')
              ->where('id', $dados->id)
              ->update([
                    'valor' => $dados->valor
        ]);
        return back();
    }
}
