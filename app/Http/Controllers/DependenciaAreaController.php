<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\DependenciaArea;
use Illuminate\Http\Request;

class DependenciaAreaController extends Controller
{


    public function index()
    {
        $areas = DependenciaArea::with('dependencia')->get();
        return view('catalogos.dependencia_areas.index', compact('areas'));
    }

    public function create()
    {
        $dependencias = Dependencia::where('activa', true)->get();
        return view('catalogos.dependencia_areas.create', compact('dependencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dependencia' => 'required|exists:dependencias,id',
            'unidad_area' => 'required|string|max:255',
            'activa' => 'boolean',
        ]);

        DependenciaArea::create($request->all());
        return redirect()->route('dependencia_areas.index')->with('success', 'Área creada');
    }

    public function edit(DependenciaArea $dependencia_area)
    {
        $dependencias = Dependencia::where('activa', true)->get();
        return view('catalogos.dependencia_areas.edit', compact('dependencia_area', 'dependencias'));
    }

    public function update(Request $request, DependenciaArea $dependencia_area)
    {
        $request->validate([
            'id_dependencia' => 'required|exists:dependencias,id',
            'unidad_area' => 'required|string|max:255',
            'activa' => 'boolean',
        ]);

        $dependencia_area->update($request->all());
        return redirect()->route('dependencia_areas.index')->with('success', 'Área actualizada');
    }

    public function destroy(DependenciaArea $dependencia_area)
    {
        $dependencia_area->delete();
        return redirect()->route('dependencia_areas.index')->with('success', 'Área eliminada');
    }
}
