<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use Illuminate\Http\Request;

class DependenciaController extends Controller
{


    public function index(Request $request)
    {
        // Captura el término de búsqueda
        $q = $request->q;
        // Consulta principal
        $dependencias = Dependencia::query()
            // Aplica búsqueda solo si existe el parámetro q
            ->when($q, function ($query, $q) {
                $query->where('nombre', 'like', "%{$q}%")
                    ->orWhere('siglas', 'like', "%{$q}%")
                    ->orWhere('tipo_dependencia', 'like', "%{$q}%");
            })
            // Orden alfabético
            ->orderBy('nombre')
            // Puedes cambiar get() por paginate(10)
            ->get();
        // Retorna la vista
        return view('catalogos.dependencias.index', compact('dependencias'));
    }

    public function create()
    {
        return view('catalogos.dependencias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'siglas' => 'nullable|string|max:50',
            'activa' => 'boolean',
            'tipo_dependencia' => 'required|in:Federal,Estatal,Municipal',
        ]);

        Dependencia::create($request->all());
        return redirect()->route('dependencias.index')->with('success', 'Dependencia creada');
    }

    public function edit(Dependencia $dependencia)
    {
        return view('catalogos.dependencias.edit', compact('dependencia'));
    }

    public function update(Request $request, Dependencia $dependencia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'siglas' => 'nullable|string|max:50',
            'activa' => 'boolean',
            'tipo_dependencia' => 'required|in:Federal,Estatal,Municipal',
        ]);

        $dependencia->update($request->all());
        return redirect()->route('dependencias.index')->with('success', 'Dependencia actualizada');
    }

    public function destroy(Dependencia $dependencia)
    {
        $dependencia->delete();
        return redirect()->route('dependencias.index')->with('success', 'Dependencia eliminada');
    }
}
