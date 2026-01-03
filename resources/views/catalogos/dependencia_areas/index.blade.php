<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Áreas por Dependencia</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <a href="{{ route('dependencia_areas.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Nueva Área
        </a>

        <div class="grid mt-4 bg-white shadow rounded overflow-x-auto justify-items-[anchor-center]">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Dependencia</th>
                        <th class="px-4 py-2">Área</th>
                        <th class="px-4 py-2">Activa</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($areas as $area)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $area->dependencia->nombre }}</td>
                            <td class="px-4 py-2">{{ $area->unidad_area }}</td>
                            <td class="px-4 py-2 text-center">{{ $area->activa ? 'Sí' : 'No' }}</td>
                            <td class="px-4 py-2 flex justify-center gap-3">
                                <a href="{{ route('dependencia_areas.edit',$area) }}"
                                   class="text-yellow-500">✏️</a>
                                <form method="POST"
                                      action="{{ route('dependencia_areas.destroy',$area) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500"
                                            onclick="return confirm('¿Eliminar área?')">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
