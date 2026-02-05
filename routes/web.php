<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\DependenciaAreaController;
use App\Http\Controllers\IndicadoresController;
use App\Http\Controllers\NivelDetalleController;
use App\Http\Controllers\AsignacionIndicadorController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\ComponenteController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\ConcentradoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| RUTAS DE ADMINISTRACIÓN
|--------------------------------------------------------------------------
/*
|--------------------------------------------------------------------------
    CATALOGOS 
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super-admin'])
    ->prefix('catalogos')
    ->group(function () {

        Route::resource('municipios', MunicipioController::class);
    });

Route::middleware(['role:super-admin'])
    ->prefix('catalogos')
    ->group(function () {
        Route::resource('dependencias', DependenciaController::class)->middleware(['role:super-admin']);
        Route::resource('dependencia_areas', DependenciaAreaController::class)->middleware(['role:super-admin']);
    });

//llenar los combos de dependencias y areas
Route::get(
    '/dependencias/{dependencia}/areas',
    [UserController::class, 'areasPorDependencia']
)->name('dependencias.areas');
/*
|--------------------------------------------------------------------------
    CONTROL DE USUARIOS  
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    /*
    | CRUD de usuarios
    | Solo accesible a super-admin y administrador
    */
    Route::middleware(['role:super-admin|administrador'])
        ->resource('users', UserController::class);
});

Route::get(
    'users/{user}/permissions',
    [UserController::class, 'permissions']
)->name('users.permissions')
    ->middleware(['role:super-admin']);

Route::put(
    'users/{user}/permissions',
    [UserController::class, 'updatePermissions']
)->name('users.permissions.update')
    ->middleware(['role:super-admin']);

Route::get('/test', fn() => view('test'));

/*
    |--------------------------------------------------------------------------
    | PROGRAMAS (EJERCICIOS Y PROGRAMAS)
    | SOLO super-admin
    |--------------------------------------------------------------------------
    */
Route::middleware(['role:super-admin'])->group(function () {

    // Ejercicios
    Route::resource('ejercicios', EjercicioController::class);

    // Toggle activo / inactivo
    Route::patch('ejercicios/{ejercicio}/toggle', [EjercicioController::class, 'toggle'])
        ->name('ejercicios.toggle');

    // Programas
    Route::resource('programas', ProgramaController::class);

    // Toggle activo / inactivo
    Route::patch('programas/{programa}/toggle', [ProgramaController::class, 'toggle'])
        ->name('programas.toggle');
});

/*
    |--------------------------------------------------------------------------
    | INDICADORES, COMPONENTES, ASIGNACIONES Y PERIODOS
    | super-admin | administrador
    |--------------------------------------------------------------------------
    */
Route::middleware(['role:super-admin|administrador'])->group(function () {

    // Indicadores
    Route::resource('indicadores', IndicadoresController::class)->parameters(['indicadores' => 'indicadores']);

    // Toggle activo / inactivo
    Route::patch('indicadores/{indicadores}/toggle', [IndicadoresController::class, 'toggle'])
        ->name('indicadores.toggle');

    // Componentes
    Route::resource('componentes', ComponenteController::class);

    // Periodos
    Route::resource('periodos', PeriodoController::class);

    // Acciones extra para periodos (opcional)
    Route::patch('periodos/{periodo}/abrir', [PeriodoController::class, 'abrir'])
        ->name('periodos.abrir');

    Route::patch('periodos/{periodo}/cerrar', [PeriodoController::class, 'cerrar'])
        ->name('periodos.cerrar');

    // Toggle activo / inactivo
    Route::patch('/periodos/{periodo}/toggle', [PeriodoController::class, 'toggle'])
        ->name('periodos.toggle');

    //detalle 
    Route::resource('nivel-detalle', NivelDetalleController::class);

    // Asignacion de Indicadores
    Route::resource('asignaciones',
        AsignacionIndicadorController::class
    )->parameters([
        'asignaciones' => 'asignacionIndicador'
    ]);
});

/*
    |--------------------------------------------------------------------------
    | Llenado de indicadores 
    | cualquiera con acceso
    |--------------------------------------------------------------------------
    */
Route::middleware(['auth'])->group(function () {
    Route::resource('concentrados', ConcentradoController::class);
});

require __DIR__ . '/auth.php';
