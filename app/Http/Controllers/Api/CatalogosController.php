<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Programa;
use App\Models\Indicadores;
use Illuminate\Database\Eloquent\Builder;

class CatalogosController extends Controller
{
    /**
     * Programas activos por ejercicio
     */
    public function programasPorEjercicio($idEjercicio)
    {
        return Programa::where('id_ejercicio', $idEjercicio)
            ->where('activo', 1)
            ->orderBy('programa')
            ->get(['id', 'programa']);
    }

    /**
     * Indicadores activos por programa
     */
    public function indicadoresPorPrograma($idPrograma)
    {
        return Indicadores::where('id_programa', $idPrograma)
            ->where('activo', 1)
            ->orderBy('indicador')
            ->get(['id', 'indicador']);
    }

    /**
     * Indicadores activos por programa que NO están en la tabla periodos
     */
    public function getIndicadoresDisponibles($ejercicioId, $programaId, $indicadorIdActual = null)
    {
        return Indicadores::query()
            ->where('id_programa', $programaId)
            ->where('activo', 1)
            ->whereHas('programa', function (Builder $query) {
                $query->where('activo', 1);
            })
            ->where(function (Builder $query) use ($ejercicioId, $programaId, $indicadorIdActual) {
                // 1. Traer indicadores que NO tengan registro en este ejercicio y programa específicos
                $query->whereDoesntHave('periodos', function (Builder $subQuery) use ($ejercicioId, $programaId) {
                    $subQuery->where('id_ejercicio', $ejercicioId)
                        ->where('id_programa', $programaId);
                });

                // 2. Si estamos editando, permitir que el indicador actual aparezca en la lista
                if ($indicadorIdActual) {
                    $query->orWhere('id', $indicadorIdActual);
                }
            })
            ->get(['id', 'indicador']);
    }
}
