<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">

        <h1 class="text-xl font-bold mb-4">Editar Indicador</h1>

        @if ($errors->any())
        <div class="mb-4 bg-red-50 p-4 rounded">
            <ul class="list-disc list-inside text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('indicadores.update', $indicador) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- PROGRAMA --}}
            <select name="id_programa" class="w-full border p-2 rounded" required>
                @foreach ($programas as $p)
                <option value="{{ $p->id }}" {{ old('id_programa', $indicador->id_programa) == $p->id ? 'selected' : '' }}>
                    {{ $p->programa }}
                </option>
                @endforeach
            </select>

            {{-- INDICADOR --}}
            <input type="text" name="indicador" value="{{ old('indicador', $indicador->indicador) }}" class="w-full border p-2 rounded" required>

            {{-- DESCRIPCIÓN --}}
            <textarea name="descripcion" class="w-full border p-2 rounded">{{ old('descripcion', $indicador->descripcion) }}</textarea>

            {{-- MEDICIÓN --}}
            <input type="text" name="medicion" value="{{ old('medicion', $indicador->medicion) }}" class="w-full border p-2 rounded" required>

            {{-- NIVEL DETALLE --}}
            <div x-data="detalleManager({ niveles: @js($nivelesDetalle), old: @js(old('id_detalle', $indicador->id_detalle ?? [])) })" class="border p-4 rounded">
                <label class="font-medium mb-2 block">Nivel de detalle</label>

                <div class="flex gap-2 mb-2">
                    <select x-model="seleccionado" class="flex-1 border p-2 rounded">
                        <option value="">Seleccione nivel</option>
                        <template x-for="n in disponibles" :key="n.id">
                            <option :value="n.id" x-text="n.tipo"></option>
                        </template>
                    </select>

                    <button type="button" @click="agregar" class="bg-blue-600 text-white px-4 rounded">Agregar</button>
                </div>

                <template x-for="(item, index) in items" :key="`${item.id}-${index}`">
                    <div class="flex justify-between items-center bg-gray-50 p-2 rounded mb-1">
                        <span>
                            <strong x-text="item.orden"></strong>.
                            <span x-text="niveles.find(n => n.id == item.id)?.tipo"></span>
                        </span>

                        <div class="flex gap-1">
                            <button type="button" @click="subir(index)">⬆</button>
                            <button type="button" @click="bajar(index)">⬇</button>
                            <button type="button" @click="eliminar(index)">❌</button>
                        </div>

                        <input type="hidden" :name="`id_detalle[${index}][id]`" :value="item.id">
                        <input type="hidden" :name="`id_detalle[${index}][orden]`" :value="item.orden">
                    </div>
                </template>

            </div>

            {{-- ACTIVO --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="activo" value="1" {{ $indicador->activo ? 'checked' : '' }}>
                <span>Indicador activo</span>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-2">
                <a href="{{ route('indicadores.index') }}" class="bg-red-600 text-white px-4 py-2 rounded">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Actualizar</button>
            </div>

        </form>
    </div>
</x-app-layout>