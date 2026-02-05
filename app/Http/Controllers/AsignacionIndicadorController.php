<?php

namespace App\Http\Controllers;

use App\Models\AsignacionIndicador;
use App\Models\Ejercicio;
use App\Models\Programa;
use App\Models\Indicadores;
use App\Models\DependenciaArea;
use Illuminate\Http\Request;

class AsignacionIndicadorController extends Controller
{

    /**
     * Listado principal
     */
    public function index(Request $request)
    {
        $busqueda = trim($request->get('q'));

        $asignaciones = AsignacionIndicador::with([
            'ejercicio',
            'programa',
            'area'
        ])
            ->whereHas('ejercicio', fn($q) => $q->where('activo', 1))
            ->whereHas('programa', fn($q) => $q->where('activo', 1))
            ->when($busqueda, function ($query) use ($busqueda) {
                $query->whereHas('ejercicio', function ($q) use ($busqueda) {
                    $q->where('ejercicio', 'LIKE', "%{$busqueda}%");
                })
                    ->orWhereHas('programa', function ($q) use ($busqueda) {
                        $q->where('programa', 'LIKE', "%{$busqueda}%");
                    })
                    ->orWhereHas('area', function ($q) use ($busqueda) {
                        $q->where('unidad_area', 'LIKE', "%{$busqueda}%");
                    });
            })
            ->orderByDesc('id')
            ->get()
            ->map(function ($asignacion) use ($busqueda) {

                $ids = $asignacion->indicadores ?? [];

                $indicadores = Indicadores::whereIn('id', $ids)
                    ->pluck('indicador');

                // 🔍 Si la búsqueda NO coincidió por relaciones,
                // revisamos indicadores manualmente
                if ($busqueda) {
                    $texto = mb_strtolower($busqueda);

                    $coincideIndicador = $indicadores->contains(function ($ind) use ($texto) {
                        return str_contains(mb_strtolower($ind), $texto);
                    });

                    $coincideRelacion =
                        str_contains(mb_strtolower($asignacion->ejercicio->ejercicio ?? ''), $texto) ||
                        str_contains(mb_strtolower($asignacion->programa->programa ?? ''), $texto) ||
                        str_contains(mb_strtolower($asignacion->area->unidad_area ?? ''), $texto);

                    if (!$coincideIndicador && !$coincideRelacion) {
                        return null;
                    }
                }

                $asignacion->indicadores_detalle = $indicadores;

                return $asignacion;
            })
            ->filter()
            ->values();

        return view(
            'asignacion_indicadores.index',
            compact('asignaciones', 'busqueda')
        );
    }

    /**
     * Formulario crear
     */
    public function create()
    {
        $ejercicios = Ejercicio::where('activo', 1)->orderBy('ejercicio')->get();
        $areas = DependenciaArea::where('activa', 1)
            ->whereRaw('LOWER(unidad_area) NOT LIKE ?', ['%admin%'])
            ->whereNotIn('id', function ($query) {
                $query->select('id_area')
                    ->from('asignacion_indicadores');
            })
            ->orderBy('unidad_area')
            ->get();

        return view('asignacion_indicadores.create', compact('ejercicios', 'areas'));
    }

    /**
     * Guardar asignación
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_ejercicio' => 'required|exists:ejercicios,id',
            'id_programa'  => 'required|exists:programas,id',
            'id_area'      => 'required|exists:dependencia_areas,id',
            'indicadores'  => 'required|array|min:1',
            'indicadores.*' => 'integer|exists:indicadores,id',
        ]);

        // Evitar duplicados por ejercicio + programa + área
        $existe = AsignacionIndicador::where(
            $request->only(['id_ejercicio', 'id_programa', 'id_area'])
        )->exists();

        if ($existe) {
            return back()
                ->withErrors(['id_area' => 'Ya existe una asignación para esta área'])
                ->withInput();
        }

        AsignacionIndicador::create($data);

        return redirect()
            ->route('asignaciones.index')
            ->with('success', 'Asignación creada correctamente');
    }

    /**
     * Formulario editar
     */
    public function edit(AsignacionIndicador $asignacionIndicador)
    {
        $ejercicios = Ejercicio::where('activo', 1)->orderBy('ejercicio')->get();
        $areas = DependenciaArea::where('activa', 1)
            ->where('id', $asignacionIndicador->id_area)
            ->where('unidad_area', 'NOT LIKE', '%admin%') // Laravel maneja el case-insensitive en la mayoría de DBs
            ->get();

        return view(
            'asignacion_indicadores.edit',
            compact('asignacionIndicador', 'ejercicios', 'areas')
        );
    }

    /**
     * Actualizar asignación
     */
    public function update(Request $request, AsignacionIndicador $asignacionIndicador)
    {
        $data = $request->validate([
            'id_ejercicio' => 'required|exists:ejercicios,id',
            'id_programa'  => 'required|exists:programas,id',
            'id_area'      => 'required|exists:dependencia_areas,id',
            'indicadores'  => 'required|array|min:1',
            'indicadores.*' => 'integer|exists:indicadores,id',
        ]);

        $asignacionIndicador->update($data);

        return redirect()
            ->route('asignaciones.index')
            ->with('success', 'Asignación actualizada correctamente');
    }

    /**
     * Eliminar
     */
    public function destroy(AsignacionIndicador $asignacionIndicador)
    {
        $asignacionIndicador->delete();

        return back()->with('success', 'Asignación eliminada');
    }
}
