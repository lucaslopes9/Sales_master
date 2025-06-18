// routes/web.php

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController; // << MUDEI PARA ProdutoController (Português)
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rotas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas para o recurso 'Vendas'
    Route::resource('vendas', VendaController::class);

    // Rotas para o recurso 'Clientes'
    Route::resource('clientes', ClienteController::class);

    // --- ROTA PARA BUSCAR CLIENTES VIA AJAX ---
    Route::get('/api/clientes', [ClienteController::class, 'getApiClientes'])->name('api.clientes.index');

    // --- Rotas para o recurso 'Produtos' (CRUD COMPLETO) ---
    Route::resource('produtos', ProdutoController::class); // << ADICIONE OU MUDE ESTA LINHA PARA PRODUTOS (Português)

    // --- NOVA ROTA PARA BUSCAR PRODUTOS VIA AJAX ---
    // Esta rota retorna uma lista de produtos em formato JSON.
    Route::get('/api/produtos', [ProdutoController::class, 'indexApi'])->name('api.produtos.index'); // << MUDEI PARA PRODUTOS E indexApi (Português)
});

require __DIR__.'/auth.php';