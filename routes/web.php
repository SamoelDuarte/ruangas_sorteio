<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SorteioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sorteio/{hash}', [SorteioController::class, 'cliente'])->name('sorteio.cliente');
Route::post('/sorteio/{id}/salvar', [SorteioController::class, 'salvarNumeroSorte'])->name('sorteio.salvarNumeroSorte');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/clientes', [ClienteController::class, 'index'])->name('cliente.index');
    Route::post('/clientes/novo', [ClienteController::class, 'store'])->name('cliente.store');
    Route::delete('/cliente/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');




    Route::get('/sorteio', [SorteioController::class, 'index'])->name('sorteio.index');
    Route::post('/novo', [SorteioController::class, 'store'])->name('sorteio.store');
    Route::delete('/sorteio/delete/{id}', [SorteioController::class, 'destroy'])->name('sorteio.destroy');



    Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/buscar-ganhador', [SorteioController::class, 'buscarGanhador']);



});






Route::middleware(['cors'])->post('/obterparcelamento', [CronController::class, 'obterParcelamento']);


require __DIR__ . '/auth.php';
