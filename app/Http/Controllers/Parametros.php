<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Parametros extends Controller
{
    public function index(){
        return view('parametros', compact([]));
    }
}
