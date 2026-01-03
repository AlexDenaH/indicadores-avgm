<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Indicador
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">

                <form method="POST"
                      action="{{ route('indicadores.update', $indicador) }}">
                    @csrf
                    @method('PUT')

                    {{-- CLAVE --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Clave del indicador
                        </label>
                        <input type="text"
                               name="clave"
                               value="{{ old('clave', $indicador->clave) }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                        @error('clave')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NOMBRE --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-1">
                            Nombre del indicador
                        </label>
                        <input type="text"
                               name="nombre"
                               value="{{ old('nombre', $indicador->nombre) }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                        @error('nombre')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="mb-6">
                        <label class="block font-medium mb-1">
                            Descripción
                        </label>
                        <textarea name="descripcion"
                                  rows="4"
                                  class="w-full border rounded px-3 py-2">{{ old('descripcion', $indicador->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex gap-3">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Actualizar
                        </button>

                        <a href="{{ route('indicadores.index') }}"
                           class="px-4 py-2 border rounded hover:bg-gray-100">
                            Cancelar
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
