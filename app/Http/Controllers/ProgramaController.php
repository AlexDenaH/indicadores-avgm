<?php
namespace App\Http\Controllers;


use App\Models\Programa;
use App\Models\Ejercicio;
use Illuminate\Http\Request;


class ProgramaController extends Controller
{
        public function index()
        {
        $ejercicios = Ejercicio::where('activo',1)->get();    
        $programas = Programa::whereHas('ejercicio', function ($q) {
                        $q->where('activo', 1);
                    })->with(['ejercicio' => function ($q) {
                        $q->where('activo', 1);
                    }])->get();
        return view('programas.index', compact('programas', 'ejercicios'));
        }


public function create()
{
    $ejercicios = Ejercicio::where('activo',1)->get();
    return view('programas.create', compact('ejercicios'));
}


public function store(Request $request)
{
    $request->validate([
    'programa' => 'required',
    'id_ejercicio' => 'required|exists:ejercicios,id'
    ]);


        Programa::create($request->all());


        return redirect()->route('programas.index')
        ->with('success','Programa creado');
}


public function edit(Programa $programa)
{
$ejercicios = Ejercicio::all();
return view('programas.edit', compact('programa','ejercicios'));
}


public function update(Request $request, Programa $programa)
{
    $data = $request->all();
    $data['activo'] = $request->has('activo');
    $programa->update($data );
    return redirect()->route('programas.index')
    ->with('success','Programa actualizado');
}


public function destroy(Programa $programa)
{
    $programa->delete();
    return back();
}


public function toggle(Programa $programa)
{
    $programa->update(['activo'=>!$programa->activo]);
    return back();
}
}