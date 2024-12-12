<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;


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

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function(){

    Route::get('/servicios', function () {
        return view('servicios');
    })->name('servicios');
    
    Route::get('/logistica', function () {
        return view('logistica');
    })->name('logistica'); 

    Route::get('/administracion-ventas', function () {
        return view('administracion-ventas');
    })->name('administracion-ventas'); 

    Route::get('/nuevas-plataformas', function () {
        return view('nuevas-plataformas');
    })->name('nuevas-plataformas'); 

    Route::get('/estadisticas', function () {
        return view('estadisticas');
    })->name('estadisticas'); 

    Route::get('/chart-data', [ChartController::class, 'getChartData'])->name('chart-data');

    Route::get('/pie-chart', [ChartController::class, 'getPieChart'])->name('pie-chart');

    Route::get('/comparative-chart', [ChartController::class, 'mostrarGraficoVentas'])->name('comparative-chart');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');    
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login');



