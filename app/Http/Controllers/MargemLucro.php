<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MargemLucro extends Controller
{
    public function index(){

        return view('margem_lucro', compact([]));
    }
}
