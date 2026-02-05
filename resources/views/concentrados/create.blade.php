<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-xl font-bold mb-6">
            Captura de Concentrado de Indicadores
        </h1>

        {{-- =========================
             FORMULARIO
        ========================= --}}
        <form
            x-data="concentradoCreate()"
            x-init="init()"
            method="POST"
            action="{{ route('concentrados.store') }}"
            class="space-y-6">
            @csrf

            {{-- =========================
                 SELECTORES PRINCIPALES
            ========================= --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- EJERCICIO --}}
                <div>
                    <label class="font-semibold">Ejercicio</label>
                    <select
                        x-model="form.id_ejercicio"
                        @change="getProgramas()"
                        class="w-full border rounded px-3 py-2">
                        <option value="">Seleccione</option>
                        <template x-for="e in ejercicios" :key="e.id">
                            <option :value="e.id" x-text="e.ejercicio"></option>
                        </template>
                    </select>
                </div>

                {{-- PROGRAMA --}}
                <div>
                    <label class="font-semibold">Programa</label>
                    <select
                        x-model="form.id_programa"
                        @change="getIndicadores()"
                        class="w-full border rounded px-3 py-2">
                        <option value="">Seleccione</option>
                        <template x-for="p in programas" :key="p.id">
                            <option :value="p.id" x-text="p.programa"></option>
                        </template>
                    </select>
                </div>

                {{-- INDICADOR --}}
                <div>
                    <label class="font-semibold">Indicador</label>
                    <select x-model="form.id_indicador" @change="getComponentes()" class="w-full border rounded px-2 py-1">
                        <option value="">Seleccione un indicador</option>

                        <template x-for="ind in indicadores" :key="ind.id">
                            <option :value="ind.id" x-text="ind.indicador"></option>
                        </template>
                    </select>
                </div>
            </div>

            {{-- =========================
                 TABLA DE CAPTURA
            ========================= --}}
            <div class="border rounded-lg mt-6">

                <table class="w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">Nivel detalle</th>
                            <th class="border p-2">Componente / Subcomponente</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template x-for="fila in filas" :key="fila.key">
                            <tr>
                                <td class="border p-2">
                                    <span x-text="fila.nivel.descripcion"></span>
                                </td>

                                <td class="border p-2">
                                    <span x-text="fila.nombre"></span>
                                </td>

                                <td class="border p-2">
                                    <input
                                        type="number"
                                        min="0"
                                        class="w-full border rounded px-2 py-1"
                                        x-model="fila.total">
                                </td>

                                <td class="border p-2 text-center">
                                    <button
                                        type="button"
                                        class="text-red-600"
                                        @click="eliminarFila(fila.key)">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filas.length === 0">
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                Seleccione indicador para generar filas
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- =========================
                 CAMPOS OCULTOS
            ========================= --}}
            <template x-for="(fila, index) in filas" :key="fila.key">
                <div>
                    <input type="hidden" :name="`filas[${index}][id_nivel_detalle]`" :value="fila.nivel.id">
                    <input type="hidden" :name="`filas[${index}][id_componente]`" :value="fila.id_componente">
                    <input type="hidden" :name="`filas[${index}][subcomponente]`" :value="fila.subcomponente">
                    <input type="hidden" :name="`filas[${index}][total]`" :value="fila.total">
                </div>
            </template>

            {{-- =========================
                 BOTÓN GUARDAR
            ========================= --}}
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded"
                    :disabled="filas.length === 0">
                    Guardar captura
                </button>
            </div>

        </form>
    </div>

    {{-- =========================
         ALPINE SCRIPT
    ========================= --}}
    <script>
        function concentradoCreate() {
            return {

                ejercicios: [],
                programas: [],
                indicadores: [],
                componentes: [],
                niveles: [],
                filas: [],

                form: {
                    id_ejercicio: '',
                    id_programa: '',
                    id_indicador: '',
                },

                /**
                 * ============================
                 * INIT
                 * ============================
                 */
                async init() {
                    await this.getEjercicios()
                },

                /**
                 * ============================
                 * FETCH JSON BASE
                 * ============================
                 */
                async fetchJson(url) {
                    const r = await fetch(url, {
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })

                    if (!r.ok) {
                        throw new Error(`Error ${r.status} en ${url}`)
                    }

                    return await r.json()
                },

                /**
                 * ============================
                 * COMBOS
                 * ============================
                 */
                async getEjercicios() {
                    this.ejercicios = await this.fetchJson('/api/ejercicios')
                },

                async getProgramas() {
                    this.programas = await this.fetchJson(
                        `/api/programas/${this.form.id_ejercicio}`
                    )
                },

                async getIndicadores() {
                    if (!this.form.id_ejercicio || !this.form.id_programa) {
                        this.indicadores = []
                        return
                    }

                    const params = new URLSearchParams({
                        ejercicio: this.form.id_ejercicio,
                        programa: this.form.id_programa,
                    })

                    this.indicadores = await this.fetchJson(
                        `/api/indicadores?${params.toString()}`
                    )
                },

                async getComponentes() {
                    this.componentes = await this.fetchJson(
                        `/api/componentes/${this.form.id_indicador}`
                    )

                    this.generarFilas()
                },

                async getNivelesDetalle() {
                    this.niveles = await this.fetchJson(`/api/niveles-detalle/${this.form.id_indicador}`)
                },

                /**
                 * ============================
                 * GENERACIÓN DE FILAS
                 * ============================
                 */
                generarFilas() {
                    this.filas = []

                    this.niveles.forEach(nivel => {
                        this.componentes.forEach(comp => {

                            if (comp.tiene_subcomponentes) {
                                comp.subcomponentes.forEach(sub => {
                                    this.filas.push({
                                        key: `${nivel.id}-${comp.id}-${sub}`,
                                        nivel,
                                        id_componente: comp.id,
                                        subcomponente: sub,
                                        nombre: `${comp.componente} / ${sub}`,
                                        total: 0,
                                    })
                                })
                            } else {
                                this.filas.push({
                                    key: `${nivel.id}-${comp.id}`,
                                    nivel,
                                    id_componente: comp.id,
                                    subcomponente: '',
                                    nombre: comp.componente,
                                    total: 0,
                                })
                            }

                        })
                    })
                },

                /**
                 * ============================
                 * ELIMINAR FILA
                 * ============================
                 */
                eliminarFila(key) {
                    this.filas = this.filas.filter(f => f.key !== key)
                }
            }
        }
    </script>


</x-app-layout>