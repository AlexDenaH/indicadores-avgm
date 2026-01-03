<x-app-layout>
    {{-- Encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Catálogo de Municipios
        </h2>
    </x-slot>

    {{-- Contenido principal --}}
    <div class="p-6">

        {{-- Botón para crear nuevo municipio --}}
        <a href="{{ route('municipios.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nuevo Municipio
        </a>

        {{-- Tabla de municipios --}}
        <div class="mt-6 bg-white shadow rounded">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border text-left">Clave</th>
                        <th class="p-2 border text-left">Clave INEGI</th>
                        <th class="p-2 border text-left">Nombre</th>
                        <th class="p-2 border text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($municipios as $municipio)
                        <tr>
                            <td class="p-2 border">{{ $municipio->clave }}</td>
                            <td class="p-2 border">{{ $municipio->clave_inegi }}</td>
                            <td class="p-2 border">{{ $municipio->nombre }}</td>
                            <td class="p-2 border text-center">
                                <a href="{{ route('municipios.edit', $municipio) }}"
                                   class="text-blue-600 hover:underline">
                                    Editar
                                </a>

                                <form action="{{ route('municipios.destroy', $municipio) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este municipio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline ml-2">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                No hay municipios registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
