<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AsignacionIndicador;
use App\Models\Indicadores;

class CombosController extends Controller
{
    // Ejercicios activos
    public function ejercicios()
    {
        return DB::table('ejercicios')
            ->where('activo', 1)
            ->orderBy('ejercicio')
            ->get();
    }

    // Programas activos por ejercicio
    public function programas($ejercicio)
    {
        return DB::table('programas')
            ->where('id_ejercicio', $ejercicio)
            ->where('activo', 1)
            ->get();
    }

    // Indicadores asignados a la dependencia
    public function indicadores(Request $request)
    {
        $request->validate([
            'ejercicio' => 'required|integer',
            'programa'  => 'required|integer',
        ]);

        $user = auth::user();

        $asignacion = AsignacionIndicador::where('id_ejercicio', $request->ejercicio)
            ->where('id_programa', $request->programa)
            ->where('id_area', $user->id_dep_area)
            ->first();

        if (!$asignacion || empty($asignacion->indicadores)) {
            return response()->json([]);
        }

        // 👇 YA ES ARRAY GRACIAS AL CAST
        $idsIndicadores = array_map('intval', $asignacion->indicadores);

        return Indicadores::whereIn('id', $idsIndicadores)
            ->select('id', 'indicador')
            ->orderBy('indicador')
            ->get();
    }

    // Periodos abiertos
    public function periodos(Request $request)
    {
        return DB::table('periodos')
            ->where('id_ejercicio', $request->ejercicio)
            ->where('id_programa', $request->programa)
            ->where('id_indicador', $request->indicador)
            ->where('status', 1)
            ->get();
    }

    // Componentes + subcomponentes
    public function componentes($indicador)
    {
        return DB::table('componentes')
            ->where('id_indicador', $indicador)
            ->get();
    }

    // Nivel detalle
    public function nivelesDetalle($indicador)
    {
        return DB::table('indicadores')
        ->where('id', $indicador)
        ->get();
    }
}
