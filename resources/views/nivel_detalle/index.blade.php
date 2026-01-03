<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Catálogo Nivel Detalle</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <a href="{{ route('nivel-detalle.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Nuevo
        </a>

        <table class="mt-4 w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Tipo</th>
                    <th class="p-2">Nivel Detalle (JSON)</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($niveles as $n)
                <tr class="border-t">
                    <td class="p-2">{{ $n->tipo }}</td>
                    <td class="p-2 text-xs font-mono">
                        {{ json_encode($n->nivel_detalle, JSON_PRETTY_PRINT) }}
                    </td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('nivel-detalle.edit', $n) }}" class="text-yellow-600">✏️</a>

                        <form method="POST"
                              action="{{ route('nivel-detalle.destroy', $n) }}">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Eliminar?')"
                                    class="text-red-600">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
