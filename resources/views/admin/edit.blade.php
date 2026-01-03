@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded shadow">

    <!-- Título -->
    <h1 class="text-2xl font-bold mb-6">
        Asignar indicadores a: {{ $dependencia->nombre }}
    </h1>

    <!-- Formulario -->
    <form method="POST"
          action="{{ route('dependencias.indicadores.update', $dependencia) }}">
        @csrf

        <!-- Listado de indicadores -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @foreach($indicadores as $indicador)
                <label class="flex gap-3 p-3 border rounded hover:bg-gray-50">

                    <!-- Checkbox del indicador -->
                    <input
                        type="checkbox"
                        name="indicadores[]"
                        value="{{ $indicador->id }}"
                        class="mt-1"
                        {{ $dependencia->indicadores->contains($indicador->id) ? 'checked' : '' }}
                    >

                    <!-- Información del indicador -->
                    <div>
                        <p class="font-semibold">
                            {{ $indicador->clave }} – {{ $indicador->nombre }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ $indicador->descripcion }}
                        </p>
                    </div>
                </label>
            @endforeach

        </div>

        <!-- Botón -->
        <div class="mt-6 text-right">
            <button class="bg-blue-600 text-white px-6 py-2 rounded">
                Guardar asignación
            </button>
        </div>

    </form>
</div>
@endsection
