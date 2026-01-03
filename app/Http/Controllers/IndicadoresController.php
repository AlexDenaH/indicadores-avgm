<?php

namespace App\Http\Controllers;


use App\Models\Indicadores;
use App\Models\Programa;
use App\Models\Ejercicio;
use App\Models\NivelDetalle;
use Illuminate\Http\Request;


class IndicadoresController extends Controller
{
        public function index(Request $request)
        {
                $q = $request->q;
                $indicadores = Indicadores::whereHas('programa', function ($query) {
                        $query->where('activo', 1)
                                ->whereHas('ejercicio', function ($q) {
                                        $q->where('activo', 1);
                                });
                })
                        ->when($q, function ($query) use ($q) {
                                // Buscar en el nombre del indicador
                                $query->where('indicador', 'LIKE', "%{$q}%")
                                        // Buscar en el programa
                                        ->orWhereHas('programa', function ($q2) use ($q) {
                                                $q2->where('programa', 'LIKE', "%{$q}%");
                                        })
                                        // Buscar en nivel_detalle (JSON)
                                        ->orWhere(function ($q3) use ($q) {
                                                $ids = NivelDetalle::where('tipo', 'LIKE', "%{$q}%")
                                                        ->pluck('id')
                                                        ->toArray();

                                                if (!empty($ids)) {
                                                        foreach ($ids as $id) {
                                                                $q3->orWhereJsonContains('id_detalle', $id);
                                                        }
                                                }
                                        });
                        })
                        ->with([
                                'programa' => function ($q) {
                                        $q->where('activo', 1)
                                                ->with(['ejercicio' => function ($q2) {
                                                        $q2->where('activo', 1);
                                                }]);
                                }
                        ])
                        ->orderBy('id', 'asc')
                        ->get();
                return view('indicadores.index', compact('indicadores'));
        }


        public function create()
        {
                return view('indicadores.create', [
                        'programas'      => Programa::where('activo', 1)->get(),
                        'nivelesDetalle' => NivelDetalle::orderBy('tipo')->get(),
                ]);
        }


        public function store(Request $request)
        {
                // =========================
                // VALIDACIÓN
                // =========================
                $data = $request->validate([
                        'id_programa' => 'required|exists:programas,id', // Debe existir en la tabla programas
                        'indicador'   => 'required|string|max:255',      // Campo obligatorio
                        'descripcion' => 'nullable|string',             // Opcional
                        'medicion'    => 'required|string|max:255',     // Obligatorio

                        // Validación del array de detalles
                        'id_detalle'       => 'nullable|array',           // Puede no existir
                        'id_detalle.*.id'  => 'required_with:id_detalle|exists:nivel_detalle,id', // obligatorio si id_detalle existe
                        'id_detalle.*.orden' => 'required_with:id_detalle|integer',               // obligatorio si id_detalle existe

                        'activo'      => 'boolean',                      // Valor true/false
                ]);

                // =========================
                // CAST BOOLEAN
                // =========================
                $data['activo'] = $request->boolean('activo');

                // =========================
                // CREACIÓN DEL REGISTRO
                // =========================
                $indicador = Indicadores::create($data);

                // =========================
                // REDIRECCIÓN CON MENSAJE
                // =========================
                return redirect()
                        ->route('indicadores.index')
                        ->with('success', 'Indicador creado correctamente.');
        }


        public function edit(Indicadores $indicadores)
        {
                return view('indicadores.edit', [
                        'indicador'       => $indicadores,
                        'programas'       => Programa::where('activo', 1)->get(),
                        'nivelesDetalle'  => NivelDetalle::orderBy('tipo')->get(),
                        'detalleActual'   => $indicador->id_detalle ?? []
                ]);
        }


        public function update(Request $request, Indicadores $indicadores)
        {
                // Validación
                $data = $request->validate([
                        'id_programa' => 'required|exists:programas,id',
                        'indicador'   => 'required|string|max:255',
                        'descripcion' => 'nullable|string',
                        'medicion'    => 'required|string|max:255',
                        'id_detalle'  => 'nullable|array',
                        'id_detalle.*.id'    => 'exists:nivel_detalle,id',
                        'id_detalle.*.orden' => 'integer',
                        'activo'      => 'boolean',
                ]);

                $data['activo'] = $request->boolean('activo');

                $indicadores->update($data);

                return redirect()
                        ->route('indicadores.index')
                        ->with('success', 'Indicador actualizado correctamente.');
        }



        public function destroy(Indicadores $indicadores)
        {
                $indicadores->delete();
                return back();
        }


        public function toggle(Indicadores $indicadores)
        {
                $indicadores->update(['activo' => !$indicadores->activo]);
                return back();
        }
}
