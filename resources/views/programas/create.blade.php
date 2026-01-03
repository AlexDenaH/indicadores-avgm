<x-app-layout>
    <div class="max-w-3xl mx-auto p-6" x-data="{}">
        <h1 class="text-xl font-bold mb-4">Crear Programa</h1>


        <form method="POST" action="{{ route('programas.store') }}" class="space-y-4">
            @csrf


            <div>
                <label>Ejercicio</label>
                <select name="id_ejercicio" class="w-full border rounded p-2">
                    @foreach($ejercicios as $e)
                    <option value="{{ $e->id }}">{{ $e->ejercicio }}</option>
                    @endforeach
                </select>
            </div>


            <div>
                <label>Programa</label>
                <input type="text" name="programa" class="w-full border rounded p-2" required>
            </div>
                <a href="{{ route('programas.index') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium
                          text-white bg-red-600 rounded-md">
                    Cancelar
                </a>
            <button class="inline-flex items-center px-4 py-2 text-sm font-medium
                            bg-blue-600 text-white rounded-md ">Guardar</button>
        </form>
    </div>
</x-app-layout>