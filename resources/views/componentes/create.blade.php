<x-app-layout>
    <div
        class="max-w-4xl mx-auto p-6"
        x-data="{
            indicadores: @js($indicadores),
            id_indicador: Number('{{ old('id_indicador') }}'),
            tieneSub: {{ old('tiene_subcomponentes', 0) ? 'true' : 'false' }},
            subcomponentes: @js(old('subcomponentes', ['']))
        }"
    >
        <h1 class="text-xl font-bold mb-4">Crear Componente</h1>

        <!-- ERRORES -->
        @if ($errors->any())
            <div class="mb-4 bg-red-50 p-4 rounded">
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('componentes.store') }}" class="space-y-4">
            @csrf

            <!-- INDICADOR -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Indicador <span class="text-red-500">*</span>
                </label>

                <select
                    name="id_indicador"
                    x-model="id_indicador"
                    class="w-full border p-2 rounded @error('id_indicador') border-red-500 @enderror"
                    required
                >
                    <option value="">Seleccione Indicador</option>

                    <template x-for="i in indicadores" :key="i.id">
                        <option
                            :value="i.id"
                            :selected="i.id === id_indicador"
                            x-text="i.indicador"
                        ></option>
                    </template>
                </select>

                @error('id_indicador')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- COMPONENTE -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Componente <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="componente"
                    value="{{ old('componente') }}"
                    class="w-full border p-2 rounded @error('componente') border-red-500 @enderror"
                    required
                >
            </div>

            <!-- TIENE SUBCOMPONENTES -->
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    name="tiene_subcomponentes"
                    value="1"
                    x-model="tieneSub"
                >
                <span class="text-sm">¿Tiene subcomponentes?</span>
            </div>

            <!-- SUBCOMPONENTES -->
            <div x-show="tieneSub" x-transition>
                <label class="block text-sm font-medium mb-1">
                    Subcomponentes
                </label>

                <template x-for="(sub, index) in subcomponentes" :key="index">
                    <div class="flex gap-2 mb-2">
                        <input
                            type="text"
                            name="subcomponentes[]"
                            x-model="subcomponentes[index]"
                            class="w-full border p-2 rounded"
                        >
                        <button
                            type="button"
                            class="text-red-600"
                            @click="subcomponentes.splice(index,1)"
                        >
                            ✕
                        </button>
                    </div>
                </template>

                <button
                    type="button"
                    class="text-blue-600 text-sm"
                    @click="subcomponentes.push('')"
                >
                    + Agregar subcomponente
                </button>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('componentes.index') }}" class="border px-4 py-2 rounded">
                    Cancelar
                </a>

                <button class="bg-blue-600 text-white px-6 py-2 rounded">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
