<?php

use App\Http\Controllers\LogisticaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\NuevasPlataformasController;
use App\Http\Controllers\VentasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Servicios

Route::get('servicios', [ServiciosController::class, 'index']);

Route::post('servicios/create', [ServiciosController::class, 'store']);
Route::post('servicios/update/{id}', [ServiciosController::class, 'store']);

Route::get('servicios/details/{id}', [ServiciosController::class, 'details']);
Route::post('servicios/delete/{id}', [ServiciosController::class, 'destroy']);
Route::post('servicios/activar/{id}', [ServiciosController::class, 'activar']);

// Logistica

Route::get('logistica', [LogisticaController::class, 'index']);

Route::post('logistica/create', [LogisticaController::class, 'store']);
Route::post('logistica/update/{id}', [LogisticaController::class, 'store']);
Route::post('logistica/updateAdvice/{id}', [LogisticaController::class, 'actualizarAvisos']);
Route::post('logistica/cambiarCorte/{id}', [LogisticaController::class, 'cambiarCorte']);

Route::get('logistica/details/{id}', [LogisticaController::class, 'details']);
Route::post('logistica/delete/{id}', [LogisticaController::class, 'destroy']);

// Nuevas plataformas

Route::get('nuevas-plataformas', [NuevasPlataformasController::class, 'index']);
Route::post('nuevas-plataformas/create', [NuevasPlataformasController::class, 'store']);


// Ventas

Route::get('ventas', [VentasController::class, 'index']);
Route::post('ventas/create', [VentasController::class, 'store']);

Route::get('ventas/details/{id}', [VentasController::class, 'details']);
Route::post('ventas/delete/{id}', [VentasController::class, 'destroy']);

Route::post('ventas/update/{id}', [VentasController::class, 'update']);



