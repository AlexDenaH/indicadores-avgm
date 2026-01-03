<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Catálogo de Indicadores
            </h2>

            <a href="{{ route('indicadores.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Indicador
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded overflow-hidden">

                <table class="w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 border text-left">Clave</th>
                            <th class="p-3 border text-left">Nombre</th>
                            <th class="p-3 border text-left">Descripción</th>
                            <th class="p-3 border text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($indicadores as $indicador)
                            <tr>
                                <td class="p-3 border">{{ $indicador->clave }}</td>
                                <td class="p-3 border">{{ $indicador->nombre }}</td>
                                <td class="p-3 border">
                                    {{ Str::limit($indicador->descripcion, 80) }}
                                </td>
                                <td class="p-3 border text-center">

                                    <a href="{{ route('indicadores.edit', $indicador) }}"
                                       class="text-blue-600 hover:underline">
                                        Editar
                                    </a>

                                    <form action="{{ route('indicadores.destroy', $indicador) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('¿Deseas eliminar este indicador?')"
                                                class="text-red-600 hover:underline ml-2">
                                            Eliminar
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="p-6 text-center text-gray-500">
                                    No hay indicadores registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
