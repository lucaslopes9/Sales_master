<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController; // Verifique o namespace/nome da classe
use App\Http\Controllers\ProductController; // **MUITO IMPORTANTE: Garanta que esta linha esteja aqui**

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
| Exemplo:
| Route::get('/users', function (Request $request) {
|     return $request->user();
| });
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas para a API de busca de clientes (se existir)
// Exemplo: Route::get('/clientes', [ClienteController::class, 'indexApi'])->name('api.clientes.index');
Route::get('/clientes', [ClienteController::class, 'getApiClientes'])->name('api.clientes.index'); // Use o nome do método que você definiu

// Rota para a API de busca de produtos
Route::get('/products', [ProductController::class, 'indexApi'])->name('api.products.index'); // **Esta linha deve estar aqui**