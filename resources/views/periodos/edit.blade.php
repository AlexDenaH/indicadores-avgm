<x-app-layout>
    <div
        class="max-w-5xl mx-auto p-6"
        x-data="{
            ejercicios: @js($ejercicios),
            programas: @js($programas),
            indicadores: @js($indicadores),

            id_ejercicio: '{{ $periodo->id_ejercicio }}',
            id_programa: '{{ $periodo->id_programa }}',
            id_indicador: '{{ $periodo->id_indicador }}',

            periodo: '{{ $periodo->periodo }}',
            dias_inicio: '{{ $periodo->dias_inicio }}',
            dias_final: '{{ $periodo->dias_final }}',
            status: '{{ $periodo->status }}',
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

        <h1 class="text-xl font-bold mb-6">✏️ Editar Periodo</h1>

        <form method="POST" action="{{ route('periodos.update', $periodo) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- SUPERIOR --}}
            <div class="grid grid-cols-2 gap-4">
                <select x-model="id_ejercicio" class="border p-2 rounded" disabled>
                    <template x-for="e in ejercicios">
                        <option :value="e.id" x-text="e.ejercicio"></option>
                    </template>
                </select>

                <input type="hidden" name="id_ejercicio" :value="id_ejercicio">

                <select x-model="id_programa" name="id_programa" class="border p-2 rounded" disabled>
                    <template x-for="p in programas">
                        <option :value="p.id" x-text="p.programa"></option>
                    </template>
                </select>
            </div>

            <input type="hidden" name="id_programa" :value="id_programa">

            {{-- INFERIOR --}}
            <div class="grid grid-cols-2 gap-4">
                <select x-model="id_indicador" name="id_indicador" class="border p-2 rounded">
                    <template x-for="i in indicadores">
                        <option :value="i.id" 
                                x-text="i.indicador"
                                :selected="i.id == id_indicador"></option>
                    </template>
                </select>
                


                <select x-model="periodo" name="periodo" @change="reglas()" class="border p-2 rounded">
                    <option value="diario">Diario</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                    <option value="trimestral">Trimestral</option>
                    <option value="semestral">Semestral</option>
                    <option value="anual">Anual</option>
                </select>

                <input type="number" name="dias_inicio" x-model="dias_inicio" class="border p-2 rounded">
                @error('dias_inicio')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <input type="number" name="dias_final" x-model="dias_final" @change="reglas()" class="border p-2 rounded">

                <select name="status" x-model="status" class="border p-2 rounded">
                    <option value="1">Abierto</option>
                    <option value="0">Cerrado</option>
                </select>
            </div>

            <template x-if="mensajeError">
                <div class="text-red-600 text-sm font-bold mt-1" x-text="mensajeError"></div>
            </template>
            <div class="flex justify-end gap-2">
                <a href="{{ route('periodos.index') }}" class="border px-4 py-2 rounded">
                    Cancelar
                </a>
                <button :disabled="mensajeError !== ''"
                    :class="mensajeError !== '' ? 'bg-gray-400' : 'bg-blue-600'"
                    class="px-4 py-2 text-white rounded">
                    Actualizar
                </button>
            </div>

        </form>
    </div>
</x-app-layout>