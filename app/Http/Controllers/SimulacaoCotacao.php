<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulacaoCotacao extends Controller
{
    public function index(){
        return view('simulacao_cotacao', compact([]));
    }
}
