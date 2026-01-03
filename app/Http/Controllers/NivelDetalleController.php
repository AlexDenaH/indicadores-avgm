<?php

namespace App\Http\Controllers;

use App\Models\NivelDetalle;
use Illuminate\Http\Request;

class NivelDetalleController extends Controller
{
    public function index()
    {
        $niveles = NivelDetalle::orderBy('tipo')->get();
        return view('nivel_detalle.index', compact('niveles'));
    }

    public function create()
    {
        return view('nivel_detalle.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'nivel_detalle' => 'required|json',
        ]);

        NivelDetalle::create([
            'tipo' => $request->tipo,
            'nivel_detalle' => json_decode($request->nivel_detalle, true),
        ]);

        return redirect()->route('nivel-detalle.index')
            ->with('success', 'Nivel de detalle creado correctamente');
    }

    public function edit(NivelDetalle $nivel_detalle)
    {
        return view('nivel_detalle.edit', compact('nivel_detalle'));
    }

    public function update(Request $request, NivelDetalle $nivel_detalle)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'nivel_detalle' => 'required|json',
        ]);

        $nivel_detalle->update([
            'tipo' => $request->tipo,
           'nivel_detalle' => json_decode($request->nivel_detalle, true),
        ]);

        return redirect()->route('nivel-detalle.index')
            ->with('success', 'Nivel de detalle actualizado correctamente');
    }

    public function destroy(NivelDetalle $nivel_detalle)
    {
        $nivel_detalle->delete();

        return redirect()->route('nivel-detalle.index')
            ->with('success', 'Registro eliminado correctamente');
    }
}
