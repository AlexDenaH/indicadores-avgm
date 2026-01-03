<x-app-layout>

    {{-- ENCABEZADO --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Catálogo de Dependencias
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- BOTÓN NUEVA DEPENDENCIA --}}
            <div class="mb-4 flex justify-between items-center">

                {{-- BOTÓN CREAR --}}
                <a href="{{ route('dependencias.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Nueva Dependencia
                </a>

                {{-- FORMULARIO DE BÚSQUEDA --}}
                <form method="GET"
                      action="{{ route('dependencias.index') }}"
                      class="flex gap-2">

                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar por nombre, siglas o tipo..."
                        class="border rounded px-4 py-2 w-64 focus:ring focus:ring-blue-200"
                    >

                    <button
                        type="submit"
                        class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
                        Buscar
                    </button>
                </form>
            </div>

            {{-- TABLA --}}
            <div class="bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full text-sm">

                    {{-- CABECERA --}}
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-4 text-left">Nombre</th>
                            <th class="px-4 py-4 text-center">Siglas</th>
                            <th class="px-4 py-4 text-center">Tipo</th>
                            <th class="px-4 py-4 text-center">Activa</th>
                            <th class="px-4 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>

                    {{-- CUERPO --}}
                    <tbody>
                        @forelse ($dependencias as $dep)
                            <tr class="border-t hover:bg-gray-50">

                                {{-- NOMBRE --}}
                                <td class="px-4 py-4">
                                    {{ $dep->nombre }}
                                </td>

                                {{-- SIGLAS --}}
                                <td class="px-4 py-4 text-center">
                                    {{ $dep->siglas }}
                                </td>

                                {{-- TIPO DEPENDENCIA (BADGE CON COLOR) --}}
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        @class([
                                            'bg-blue-100 text-blue-800' => $dep->tipo_dependencia === 'Federal',
                                            'bg-green-100 text-green-800' => $dep->tipo_dependencia === 'Estatal',
                                            'bg-purple-100 text-purple-800' => $dep->tipo_dependencia === 'Municipal',
                                        ])">
                                        {{ $dep->tipo_dependencia }}
                                    </span>
                                </td>

                                {{-- ACTIVA --}}
                                <td class="px-4 py-4 text-center">
                                    {{ $dep->activa ? 'Sí' : 'No' }}
                                </td>

                                {{-- ACCIONES --}}
                                <td class="px-4 py-4 flex justify-center gap-3">

                                    {{-- EDITAR --}}
                                    <a href="{{ route('dependencias.edit', $dep) }}"
                                       class="text-yellow-500 hover:text-yellow-700"
                                       title="Editar">
                                        ✏️
                                    </a>

                                    {{-- ELIMINAR --}}
                                    <form method="POST"
                                          action="{{ route('dependencias.destroy', $dep) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="text-red-500 hover:text-red-700"
                                            onclick="return confirm('¿Eliminar dependencia?')"
                                            title="Eliminar">
                                            🗑️
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            {{-- CUANDO NO HAY REGISTROS --}}
                            <tr>
                                <td colspan="5"
                                    class="px-4 py-6 text-center text-gray-500">
                                    No se encontraron dependencias.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINACIÓN (SI LA USAS) --}}
            @if(method_exists($dependencias, 'links'))
                <div class="mt-4">
                    {{ $dependencias->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>

</x-app-layout>
