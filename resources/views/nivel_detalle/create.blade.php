<x-app-layout>
    <div class="max-w-xl mx-auto py-6">

        <form method="POST" action="{{ route('nivel-detalle.store') }}" class="space-y-4">
            @csrf

            <input name="tipo"
                   class="w-full border p-2"
                   placeholder="Tipo de detalle">

            <textarea name="nivel_detalle"
                      rows="6"
                      class="w-full border p-2 font-mono"
                      placeholder='[{"id":1,"descripcion":"Texto"}]'></textarea>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Guardar
            </button>
        </form>

    </div>
</x-app-layout>
