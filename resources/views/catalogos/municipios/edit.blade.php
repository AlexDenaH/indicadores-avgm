<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Municipio
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl">

        <form method="POST" action="{{ route('municipios.update', $municipio) }}">
            @csrf
            @method('PUT')

            <!-- Clave (Número) -->
            <div class="mb-4">
                <label class="block font-medium">Clave</label>
                <input type="number" 
                       name="clave" 
                       value="{{ old('clave', $municipio->clave) }}"
                       class="w-full border rounded px-3 py-2" 
                       required>
            </div>

            <!-- Nombre -->
            <div class="mb-4">
                <label class="block font-medium">Nombre del municipio</label>
                <input type="text"
                       name="nombre"
                       value="{{ old('nombre', $municipio->nombre) }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <!-- Clave INEGI (Varchar 3, solo números) -->
            <div class="mb-4">
                <label class="block font-medium">Clave INEGI (3 dígitos)</label>
                <input type="text" 
                       name="clave_inegi"
                       value="{{ old('clave_inegi', $municipio->clave_inegi) }}"
                       pattern="[0-9]{3}" 
                       maxlength="3"
                       title="Debe contener exactamente 3 números (ej. 001, 050)"
                       class="w-full border rounded px-3 py-2"
                       placeholder="001" 
                       required>
                <small class="text-gray-500">Formato: 3 dígitos (ej. 001, 099)</small>
            </div>

            <div class="flex gap-2">
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Actualizar
                </button>

                <a href="{{ route('municipios.index') }}"
                   class="px-4 py-2 border rounded">
                    Cancelar
                </a>
            </div>
        </form>

    </div>
</x-app-layout>
