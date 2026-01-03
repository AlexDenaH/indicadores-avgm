<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <a href="{{ route('ejercicios.create') }}" class="btn bg-blue-600 text-white px-4 py-2 rounded">Nuevo</a>
        <table class="w-full mt-4">
            @foreach($ejercicios as $e)
            <tr>
                <td>{{ $e->ejercicio }}</td>
                <td>
                    <form method="POST" action="{{ route('ejercicios.toggle',$e) }}">
                        @csrf @method('PATCH')
                        <button class="px-2 py-1 {{ $e->activo?'bg-green-500':'bg-gray-400' }} text-white">
                            {{ $e->activo?'Activo':'Inactivo' }}
                        </button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('ejercicios.edit',$e) }}">Editar</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>