<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">

        <!-- ENCABEZADO -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                ✏️ Editar Ejercicio
            </h2>
            <p class="text-sm text-gray-500">
                Modifica el ejercicio presupuestal.
            </p>
        </div>

        <!-- ERRORES -->
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 p-4">
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORMULARIO -->
        <form method="POST" action="{{ route('ejercicios.update', $ejercicio) }}"
              class="bg-white shadow rounded-lg p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- EJERCICIO -->
            <div>
                <label for="ejercicio" class="block text-sm font-medium text-gray-700">
                    Ejercicio (Año)
                </label>
                <input
                    type="number"
                    name="ejercicio"
                    id="ejercicio"
                    value="{{ old('ejercicio', $ejercicio->ejercicio) }}"
                    min="2000"
                    max="{{ now()->year + 1 }}"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                           focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
            </div>

            <!-- ACTIVO -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="activo"
                    id="activo"
                    value="1"
                    {{ old('activo', $ejercicio->activo) ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >
                <label for="activo" class="ml-2 block text-sm text-gray-700">
                    Ejercicio activo
                </label>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('ejercicios.index') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium
                          text-white bg-red-600 rounded-md ">
                    Cancelar
                </a>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium
                               text-white bg-blue-600 rounded-md ">
                    Actualizar
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
