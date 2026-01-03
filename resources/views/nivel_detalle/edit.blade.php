<x-app-layout>
    <div class="max-w-xl mx-auto py-6">

        <form method="POST"
              action="{{ route('nivel-detalle.update', $nivel_detalle) }}"
              class="space-y-4">
            @csrf @method('PUT')

            <input name="tipo"
                   value="{{ old('tipo', $nivel_detalle->tipo) }}"
                   class="w-full border p-2">

            <textarea name="nivel_detalle"
                      rows="6"
                      class="w-full border p-2 font-mono">
{{ json_encode($nivel_detalle->nivel_detalle, JSON_PRETTY_PRINT) }}
            </textarea>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Actualizar
            </button>
        </form>

    </div>
</x-app-layout>
