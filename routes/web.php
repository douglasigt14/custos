<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Middleware\MyAuth;
use App\Http\Controllers\Auth\MyLogin;
use App\Http\Controllers\MateriasPrimas;
use App\Http\Controllers\CustoItemComercial;
use App\Http\Controllers\MargemLucro;
use App\Http\Controllers\AvaliacaoCusto;
use App\Http\Controllers\Relatorios;
use App\Http\Controllers\MargemPedidos;
use App\Http\Controllers\Parametros;
use App\Http\Controllers\SimulacaoCotacao;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(MyAuth::class)->group(function () {
    Route::get('/', [Dashboard::class, 'index']);
    Route::get('/materias_primas', [MateriasPrimas::class, 'index']);
    Route::delete('/materias_primas', [MateriasPrimas::class, 'delete']);
    Route::get('/ins_up_custo_futuro/{cod_item}/{valor}', [MateriasPrimas::class, 'ins_up_custo_futuro']);
    Route::get('/ins_up_fornecedor/{cod_item}/{fornecedor}', [MateriasPrimas::class, 'ins_up_fornecedor']);
    Route::get('/custo_item_comercial', [CustoItemComercial::class, 'index']);
    Route::get('/margem_lucro', [MargemLucro::class, 'index']);
    Route::get('/avaliacao_custo', [AvaliacaoCusto::class, 'index']);
    Route::get('/relatorios/rel_itens_reajustados', [Relatorios::class, 'rel_itens_reajustados']);
    Route::get('/margem_pedidos', [MargemPedidos::class, 'index']);
    Route::get('/parametros', [Parametros::class, 'index']);
    Route::post('/parametros', [Parametros::class, 'salvar']);

    Route::get('/simulacao_cotacao', [SimulacaoCotacao::class, 'index']);
    Route::get('/buscar_clientes_info/{cod_cli}', [SimulacaoCotacao::class, 'buscar_clientes_info']);
    Route::get('/buscar_itens_info/{cod_item}', [SimulacaoCotacao::class, 'buscar_itens_info']);
    Route::post('/simulacao_cotacao/salvar', [SimulacaoCotacao::class, 'salvar']);
});

Route::get('/login', [MyLogin::class, 'index'] )->name('login');
Route::post('/login', [MyLogin::class, 'login'] );
Route::get('/logout', [MyLogin::class, 'logout']);
Route::patch('/mudar_senha', [MyLogin::class, 'mudarSenha']);
