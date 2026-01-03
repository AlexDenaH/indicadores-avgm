<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-xl font-bold">Componentes</h1>
            <a href="{{ route('componentes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo</a>
        </div>


        <table class="w-full border">
            <thead class="bg-white">
                <tr>
                    <th class="p-2">Componente</th>
                    <th class="p-2">Indicador</th>
                    <th class="p-2">Subcomponentes</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($componentes as $c)
                <tr class="border-t">
                    <td class="p-2">{{ $c->componente }}</td>
                    <td class="p-2">{{ $c->indicadores->indicador }}</td>
                    <td class="p-2">
                        @if($c->tiene_subcomponentes)
                        <ul class="list-disc pl-4">
                            @foreach($c->subcomponentes ?? [] as $s)
                            <li>{{ $s }}</li>
                            @endforeach
                        </ul>
                        @else
                        —
                        @endif
                    </td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('componentes.edit',$c) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>
                        <form method="POST" action="{{ route('componentes.destroy',$c) }}" onsubmit="return confirm('¿Eliminar componente?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-600 text-white px-2 py-1 rounded">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>