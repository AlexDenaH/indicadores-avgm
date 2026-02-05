<x-app-layout>
    <div x-data="formAsignacion()" class="max-w-5xl mx-auto p-6 bg-white rounded shadow">

        <h1 class="text-xl font-bold mb-4">Nueva asignación</h1>

        <form method="POST" action="{{ route('asignaciones.store') }}">
            @csrf

            <!-- Ejercicio -->
            <select x-model="ejercicio" @change="cargarProgramas"
                name="id_ejercicio" class="w-full mb-3">
                <option value="">Seleccione ejercicio</option>
                @foreach($ejercicios as $e)
                <option value="{{ $e->id }}">{{ $e->ejercicio }}</option>
                @endforeach
            </select>

            <!-- Programa -->
            <select x-model="programa" @change="cargarIndicadores"
                name="id_programa" class="w-full mb-3">
                <option value="">Seleccione programa</option>
                <template x-for="p in programas" :key="p.id">
                    <option :value="p.id" x-text="p.programa"></option>
                </template>
            </select>

            <!-- Área -->
            <select name="id_area" class="w-full mb-3">
                <option value="">Seleccione área</option>
                @foreach($areas as $a)
                <option value="{{ $a->id }}">{{ $a->unidad_area }}</option>
                @endforeach
            </select>

            <!-- Indicadores -->
            <div class="border rounded p-3 max-h-60 overflow-y-auto">
                <template x-for="i in indicadores" :key="i.id">
                    <label class="block">
                        <input type="checkbox"
                            name="indicadores[]"
                            :value="i.id">
                        <span x-text="i.indicador"></span>
                    </label>
                </template>
            </div>
            <!-- BOTONES -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('asignaciones.index') }}"
                    class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md">
                    Cancela
                </a>

                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">
                    Guardar
                </button>
            </div>

        </form>
    </div>

    <script>
        function formAsignacion() {
            return {
                ejercicio: '',
                programa: '',
                programas: [],
                indicadores: [],

                cargarProgramas() {
                    this.programas = [];
                    this.indicadores = [];
                    fetch(`/api/programas/${this.ejercicio}`)
                        .then(r => r.json())
                        .then(data => this.programas = data);
                },

                cargarIndicadores() {
                    this.indicadores = [];
                    fetch(`/api/indicadores/${this.programa}`)
                        .then(r => r.json())
                        .then(data => this.indicadores = data);
                }
            }
        }
    </script>
</x-app-layout>