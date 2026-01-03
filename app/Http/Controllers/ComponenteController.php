<?php

namespace App\Http\Controllers;

use App\Models\Componente;
use App\Models\Indicadores;
use Illuminate\Http\Request;


class ComponenteController extends Controller
{
    public function index()
    {
$componentes = Componente::whereHas('indicadores', function ($query) {
        // 1️⃣ Indicador activo
        $query->where('activo', 1)
            ->whereHas('programa', function ($qProg) {
                // 2️⃣ Programa activo
                $qProg->where('activo', 1)
                    ->whereHas('ejercicio', function ($qEj) {
                        // 3️⃣ Ejercicio activo
                        $qEj->where('activo', 1);
                    });
            });
    })
    ->with([
        'indicadores' => function ($query) {
            $query->where('activo', 1)
                ->with([
                    'programa' => function ($qProg) {
                        $qProg->where('activo', 1)
                            ->with([
                                'ejercicio' => function ($qEj) {
                                    $qEj->where('activo', 1);
                                }
                            ]);
                    }
                ]);
        }
    ])
    ->get();
        return view('componentes.index', compact('componentes'));
    }


    public function create()
    {
        $indicadores = Indicadores::where('activo', 1)->get();
        return view('componentes.create', compact('indicadores'));
    }


    public function store(Request $request)
    {
        $request->validate(
            [
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
        $data = $request->only('id_indicador', 'componente');
        $data['tiene_subcomponentes'] = $request->boolean('tiene_subcomponentes');
        $data['subcomponentes'] = $data['tiene_subcomponentes']
            ? array_values(array_filter($request->subcomponentes ?? []))
            : [];

        Componente::create($data);
        return redirect()->route('componentes.index');
    }


    public function edit(Componente $componente)
    {
        $indicadores = Indicadores::all();
        return view('componentes.edit', compact('componente', 'indicadores'));
    }


    public function update(Request $request, Componente $componente)
    {

        $request->validate(
            [
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

        $data = $request->only('id_indicador', 'componente');
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
