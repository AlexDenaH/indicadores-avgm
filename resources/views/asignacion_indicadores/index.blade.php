<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Asignación de Indicadores</h1>
            <a href="{{ route('asignaciones.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                Nueva asignación
            </a>
        </div>
        <!--  barra de busqueda -->
        <div class="mb-6">
            <form method="GET" action="{{ route('asignaciones.index') }}"
                class="flex flex-col sm:flex-row gap-3">

                <input
                    type="text"
                    name="q"
                    value="{{ $busqueda }}"
                    placeholder="Buscar por ejercicio, programa o área…"
                    class="w-full sm:flex-1 rounded-md border-gray-300
                   focus:border-blue-500 focus:ring-blue-500 px-4 py-2">

                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded
                       hover:bg-blue-700 transition">
                        Buscar
                    </button>

                    @if($busqueda)
                    <a href="{{ route('asignaciones.index') }}"
                        class="bg-red-600 text-white px-4 py-2 rounded
                          hover:bg-gray-400 transition">
                        Limpiar
                    </a>
                    @endif
                </div>
            </form>
        </div>
        <!-- fin barra de busqueda -->

        <table class="w-full border text-sm">
            <thead class="bg-white">
                <tr>
                    <th class="border p-2">Área</th>
                    <th class="border p-2">Ejercicio</th>
                    <th class="border p-2">Programa</th>
                    <th class="border p-2">Indicadores</th>
                    <th class="border p-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaciones as $a)
                <tr>
                    <td class="border p-2">{{ $a->area->unidad_area }}</td>
                    <td class="border p-2">{{ $a->ejercicio->ejercicio }}</td>
                    <td class="border p-2">{{ $a->programa->programa }}</td>
                    <td class="px-4 py-2">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($a->indicadores_detalle as $ind)
                            <li>{{ $ind }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="border p-2 text-center space-x-2">
                        <a href="{{ route('asignaciones.edit', $a) }}"
                            class="text-blue-600">Editar</a>

                        <form action="{{ route('asignaciones.destroy', $a) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('¿Eliminar asignación?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($asignaciones->isEmpty())
        <div class="text-center text-gray-500 py-10">
            No se encontraron resultados con la búsqueda.
        </div>
        @endif
    </div>
</x-app-layout>