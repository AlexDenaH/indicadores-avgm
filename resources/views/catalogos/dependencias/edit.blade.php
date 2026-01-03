<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ isset($dependencia) ? 'Editar Dependencia' : 'Nueva Dependencia' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">
        <form method="POST"
            action="{{ isset($dependencia) ? route('dependencias.update',$dependencia) : route('dependencias.store') }}"
            class="bg-white p-6 shadow rounded">
            @csrf
            @isset($dependencia) @method('PUT') @endisset

            <div class="mb-4">
                <label class="block">Nombre</label>
                <input type="text" name="nombre"
                    value="{{ old('nombre',$dependencia->nombre ?? '') }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block">Sigla</label>
                <input type="text" name="siglas"
                    value="{{ old('siglas',$dependencia->siglas ?? '') }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <select name="tipo_dependencia" class="border p-2 rounded w-full">
                <option value="">-- Selecciona tipo --</option>
                <option value="Federal" {{ old('tipo_dependencia', $dependencia->tipo_dependencia ?? '') == 'Federal' ? 'selected' : '' }}>
                    Federal
                </option>
                <option value="Estatal" {{ old('tipo_dependencia', $dependencia->tipo_dependencia ?? '') == 'Estatal' ? 'selected' : '' }}>
                    Estatal
                </option>
                <option value="Municipal" {{ old('tipo_dependencia', $dependencia->tipo_dependencia ?? '') == 'Municipal' ? 'selected' : '' }}>
                    Municipal
                </option>
            </select>

            <div class="mb-4">
                <label>
                    <input type="checkbox" name="activa" value="1"
                        {{ old('activa',$dependencia->activa ?? true) ? 'checked' : '' }}>
                    Activa
                </label>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Guardar
            </button>
        </form>
    </div>
</x-app-layout>