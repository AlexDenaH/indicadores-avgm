<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Editar Programa</h1>


        <form method="POST" action="{{ route('programas.update',$programa) }}" class="space-y-4">
            @csrf @method('PUT')


            <select name="id_ejercicio" class="w-full border p-2">
                @foreach($ejercicios as $e)
                <option value="{{ $e->id }}" @selected($programa->ejercicio_id==$e->id)>
                    {{ $e->ejercicio }}
                </option>
                @endforeach
            </select>


            <input type="text" name="programa" value="{{ $programa->programa }}" class="w-full border p-2">


            <label class="flex items-center gap-2">
                <input type="checkbox" name="activo" value="1" @checked($programa->activo)>
                Activo
            </label>

            <div class="flex justify-end">
                <a
                    href="{{ route('programas.index') }}"
                    class="bg-red-600 text-white px-4 py-2 rounded-md border">
                    Cancelar
                </a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>