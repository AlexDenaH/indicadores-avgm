<div
    x-data="detalleManager({
        niveles: @js($nivelesDetalle),
        old: @js(old('id_detalle', []))
    })"
    class="border rounded p-4">

    <label class="block text-sm font-medium mb-2">
        Nivel y orden de detalle
    </label>

    <!-- SELECT -->
    <div class="flex gap-2 mb-3">
        <select x-model="seleccionado" class="flex-1 border rounded p-2">
            <option value="">Seleccione nivel</option>

            <template x-for="n in disponibles" :key="n.id">
                <option :value="n.id" x-text="n.tipo"></option>
            </template>
        </select>

        <button type="button"
                @click="agregar()"
                class="bg-blue-600 text-white px-4 rounded">
            Agregar
        </button>
    </div>

    <!-- LISTA ORDENADA -->
    <template x-if="items.length">
        <ul class="space-y-2">
            <template x-for="(item, index) in items" :key="item.id">
                <li class="flex justify-between items-center bg-gray-100 p-2 rounded">

                    <span x-text="`${index + 1}. ${item.tipo}`"></span>

                    <div class="flex gap-2">
                        <button type="button" @click="subir(index)">↑</button>
                        <button type="button" @click="bajar(index)">↓</button>
                        <button type="button" @click="eliminar(index)"
                                class="text-red-600">✕</button>
                    </div>

                    <!-- INPUT OCULTO -->
                    <input
                        type="hidden"
                        :name="`id_detalle[${index}][id]`"
                        :value="item.id">
                </li>
            </template>
        </ul>
    </template>
</div>
