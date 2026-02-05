<?php

namespace App\Http\Controllers;


use App\Models\Periodo;
use App\Models\Ejercicio;
use App\Models\Programa;
use App\Models\Indicadores;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PeriodoController extends Controller
{
        public function index(Request $request)
        {

                $search = $request->input('search');
                $periodos = Periodo::with(['ejercicio', 'programa', 'indicadores'])
                        ->whereHas('ejercicio', fn($q) => $q->where('activo', 1))
                        ->whereHas('programa', fn($q) => $q->where('activo', 1))
                        ->whereHas('indicadores', fn($q) => $q->where('activo', 1))
                        ->when($search, function ($q) use ($search) {
                                $q->where('periodo', 'like', "%{$search}%")
                                        ->orWhereHas(
                                                'indicadores',
                                                fn($qi) =>
                                                $qi->where('indicador', 'like', "%{$search}%")
                                        )
                                        ->orWhereHas(
                                                'programa',
                                                fn($qe) =>
                                                $qe->where('programa', 'like', "%{$search}%")
                                        );
                        })
                        ->get();
                return view('periodos.index', compact('periodos', 'search'));
        }


        public function create()
        {
                $ejercicios = Ejercicio::where('activo', 1)
                        ->orderBy('ejercicio', 'desc')
                        ->get();

                return view('periodos.create', compact('ejercicios'));
        }


        public function store(Request $request)
        {

                $request->validate([
                        'id_ejercicio' => 'required|exists:ejercicios,id',
                        'id_programa'  => 'required|exists:programas,id',
                        'id_indicador' => 'required|exists:indicadores,id',
                        'periodo'      => 'required|in:diario,semanal,mensual,trimestral,anual',
                        'dias_inicio'  => 'required|integer|min:0',
                        'dias_final'   => 'required|integer|min:0',
                ], [
                        'dias_inicio.lte' => 'El día de inicio no puede ser mayor al final'
                ]);

                if (
                        $request->periodo !== 'diario' &&
                        $request->dias_inicio > $request->dias_final
                ) {
                        throw ValidationException::withMessages([
                                'dias_inicio' => 'El inicio no puede ser mayor al final'
                        ]);
                }

                Periodo::create($request->all());
                return redirect()->route('periodos.index');
        }



        public function edit(Periodo $periodo)
        {
                // Ejercicios activos
                $ejercicios = Ejercicio::where('activo', 1)
                        ->orderBy('ejercicio', 'desc')
                        ->get();

                // Programas del ejercicio del periodo
                $programas = Programa::where('activo', 1)
                        ->where('id_ejercicio', $periodo->id_ejercicio)
                        ->get();

                // Indicadores del programa del periodo
                $indicadores = Indicadores::where('activo', 1)
                        ->where('id_programa', $periodo->id_programa)
                        ->where(function ($query) use ($periodo) {
                                $query->where('id', $periodo->id_indicador) // Traer el actual
                                        ->orWhereNotIn('id', function ($subquery) use ($periodo) {
                                                // Excluir indicadores que ya están en uso en este ejercicio y programa
                                                $subquery->select('id_indicador')
                                                        ->from('periodos') // Asegúrate que este sea el nombre real de tu tabla
                                                        ->where('id_ejercicio', $periodo->id_ejercicio)
                                                        ->where('id_programa', $periodo->id_programa)
                                                        ->whereNotNull('id_indicador');
                                        });
                        })
                        ->get();

                return view('periodos.edit', compact(
                        'periodo',
                        'ejercicios',
                        'programas',
                        'indicadores'
                ));
        }


        public function update(Request $request, Periodo $periodo)
        {
                $request->validate([
                        'id_ejercicio' => 'required|exists:ejercicios,id',
                        'id_programa'  => 'required|exists:programas,id',
                        'id_indicador' => 'required|exists:indicadores,id',
                        'periodo'      => 'required|in:diario,semanal,mensual,trimestral,anual',
                        'dias_inicio'  => 'required|integer|min:0|lte:dias_final',
                        'dias_final'   => 'required|integer|min:0',
                ], [
                        'dias_inicio.lte' => 'El día de inicio no puede ser mayor al día final.',
                        'id_ejercicio.exists' => 'El ejercicio seleccionado no es válido.',
                ]);

                // Usar fill() y save() es más seguro que all() si no has definido $fillable
                $periodo->fill($request->all());
                $periodo->save();

                return redirect()->route('periodos.index')->with('success', 'Periodo actualizado');
        }


        public function destroy(Periodo $periodo)
        {
                $periodo->delete();
                return back();
        }


        public function toggle(Periodo $periodo)
        {
                // Si es 1, cámbialo a 2. Si no, cámbialo a 1.
                $nuevoEstado = ($periodo->status == 1) ? 0 : 1;
                $periodo->update(['status' => $nuevoEstado]);
                return back()->with('success', 'Estado actualizado correctamente');
        }
}
