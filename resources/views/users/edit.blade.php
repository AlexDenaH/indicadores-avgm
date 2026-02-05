<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-6">✏️ Editar Usuario</h2>

            <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- DATOS PERSONALES -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Nombre</label>
                        <input name="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Apellido Paterno</label>
                        <input name="first_last_name"
                               value="{{ old('first_last_name', $user->first_last_name) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Apellido Materno</label>
                        <input name="second_last_name"
                               value="{{ old('second_last_name', $user->second_last_name) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <!-- EMAIL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Correo electrónico</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>
                </div>

                <!-- DEPENDENCIA Y ÁREA -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- DEPENDENCIA -->
                    <div>
                        <label class="block text-sm font-medium">Dependencia</label>
                        <select name="id_dependencia"
                                id="id_dependencia"
                                class="w-full border rounded px-3 py-2"
                                required>
                            <option value="">Seleccione dependencia</option>
                            @foreach($dependencias as $dep)
                                <option value="{{ $dep->id }}"
                                    @selected(old('id_dependencia', $user->id_dependencia) == $dep->id)>
                                    {{ $dep->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- ÁREA -->
                    <div>
                        <label class="block text-sm font-medium">Área</label>
                        <select name="id_dep_area"
                                id="id_dep_area"
                                class="w-full border rounded px-3 py-2"
                                required>
                            <option value="">Seleccione área</option>
                        </select>
                    </div>
                </div>

                <!-- ROL -->
                @role(['super-admin','admin'])
                <div>
                    <label class="block text-sm font-medium">Rol</label>
                    <select name="role" class="w-full border rounded px-3 py-2">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                @selected($user->hasRole($role->name))>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <!-- BOTONES -->
                <div class="flex justify-end gap-3 pt-4" x-data="{}">
                    <button type="button"
                            x-on:click="window.location.href = '{{ route('users.index') }}'"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md shadow-sm transition">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-green-700 text-white font-semibold rounded-md shadow-sm transition">
                        Actualizar
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- VALOR SELECCIONADO PARA CARGA DE ÁREAS -->
    <script>
        window.selectedDepAreaId = "{{ old('id_dep_area', $user->id_dep_area) }}";
    </script>

</x-app-layout>
