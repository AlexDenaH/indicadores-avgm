<x-app-layout>

    <!--
    =====================================================
    CONTENEDOR PRINCIPAL
    x-data maneja todo el estado del formulario:
    - ejercicio, programa, indicador: IDs actuales
    - programas / indicadores: combos dependientes
    - tieneSub / subcomponentes: lógica existente
    =====================================================
    -->
    <div
        class="max-w-4xl mx-auto p-6"
        x-data="{
            /* =============================
               IDs ACTUALES (old o BD)
            ============================== */
            ejercicio: '{{ old('id_ejercicio', $componente->programa->id_ejercicio) }}',
            programa: '{{ old('id_programa',  $componente->programa->id_programa) }}',
            indicador: '{{ old('id_indicador', $componente->indicadores->id_indicador) }}',

            /* =============================
               LISTAS DINÁMICAS
            ============================== */
            programas: [],
            indicadores: [],

            /* =============================
               SUBCOMPONENTES
            ============================== */
            tieneSub: {{ old(
                'tiene_subcomponentes',
                $componente->tiene_subcomponentes
            ) ? 'true' : 'false' }},

            subcomponentes: @js(
                old('subcomponentes', $componente->subcomponentes ?? [''])
            ),

            /* =============================
               MÉTODOS
            ============================== */
            cargarProgramas() {
                if (!this.ejercicio) {
                    this.programas = [];
                    this.programa = '';
                    return;
                }

                fetch(`/api/programas/${this.ejercicio}`)
                    .then(r => r.json())
                    .then(data => {
                        this.programas = data;
                        this.programa = '{{ old('id_programa', $componente->id_programa) }}';
                        this.cargarIndicadores();
                    });
            },

            cargarIndicadores() {
                if (!this.programa) {
                    this.indicadores = [];
                    this.indicador = '';
                    return;
                }

                fetch(`/api/indicadores/${this.programa}`)
                    .then(r => r.json())
                    .then(data => {
                        this.indicadores = data;
                        this.indicador = '{{ old('id_indicador', $componente->id_indicador) }}';
                    });
            }
        }"
        x-init="cargarProgramas()">

        <!-- =============================
             TÍTULO
        ============================== -->
        <h1 class="text-xl font-bold mb-6">
            Editar Componente
        </h1>

        <!-- =============================
             ERRORES
        ============================== -->
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded">
            <ul class="list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- =============================
             FORMULARIO
        ============================== -->
        <form
            method="POST"
            action="{{ route('componentes.update', $componente->id) }}"
            class="space-y-5">
            @csrf
            @method('PUT')

            <!-- ================================================= -->
            <!-- EJERCICIO                                        -->
            <!-- ================================================= -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Ejercicio <span class="text-red-500">*</span>
                </label>

                <select
                    name="id_ejercicio"
                    x-model="ejercicio"
                    @change="cargarProgramas()"
                    class="w-full border p-2 rounded
                           @error('id_ejercicio') border-red-500 @enderror"
                    required>
                    <option value="">Seleccione ejercicio</option>
                    @foreach($ejercicios as $e)
                    <option value="{{ $e->id }}">
                        {{ $e->ejercicio }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- ================================================= -->
            <!-- PROGRAMA                                         -->
            <!-- ================================================= -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Programa <span class="text-red-500">*</span>
                </label>

                <select
                    name="id_programa"
                    x-model="programa"
                    @change="cargarIndicadores()"
                    class="w-full border p-2 rounded
                           @error('id_programa') border-red-500 @enderror"
                    required>
                    <option value="">Seleccione programa</option>
                    <template x-for="p in programas" :key="p.id">
                        <option :value="p.id" x-text="p.programa"></option>
                    </template>
                </select>
            </div>

            <!-- ================================================= -->
            <!-- INDICADOR                                        -->
            <!-- ================================================= -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Indicador <span class="text-red-500">*</span>
                </label>

                <select
                    name="id_indicador"
                    x-model="indicador"
                    class="w-full border p-2 rounded
                           @error('id_indicador') border-red-500 @enderror"
                    required>
                    <option value="">Seleccione indicador</option>
                    <template x-for="i in indicadores" :key="i.id">
                        <option :value="i.id" x-text="i.indicador"></option>
                    </template>
                </select>
            </div>

            <!-- ================================================= -->
            <!-- COMPONENTE                                       -->
            <!-- ================================================= -->
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
            </div>

            <!-- ================================================= -->
            <!-- SUBCOMPONENTES                                   -->
            <!-- ================================================= -->
            <div class="flex items-center gap-2">
                <input
                    type="checkbox"
                    name="tiene_subcomponentes"
                    value="1"
                    x-model="tieneSub">
                <span class="text-sm">¿Tiene subcomponentes?</span>
            </div>

            <div x-show="tieneSub" x-transition>
                <label class="block text-sm font-medium mb-2">
                    Subcomponentes
                </label>

                <template x-for="(sub, index) in subcomponentes" :key="index">
                    <div class="flex gap-2 mb-2">
                        <input
                            type="text"
                            name="subcomponentes[]"
                            x-model="subcomponentes[index]"
                            class="w-full border p-2 rounded">

                        <button
                            type="button"
                            class="text-red-600"
                            @click="subcomponentes.splice(index, 1)">
                            ✕
                        </button>
                    </div>
                </template>

                <button
                    type="button"
                    class="text-blue-600 text-sm"
                    @click="subcomponentes.push('')">
                    + Agregar subcomponente
                </button>
            </div>

            <!-- ================================================= -->
            <!-- BOTONES                                          -->
            <!-- ================================================= -->
            <div class="flex justify-end gap-2 pt-4">
                <a
                    href="{{ route('componentes.index') }}"
                    class="bg-red-600 text-white border px-4 py-2 rounded">
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