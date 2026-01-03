<?php
namespace App\Http\Controllers;


use App\Models\Ejercicio;
use Illuminate\Http\Request;


class EjercicioController extends Controller
{
/**
* Muestra listado de ejercicios
*/
    public function index()
    {
     $ejercicios = Ejercicio::orderBy('ejercicio','desc')->get();
     return view('ejercicios.index', compact('ejercicios'));
    }


/**
* Muestra formulario de creación
*/
        public function create()
        {
            return view('ejercicios.create');
        }
/**
* Guarda nuevo ejercicio
*/
public function store(Request $request)
{
        $request->validate([
        'ejercicio' => 'required|digits:4|unique:ejercicios,ejercicio'
        ]);


        Ejercicio::create([
        'ejercicio' => $request->ejercicio,
        'activo' => true
        ]);


        return redirect()->route('ejercicios.index')
        ->with('success','Ejercicio creado correctamente');
}


/**
* Muestra formulario de edición
*/
public function edit(Ejercicio $ejercicio)
{
return view('ejercicios.edit', compact('ejercicio'));
}


/**
* Actualiza ejercicio
*/
public function update(Request $request, Ejercicio $ejercicio)
{
        $request->validate([
        'ejercicio' => 'required|digits:4|unique:ejercicios,ejercicio,' . $ejercicio->id
        ]);

        $data = $request->all();
        $data['activo'] = $request->has('activo');
        $ejercicio->update($data);

        return redirect()->route('ejercicios.index')
        ->with('success','Ejercicio actualizado');
}


/**
* Elimina ejercicio
*/
public function destroy(Ejercicio $ejercicio)
{
        $ejercicio->delete();
        return back()->with('success','Ejercicio eliminado');
}


/**
* Activa / desactiva ejercicio
*/
public function toggle(Ejercicio $ejercicio)
{
        $ejercicio->update(['activo' => !$ejercicio->activo]);
        return back();
}
}