<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Middleware\MyAuth;
use App\Http\Controllers\Auth\MyLogin;
use App\Http\Controllers\MateriasPrimas;
use App\Http\Controllers\CustoItemComercial;


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
    Route::get('/custo_item_comercial', [CustoItemComercial::class, 'index']);
});

Route::get('/login', [MyLogin::class, 'index'] )->name('login');
Route::post('/login', [MyLogin::class, 'login'] );
Route::get('/logout', [MyLogin::class, 'logout']);
Route::patch('/mudar_senha', [MyLogin::class, 'mudarSenha']);
