<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">

        {{-- ENCABEZADO --}}
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Indicadores</h1>

            <a href="{{ route('indicadores.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Nuevo
            </a>
        </div>

        {{-- BUSCADOR --}}
        <form method="GET"
            action="{{ route('indicadores.index') }}"
            class="mb-4">

            <div class="flex flex-col sm:flex-row items-stretch gap-2">

                {{-- INPUT --}}
                <div class="flex-1">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Buscar indicador, programa o detalle..."
                        class="w-full border rounded px-3 py-2
                       focus:ring focus:ring-blue-200
                       focus:outline-none">
                </div>

                {{-- BOTÓN --}}
                <div>
                    <button
                        type="submit"
                        class="w-full sm:w-auto
                       bg-blue-600 hover:bg-blue-700
                       text-white px-6 py-2 rounded
                       transition">
                        Buscar
                    </button>
                </div>

            </div>
        </form>

        {{-- TABLA --}}
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-2">Indicador</th>
                        <th class="p-2">Programa</th>
                        <th class="p-2">Ejercicio</th>
                        <th class="p-2">Medición</th>
                        <th class="p-2">Detalle</th>
                        <th class="p-2 text-center">Estado</th>
                        <th class="p-2 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($indicadores as $i)
                    <tr class="border-t hover:bg-gray-50">

                        {{-- INDICADOR --}}
                        <td class="p-2 font-medium">
                            {{ $i->indicador }}
                        </td>

                        {{-- PROGRAMA --}}
                        <td class="p-2">
                            {{ $i->programa->programa ?? '—' }}
                        </td>

                        {{-- EJERCICIO --}}
                        <td class="p-2">
                            {{ $i->programa->ejercicio->ejercicio ?? '—' }}
                        </td>

                        {{-- MEDICIÓN --}}
                        <td class="p-2">
                            {{ ucfirst($i->medicion) }}
                        </td>

                        {{-- DETALLE (JSON -> nivel_detalle) --}}
                        <td class="p-2">
                            @php
                            $detalles = $i->detalles();
                            @endphp

                            @if($detalles->count())
                            @foreach($detalles as $d)
                            <span class="inline-block bg-gray-200 text-xs px-2 py-1 rounded mr-1 mb-1">
                                {{ $d->tipo }}
                            </span>
                            @endforeach
                            @else
                            <span class="text-gray-400 text-sm">Sin detalle</span>
                            @endif
                        </td>

                        {{-- ESTADO --}}
                        <td class="p-2 text-center">
                            <form method="POST" action="{{ route('indicadores.toggle', $i) }}">
                                @csrf
                                @method('PATCH')

                                <button
                                    class="px-3 py-1 rounded text-white text-sm
                                            {{ $i->activo ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-500 hover:bg-gray-600' }}">
                                    {{ $i->activo ? 'Activo' : 'Inactivo' }}
                                </button>
                            </form>
                        </td>

                        {{-- ACCIONES --}}
                        <td class="p-2 flex justify-center gap-2">
                            <a href="{{ route('indicadores.edit', $i) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Editar
                            </a>

                            <form method="POST"
                                action="{{ route('indicadores.destroy', $i) }}"
                                onsubmit="return confirm('¿Eliminar indicador?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            No se encontraron indicadores
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>