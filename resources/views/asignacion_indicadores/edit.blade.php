<x-app-layout>
    <div x-data="formEditar()"
        data-asignacion='@json($asignacionIndicador)'
        class="max-w-5xl mx-auto p-6 bg-white rounded shadow">

        <h1 class="text-xl font-bold mb-4">Editar asignación</h1>

        <form method="POST"
            action="{{ route('asignaciones.update', $asignacionIndicador) }}">
            @csrf
            @method('PUT')

            <!-- Ejercicio -->
            <select x-model="ejercicio" @change="cargarProgramas"
                name="id_ejercicio" class="w-full mb-3">
                @foreach($ejercicios as $e)
                <option value="{{ $e->id }}">{{ $e->ejercicio }}</option>
                @endforeach
            </select>

            <!-- Programa -->
            <select x-model="programa" @change="cargarIndicadores"
                name="id_programa" class="w-full mb-3">
                <template x-for="p in programas" :key="p.id">
                    <option :value="p.id" x-text="p.programa"></option>
                </template>
            </select>

            <!-- Área -->
            <select name="id_area" class="w-full mb-3">
                @foreach($areas as $a)
                <option value="{{ $a->id }}"
                    @selected($a->id == $asignacionIndicador->id_area)>
                    {{ $a->unidad_area }}
                </option>
                @endforeach
            </select>

            <!-- Indicadores -->
            <div class="border rounded p-3 max-h-60 overflow-y-auto">
                <template x-for="i in indicadores" :key="i.id">
                    <label class="block">
                        <input type="checkbox"
                            name="indicadores[]"
                            :value="i.id"
                            :checked="seleccionados.includes(i.id)">
                        <span x-text="i.indicador"></span>
                    </label>
                </template>
            </div>

            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Actualizar
            </button>
        </form>
    </div>

</x-app-layout>