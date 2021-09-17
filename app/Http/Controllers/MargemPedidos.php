<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MargemPedidos extends Controller
{
    public function index(){
        return view('margem_pedidos', compact([]));;
    }
}
