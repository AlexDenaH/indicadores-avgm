<x-app-layout>
<div class="max-w-7xl mx-auto p-6">

<h1 class="text-xl font-bold mb-4">Concentrado de Indicadores</h1>

<div class="bg-white shadow rounded p-4 mb-4">
    <form method="GET" class="grid grid-cols-6 gap-4">
        <input name="ejercicio" placeholder="Ejercicio" class="border p-2">
        <input name="programa" placeholder="Programa" class="border p-2">
        <input name="indicador" placeholder="Indicador" class="border p-2">
        <button class="bg-blue-600 text-white rounded px-4">Filtrar</button>

        <a href="{{ route('concentrados.create') }}"
           class="bg-green-600 text-white rounded px-4 text-center">
            Nuevo
        </a>
    </form>
</div>

@include('concentrados.partials.tabla')

</div>
</x-app-layout>
