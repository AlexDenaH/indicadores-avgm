<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatalogosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Estas rutas se consumen con fetch / axios desde Blade o JS
|--------------------------------------------------------------------------
*/

// Programas activos por ejercicio
Route::get('/programas/{idEjercicio}', [CatalogosController::class, 'programasPorEjercicio']);

// Indicadores activos por programa
Route::get('/indicadores/{idPrograma}', [CatalogosController::class, 'indicadoresPorPrograma']);

// Indicadores activos por programa periodos
Route::get('/indPeriodos/{idEjercicio}/{programaId}/{indicadorId?}', [CatalogosController::class, 'getIndicadoresDisponibles']);

