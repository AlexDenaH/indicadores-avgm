<x-app-layout>
    <div
        class="max-w-5xl mx-auto p-6"
        x-data="{
            // ===== DATA =====
            ejercicios: @js($ejercicios), // SOLO activos (desde controller)
            programas: [],
            indicadores: [],

            // ===== MODELOS =====
            id_ejercicio: '',
            id_programa: '',
            id_indicador: '',

            periodo: '',
            dias_inicio: 0,
            dias_final: 0,
            status: 'cerrado',

            // ===== REGLAS POR PERIODO =====
                reglas() {
                    this.mensajeError = ''; // Limpiar errores previos

                    if (this.periodo === 'diario') {
                        this.dias_inicio = 1;
                        this.dias_final = 0;
                        this.status = 'abierto';
                    }

                    // Validación Semanal
                    if (this.periodo === 'semanal' && this.dias_final > 5) {
                        this.mensajeError = 'Para periodos semanales, el día final no puede ser mayor a 5 días.';
                    }

                    // Validación Mensual, Trimestral, Semestral y Anual
                    const periodosLargos = ['mensual', 'trimestral', 'semestral', 'anual'];
                    if (periodosLargos.includes(this.periodo) && this.dias_final > 30) {
                        this.mensajeError = 'Para este periodo, el día final no puede ser mayor a 30 días.';
                    }
                }
        }">

        <h1 class="text-xl font-bold mb-6">➕ Crear Periodo</h1>

        {{-- ERRORES --}}
        @if ($errors->any())
        <div class="mb-4 bg-red-50 p-4 rounded">
            <ul class="list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('periodos.store') }}" class="space-y-6">
            @csrf

            {{-- ================= SUPERIOR ================= --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- EJERCICIO --}}
                <div>
                    <label class="block text-sm font-medium">Ejercicio *</label>
                    <select
                        x-model="id_ejercicio"
                        name="id_ejercicio"
                        @change="
                            fetch(`/api/programas/${id_ejercicio}`)
                                .then(r => r.json())
                                .then(d => {
                                    programas = d
                                    indicadores = []
                                    id_programa = ''
                                    id_indicador = ''
                                })
                        "
                        class="w-full border p-2 rounded"
                        required>
                        <option value="">Seleccione ejercicio</option>
                        <template x-for="e in ejercicios" :key="e.id">
                            <option :value="e.id" x-text="e.ejercicio"></option>
                        </template>
                    </select>
                </div>

                {{-- PROGRAMA --}}
                <div>
                    <label class="block text-sm font-medium">Programa *</label>
                    <select
                        x-model="id_programa"
                        name="id_programa"
                        @change="
                            fetch(`/api/indPeriodos/${id_ejercicio}/${id_programa}`)
                                .then(r => r.json())
                                .then(d => {
                                    indicadores = d
                                    id_indicador = ''
                                })
                        "
                        class="w-full border p-2 rounded"
                        required>
                        <option value="">Seleccione programa</option>
                        <template x-for="p in programas" :key="p.id">
                            <option :value="p.id" x-text="p.programa"></option>
                        </template>
                    </select>
                </div>
            </div>

            {{-- ================= INFERIOR ================= --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- INDICADOR --}}
                <div>
                    <label class="block text-sm font-medium">Indicador *</label>
                    <select
                        x-model="id_indicador"
                        name="id_indicador"
                        class="w-full border p-2 rounded"
                        required>
                        <option value="">Seleccione indicador</option>
                        <template x-for="i in indicadores" :key="i.id">
                            <option :value="i.id" x-text="i.indicador"></option>
                        </template>
                    </select>
                </div>

                {{-- PERIODO --}}
                <div>
                    <label class="block text-sm font-medium">Periodo *</label>
                    <select
                        x-model="periodo"
                        name="periodo"
                        @change="reglas()"
                        class="w-full border p-2 rounded"
                        required>
                        <option value="">Seleccione</option>
                        <option value="diario">Diario</option>
                        <option value="semanal">Semanal</option>
                        <option value="mensual">Mensual</option>
                        <option value="trimestral">Trimestral</option>
                        <option value="semestral">Semestral</option>
                        <option value="anual">Anual</option>
                    </select>
                </div>

                {{-- DIAS --}}
                <div>
                    <label class="block text-sm font-medium">Día inicio</label>
                    <input
                        type="number"
                        name="dias_inicio"
                        x-model="dias_inicio"
                        :disabled="periodo === 'diario'"
                        class="w-full border p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium">Día final</label>
                    <input
                        type="number"
                        name="dias_final"
                        x-model="dias_final"
                         @change="reglas()"
                        :disabled="periodo === 'diario'"
                        class="w-full border p-2 rounded">
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-sm font-medium">Estado</label>
                    <select
                        name="status"
                        x-model="status"
                        class="w-full border p-2 rounded">
                        <option value="1">Abierto</option>
                        <option value="0">Cerrado</option>
                    </select>
                </div>
            </div>


            <template x-if="mensajeError">
                <div class="text-red-600 text-sm font-bold mt-1" x-text="mensajeError"></div>
            </template>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-2">
                <a href="{{ route('periodos.index') }}" class="border px-4 py-2 rounded">
                    Cancelar
                </a>
                <button :disabled="mensajeError !== ''"
                    :class="mensajeError !== '' ? 'bg-gray-400' : 'bg-blue-600'"
                    class="px-4 py-2 text-white rounded">
                    Guardar
                </button>
            </div>

        </form>
    </div>
</x-app-layout>