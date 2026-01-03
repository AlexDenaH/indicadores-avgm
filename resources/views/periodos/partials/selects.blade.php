{{-- ============================= --}}
{{-- SELECTORES REUTILIZABLES --}}
{{-- Periodos: Ejercicio / Programa / Indicador --}}
{{-- ============================= --}}

{{-- EJERCICIO --}}
<div>
    <label class="block text-sm font-medium mb-1">
        Ejercicio <span class="text-red-500">*</span>
    </label>

    <select
        name="id_ejercicio"
        x-model="id_ejercicio"
        class="w-full border p-2 rounded
               @error('id_ejercicio') border-red-500 @enderror"
        required>
        <option value="">Seleccione ejercicio</option>

        <template x-for="e in ejercicios" :key="e.id">
            <option :value="e.id" x-text="e.ejercicio"></option>
        </template>
    </select>

    @error('id_ejercicio')
    <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- PROGRAMA --}}
<div>
    <label class="block text-sm font-medium mb-1">
        Programa <span class="text-red-500">*</span>
    </label>

    <select
        name="id_programa"
        x-model="id_programa"
        class="w-full border p-2 rounded
               @error('id_programa') border-red-500 @enderror"
        required>
        <option value="">Seleccione programa</option>

        <template x-for="p in programas" :key="p.id">
            <option :value="p.id" x-text="p.programa"></option>
        </template>
    </select>

    @error('id_programa')
    <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- INDICADOR --}}
<div>
    <label class="block text-sm font-medium mb-1">
        Indicador <span class="text-red-500">*</span>
    </label>

    <select
        name="id_indicador"
        x-model="id_indicador"
        class="w-full border p-2 rounded
               @error('id_indicador') border-red-500 @enderror"
        required>
        <option value="">Seleccione indicador</option>

        <template x-for="i in indicadores" :key="i.id">
            <option :value="i.id" x-text="i.indicador"></option>
        </template>
    </select>

    @error('id_indicador')
    <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- TIPO DE PERIODO --}}
<div>
    <label class="block text-sm font-medium mb-1">
        Periodo <span class="text-red-500">*</span>
    </label>

    <select
        name="periodo"
        x-model="periodo"
        class="w-full border p-2 rounded
               @error('periodo') border-red-500 @enderror"
        required>
        <option value="">Seleccione periodo</option>
        <option value="diario">Diario</option>
        <option value="semanal">Semanal</option>
        <option value="mensual">Mensual</option>
        <option value="trimestral">Trimestral</option>
        <option value="semestral">Semestral</option>
        <option value="anual">Anual</option>
    </select>

    @error('periodo')
    <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

{{-- DÍAS --}}
<div class="grid grid-cols-2 gap-4">
    {{-- DÍA INICIO --}}
    <div>
        <label class="block text-sm font-medium mb-1">
            Día inicio
        </label>

        <input
            type="number"
            name="dias_inicio"
            x-model="dias_inicio"
            :disabled="periodo === 'diario'"
            class="w-full border p-2 rounded">
    </div>

    {{-- DÍA FINAL --}}
    <div>
        <label class="block text-sm font-medium mb-1">
            Día final
        </label>

        <input
            type="number"
            name="dias_final"
            x-model="dias_final"
            :disabled="periodo === 'diario'"
            class="w-full border p-2 rounded">
    </div>
</div>

{{-- STATUS --}}
<div>
    <label class="block text-sm font-medium mb-1">
        Estado
    </label>

    <select
        name="status"
        x-model="status"
        class="w-full border p-2 rounded">
        <option value="abierto">Abierto</option>
        <option value="cerrado">Cerrado</option>
    </select>
</div>