<x-app-layout>

<div class="max-w-7xl mx-auto py-6">

    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Usuarios</h2>

        @role('super-admin|administrador')
            <a href="{{ route('users.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                ➕ Crear usuario
            </a>
        @endrole
    </div>

    <!-- Tabla -->
    <div class="grid bg-white shadow rounded justify-items-[anchor-center]">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nombre</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Dependencia</th>
                    <th class="px-4 py-2">Área</th>
                    <th class="px-4 py-2">Rol</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
            @foreach($users as $user)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        {{ $user->nombre_completo }}
                    </td>

                    <td class="px-4 py-2 text-center">
                        {{ $user->email }}
                    </td>

                    <td class="px-4 py-2 text-center">
                        {{ $user->dependencia->nombre ?? '-' }}
                    </td>

                    <td class="px-4 py-2 text-center">
                        {{ $user->area->unidad_area ?? '-' }}
                    </td>

                    <td class="px-4 py-2 text-center">
                        {{ $user->roles->pluck('name')->first() }}
                    </td>

                    <!-- ACCIONES -->
                    <td class="px-4 py-2 text-center flex justify-center gap-3">

                        {{-- EDITAR --}}
                        @role('super-admin|administrador')
                            <a href="{{ route('users.edit',$user) }}"
                               class="text-blue-600 hover:text-blue-800"
                               title="Editar">
                                ✏️
                            </a>
                        @endrole

                        {{-- ELIMINAR --}}
                        @role('super-admin')
                            <form method="POST"
                                  action="{{ route('users.destroy',$user) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800"
                                        onclick="return confirm('¿Eliminar usuario?')">
                                    🗑️
                                </button>
                            </form>
                        @endrole

                        {{-- PERMISOS --}}
                        @role('super-admin')
                            <a href="{{ route('users.permissions',$user) }}"
                               class="text-purple-600 hover:text-purple-800"
                               title="Permisos">
                                🔐
                            </a>
                        @endrole

                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</div>
</x-app-layout>
