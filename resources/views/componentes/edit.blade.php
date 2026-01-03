<x-app-layout>
    <!--
        CONTENEDOR PRINCIPAL
        x-data inicializa el estado Alpine usando:
        - indicadores: lista enviada desde el controlador
        - id_indicador: valor actual (old() o BD)
        - tieneSub: boolean real
        - subcomponentes: array desde BD (cast JSON) u old()
    -->
    <div
        class="max-w-4xl mx-auto p-6"
        x-data="{
            indicadores: @js($indicadores),

            // 🔹 Indicador seleccionado (STRING para evitar conflictos)
            id_indicador: '{{ old('id_indicador', $componente->id_indicador) }}',

            // 🔹 Checkbox tiene subcomponentes
            tieneSub: {{ old(
                'tiene_subcomponentes',
                $componente->tiene_subcomponentes
            ) ? 'true' : 'false' }},

            // 🔹 Subcomponentes desde BD (JSON) o formulario
            subcomponentes: @js(
                old('subcomponentes', $componente->subcomponentes ?? [''])
            )
        }">

        <!-- TÍTULO -->
        <h1 class="text-xl font-bold mb-6">
            Editar Componente
        </h1>

        <!-- ERRORES DE VALIDACIÓN -->
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded">
            <ul class="list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- FORMULARIO -->
        <form
            method="POST"
            action="{{ route('componentes.update', $componente->id) }}"
            class="space-y-5">
            @csrf
            @method('PUT')

            <!-- ===================================================== -->
            <!-- INDICADOR                                              -->
            <!-- Se maneja con :selected (NO x-model) para estabilidad -->
            <!-- ===================================================== -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Indicador <span class="text-red-500">*</span>
                </label>

                <select
                    name="id_indicador"
                    class="w-full border p-2 rounded
                           @error('id_indicador') border-red-500 @enderror"
                    required>
                    <option value="">Seleccione Indicador</option>

                    <!-- Listado dinámico -->
                    <template x-for="i in indicadores" :key="i.id">
                        <option
                            :value="i.id"
                            :selected="String(i.id) === String(id_indicador)"
                            x-text="i.indicador">
                        </option>
                    </template>
                </select>

                @error('id_indicador')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ===================================================== -->
            <!-- COMPONENTE                                             -->
            <!-- ===================================================== -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Componente <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="componente"
                    value="{{ old('componente', $componente->componente) }}"
                    class="w-full border p-2 rounded
                           @error('componente') border-red-500 @enderror"
                    required>

                @error('componente')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- ===================================================== -->
            <!-- CHECKBOX SUBCOMPONENTES                                -->
            <!-- ===================================================== -->
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    name="tiene_subcomponentes"
                    value="1"
                    x-model="tieneSub">
                <span class="text-sm">
                    ¿Tiene subcomponentes?
                </span>
            </div>

            <!-- ===================================================== -->
            <!-- SUBCOMPONENTES DINÁMICOS                                -->
            <!-- ===================================================== -->
            <div x-show="tieneSub" x-transition>
                <label class="block text-sm font-medium mb-2">
                    Subcomponentes
                </label>

                <!-- Lista -->
                <template x-for="(sub, index) in subcomponentes" :key="index">
                    <div class="flex gap-2 mb-2">
                        <input
                            type="text"
                            name="subcomponentes[]"
                            x-model="subcomponentes[index]"
                            class="w-full border p-2 rounded">

                        <!-- Eliminar -->
                        <button
                            type="button"
                            class="text-red-600"
                            @click="subcomponentes.splice(index, 1)">
                            ✕
                        </button>
                    </div>
                </template>

                <!-- Agregar -->
                <button
                    type="button"
                    class="text-blue-600 text-sm mt-1"
                    @click="subcomponentes.push('')">
                    + Agregar subcomponente
                </button>
            </div>

            <!-- ===================================================== -->
            <!-- BOTONES                                                -->
            <!-- ===================================================== -->
            <div class="flex justify-end gap-2 pt-4">
                <a
                    href="{{ route('componentes.index') }}"
                    class="border px-4 py-2 rounded">
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded">
                    Actualizar
                </button>
            </div>

        </form>
    </div>
</x-app-layout>