<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-xl font-bold">Programas</h1>
            <a href="{{ route('programas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nuevo</a>
        </div>


        <table class="w-full border">
            <thead class="bg-white">
                <tr>
                    <th class="p-2">Programa</th>
                    <th class="p-2">Ejercicio</th>
                    <th class="p-2">Estado</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($programas as $p)
                <tr class="border-t">
                    <td class="p-2">{{ $p->programa }}</td>
                    <td class="p-2">{{ $p->ejercicio->ejercicio }}</td>
                    <td class="p-2">
                        <form method="POST" action="{{ route('programas.toggle',$p) }}">
                            @csrf @method('PATCH')
                            <button class="px-2 py-1 text-white rounded {{ $p->activo?'bg-green-600':'bg-gray-500' }}">
                                {{ $p->activo?'Activo':'Inactivo' }}
                            </button>
                        </form>
                    </td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('programas.edit',$p) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>
                        <form method="POST" action="{{ route('programas.destroy',$p) }}" onsubmit="return confirm('¿Eliminar programa?')">
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