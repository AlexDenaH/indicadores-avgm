<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        <div class="flex justify-between mb-4">
            <h1 class="text-xl font-bold">Periodos</h1>

            <a href="{{ route('periodos.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded">
                + Nuevo periodo
            </a>
        </div>

        <table class="w-full border text-sm">
            <thead class="bg-white">
                <tr>
                    <th class="p-2">Ejercicio</th>
                    <th class="p-2">Programa</th>
                    <th class="p-2">Indicador</th>
                    <th class="p-2">Periodo</th>
                    <th class="p-2">Inicio</th>
                    <th class="p-2">Final</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($periodos as $p)
                <tr class="border-t">
                    <td class="p-2">{{ $p->ejercicio->ejercicio }}</td>
                    <td class="p-2">{{ $p->programa->programa }}</td>
                    <td class="p-2">{{ $p->indicadores->indicador }}</td>
                    <td class="p-2 capitalize">{{ $p->periodo }}</td>
                    <td class="p-2">{{ $p->dias_inicio }}</td>
                    <td class="p-2">{{ $p->dias_final }}</td>

                    <!-- STATUS -->
                    <td class="p-2">
                        <form method="POST" action="{{ route('periodos.toggle', $p) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                class="px-3 py-1 rounded text-white transition-colors
                                {{ $p->status == 1 ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}">
                                {{ $p->status == 1 ? 'Abierto' : 'Cerrado' }}
                            </button>
                        </form>
                    </td>

                    <!-- ACCIONES -->
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('periodos.edit', $p) }}"
                            class="text-blue-600">Editar</a>

                        <form method="POST"
                            action="{{ route('periodos.destroy', $p) }}"
                            onsubmit="return confirm('¿Eliminar periodo?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>