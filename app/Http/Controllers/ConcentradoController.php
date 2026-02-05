<?php

namespace App\Http\Controllers;

use App\Models\Concentrado;
use Illuminate\Http\Request;

class ConcentradoController extends Controller
{
    public function index(Request $request)
    {
        $concentrados = Concentrado::where('id_ejercicio', $request->id_ejercicio)
            ->where('id_programa', $request->id_programa)
            ->orderBy('temporalidad')
            ->get()
            ->groupBy(['temporalidad','id_nivel_detalle']);

        return view('concentrados.index', compact('concentrados'));
    }

    public function create(Request $request)
    {
        // Aquí solo mandas combos
        return view('concentrados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ejercicio' => 'required',
            'id_programa' => 'required',
            'id_indicador' => 'required',
            'id_detalle' => 'required',
            'total' => 'required|integer|min:0'
        ]);

        Concentrado::create([
            ...$request->all(),
            'temporalidad' => $this->calcularTemporalidad(
                $request->tipo_temporalidad
            )
        ]);

        return redirect()->route('concentrados.index')
            ->with('success', 'Registro guardado correctamente');
    }

    public function update(Request $request, Concentrado $concentrado)
    {
       // $this->authorize('update', $concentrado);

        $concentrado->update($request->only('total','observaciones'));

        return back()->with('success','Actualizado');
    }

    public function destroy(Concentrado $concentrado)
    {
       // $this->authorize('delete', $concentrado);

        $concentrado->delete();

        return back()->with('success','Eliminado');
    }

    private function calcularTemporalidad($tipo)
    {
        $hoy = now();

        return match ($tipo) {
            'diario','semanal' => $hoy->format('Y-m-d'),
            'mensual' => $hoy->subMonth()->translatedFormat('F'),
            'trimestral' => 'Trimestre cerrado',
            'semestral' => 'Semestre cerrado',
            'anual' => (string)($hoy->year - 1),
        };
    }
}
