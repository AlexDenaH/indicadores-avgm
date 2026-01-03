<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ isset($dependencia_area) ? 'Editar Área' : 'Nueva Área' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <form method="POST"
              action="{{ isset($dependencia_area) ? route('dependencia_areas.update',$dependencia_area) : route('dependencia_areas.store') }}"
              class="bg-white p-6 shadow rounded">
            @csrf
            @isset($dependencia_area) @method('PUT') @endisset

            <div class="mb-4">
                <label>Dependencia</label>
                <select name="id_dependencia" class="w-full border rounded px-3 py-2">
                    @foreach($dependencias as $dep)
                        <option value="{{ $dep->id }}"
                            {{ old('id_dependencia',$dependencia_area->id_dependencia ?? '') == $dep->id ? 'selected' : '' }}>
                            {{ $dep->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Área</label>
                <input type="text" name="unidad_area"
                       value="{{ old('unidad_area',$dependencia_area->unidad_area ?? '') }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <label>
                <input type="checkbox" name="activa" value="1"
                       {{ old('activa',$dependencia_area->activa ?? true) ? 'checked' : '' }}>
                Activa
            </label>

            <div class="mt-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
