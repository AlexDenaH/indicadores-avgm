<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\Indicador;
use Illuminate\Http\Request;

class AsignacionIndicadoresController extends Controller
{
    /**
     * Muestra el formulario de asignación de indicadores
     *
     * @param  Dependencia $dependencia
     * @return \Illuminate\View\View
     */
    public function edit(Dependencia $dependencia)
    {
        /*
         | Enviamos a la vista:
         | 1. La dependencia seleccionada
         | 2. Todos los indicadores activos del catálogo
         |
         | La vista se encargará de marcar cuáles
         | ya están asignados a esta dependencia.
         */
        return view('admin.asignaciones.edit', [
            'dependencia' => $dependencia,
            'indicadores' => Indicador::where('activo', true)->get(),
        ]);
    }

    /**
     * Guarda la asignación de indicadores a la dependencia
     *
     * @param  Request $request
     * @param  Dependencia $dependencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Dependencia $dependencia)
    {
        /*
         | sync() es clave:
         | - Agrega indicadores nuevos
         | - Quita los que ya no estén seleccionados
         | - Mantiene los que siguen marcados
         |
         | Si no llega nada en el request,
         | se envía un arreglo vacío.
         */
        $dependencia->indicadores()->sync(
            $request->input('indicadores', [])
        );

        /*
         | Redirigimos al listado de dependencias
         | con un mensaje de confirmación
         */
        return redirect()
            ->route('dependencias.index')
            ->with('success', 'Indicadores asignados correctamente.');
    }
}

