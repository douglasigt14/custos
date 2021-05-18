<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Relatorios extends Controller
{
    public function rel_itens_reajustados(){
        
        return view('relatorios.rel_itens_reajustados',compact([]));
    }
}
