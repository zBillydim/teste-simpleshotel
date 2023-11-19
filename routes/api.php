<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuartoController;
use App\Http\Controllers\Auth\RegisterController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* ROTAS PUBLICAS */
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    /* QUARTO */
    Route::prefix('/quarto')->group(function () {
        Route::get('/', [QuartoController::class, 'ListarDisponiveis']);
        Route::get('/{id}', [QuartoController::class, 'ListarDisponiveis']);
        Route::post('/criar', [QuartoController::class, 'CriaQuarto']);
        Route::post('/reservar', [QuartoController::class, 'ReservarQuarto']);   
        Route::post('/disponivel', [QuartoController::class, 'ListarQuartosDisponiveisPorData']);
    });

    /* CLIENTES */
    Route::prefix('/clientes')->group(function () {
        Route::get('/', [ClienteController::class, 'index']);
    });
});