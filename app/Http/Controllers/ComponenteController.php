<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Ejercicio;
use App\Models\Indicadores;
use Illuminate\Http\Request;


class ComponenteController extends Controller
{
    public function index(Request $request)
    {
        // Capturamos el término de búsqueda enviado desde el formulario
        $search = $request->input('search');

        $componentes = Componente::with([
            'programa:id,id_ejercicio,programa',
            'indicadores:id,indicador'
        ])
            ->whereHas('programa.ejercicio', function ($q) {
                $q->where('activo', 1);
            })
            ->whereHas('programa', fn($q) => $q->where('activo', 1))
            ->whereHas('indicadores', fn($q) => $q->where('activo', 1))
            ->when($search, function ($q) use ($search) {
                $q->where('componente', 'like', "%{$search}%")
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

        // Retornamos la vista con los componentes y el término de búsqueda (para mantenerlo en la barra)
        return view('componentes.index', compact('componentes', 'search'));
    }



    public function create()
    {
        $ejercicios = Ejercicio::where('activo', 1)->get();
        $indicadores = Indicadores::where('activo', 1)->get();
        return view('componentes.create', compact('ejercicios', 'indicadores'));
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'id_programa'  => 'required|exists:programas,id',
                'id_indicador' => 'required|exists:indicadores,id',
                'componente' => 'required|string|max:255',
                'subcomponentes' => 'nullable|array'
            ],
            [
                // id_indicador
                'id_indicador.required' => 'Debe seleccionar un indicador.',
                'id_indicador.exists' => 'El indicador seleccionado no es válido.',
                // componente
                'componente.required' => 'El nombre del componente es obligatorio.',
                'componente.string' => 'El componente debe ser texto.',
                'componente.max' => 'El componente no puede exceder 255 caracteres.',
                // subcomponentes
                'subcomponentes.array' => 'Los subcomponentes deben enviarse como una lista.'
            ]
        );
        $data = $request->only('id_programa', 'id_indicador', 'componente');
        $data['tiene_subcomponentes'] = $request->boolean('tiene_subcomponentes');
        $data['subcomponentes'] = $data['tiene_subcomponentes']
            ? array_values(array_filter($request->subcomponentes ?? []))
            : [];

        Componente::create($data);
        return redirect()->route('componentes.index');
    }


    public function edit(Componente $componente)
    {
        $ejercicios = Ejercicio::where('activo', 1)->get();
        $indicadores = Indicadores::all();
        return view('componentes.edit', compact('componente', 'ejercicios', 'indicadores'));
    }


    public function update(Request $request, Componente $componente)
    {

        $request->validate(
            [
                'id_programa'  => 'required|exists:programas,id',
                'id_indicador' => 'required|exists:indicadores,id',
                'componente' => 'required|string|max:255',
                'subcomponentes' => 'nullable|array'
            ],
            [
                // id_indicador
                'id_indicador.required' => 'Debe seleccionar un indicador.',
                'id_indicador.exists' => 'El indicador seleccionado no es válido.',
                // componente
                'componente.required' => 'El nombre del componente es obligatorio.',
                'componente.string' => 'El componente debe ser texto.',
                'componente.max' => 'El componente no puede exceder 255 caracteres.',
                // subcomponentes
                'subcomponentes.array' => 'Los subcomponentes deben enviarse como una lista.'
            ]
        );

        $data = $request->only('id_programa', 'id_indicador', 'componente');
        $data['tiene_subcomponentes'] = $request->boolean('tiene_subcomponentes');
        $data['subcomponentes'] = $data['tiene_subcomponentes']
            ? array_values(array_filter($request->subcomponentes ?? []))
            : [];

        $componente->update($data);

        return redirect()->route('componentes.index');
    }


    public function destroy(Componente $componente)
    {
        $componente->delete();
        return back();
    }
}
