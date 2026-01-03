<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">

            {{-- Título del dashboard --}}
            <h2 class="font-semibold text-xl text-gray-800">
                Sistema de Indicadores
            </h2>
    </x-slot>

    {{-- CONTENIDO NORMAL DEL DASHBOARD --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Aquí va el contenido normal --}}
        </div>
    </div>
</x-app-layout>
