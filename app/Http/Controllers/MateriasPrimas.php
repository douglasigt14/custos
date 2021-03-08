<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MateriasPrimas extends Controller
{
    public function index(){
        // $usuarios = DB::select("SELECT * FROM usuarios");
        // dd($usuarios);

        return view('materias_primas', compact([]));
    }
}
