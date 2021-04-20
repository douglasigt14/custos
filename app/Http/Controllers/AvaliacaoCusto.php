<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvaliacaoCusto extends Controller
{
    public function index(){
       

        return view('avaliacao_custo', compact([]));
    }
}
