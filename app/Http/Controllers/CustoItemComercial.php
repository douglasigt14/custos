<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustoItemComercial extends Controller
{
    public function index(){
        return view('custo_item_comercial', compact([]));
    }
}
