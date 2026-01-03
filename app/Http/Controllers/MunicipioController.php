<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Mostrar listado de municipios
     */
    public function index()
    {
        $municipios = Municipio::orderBy('nombre')->get();

        return view('catalogos.municipios.index', compact('municipios'));
    }

    public function create()
    {
        return view('catalogos.municipios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
               'clave'       => 'required|integer',
            'nombre' => 'required|string|max:255',
            'clave_inegi' => 'required|string|size:3|regex:/^[0-9]+$/',
        ]);

       Municipio::create($request->all());

        return redirect()->route('municipios.index')
            ->with('success', 'Municipio creado correctamente');
    }

    public function edit(Municipio $municipio)
    {
        return view('catalogos.municipios.edit', compact('municipio'));
    }

    public function update(Request $request, Municipio $municipio)
    {
        $request->validate([
             'clave'       => 'required|integer',
            'nombre' => 'required|string|max:255',
            'clave_inegi' => 'required|string|size:3|regex:/^[0-9]+$/',
        ]);

        $municipio->update($request->all());

        return redirect()->route('municipios.index')
            ->with('success', 'Municipio actualizado');
    }

    public function destroy(Municipio $municipio)
    {
        $municipio->delete();

        return redirect()->route('municipios.index')
            ->with('success', 'Municipio eliminado');
    }
}
