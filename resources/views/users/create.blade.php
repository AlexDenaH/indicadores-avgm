<x-app-layout>

    <!-- CONTENEDOR PRINCIPAL -->
    <!-- max-w-3xl: ancho máximo
         mx-auto: centrado horizontal
         py / px: espaciados -->
    <div class="max-w-3xl mx-auto py-8 px-4">

        <!-- TARJETA -->
        <!-- shadow + rounded para apariencia tipo card -->
        <div class="bg-white shadow rounded-lg p-6">

            <!-- TÍTULO -->
            <h2 class="text-xl font-bold mb-6">
                ➕ Crear Usuario
            </h2>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong>¡Ups!</strong> Hay errores en el formulario:
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <!-- FORMULARIO -->
            <!-- route(users.store): guarda usuario
                 space-y-6: separación vertical entre secciones -->
            <form method="POST"
                  action="{{ route('users.store') }}"
                  class="space-y-6">

                @csrf <!-- Protección CSRF obligatoria -->

                <!-- ================= DATOS PERSONALES ================= -->
                <!-- grid responsive: 1 columna en móvil, 3 en desktop -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!-- NOMBRE -->
                    <div>
                        <label class="block text-sm font-medium">
                            Nombre <span class="text-red-600">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>

                    <!-- APELLIDO PATERNO -->
                    <div>
                        <label class="block text-sm font-medium">
                            Apellido Paterno <span class="text-red-600">*</span>
                        </label>
                        <input type="text"
                               name="first_last_name"
                               value="{{ old('first_last_name') }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>

                    <!-- APELLIDO MATERNO -->
                    <div>
                        <label class="block text-sm font-medium">
                            Apellido Materno
                        </label>
                        <input type="text"
                               name="second_last_name"
                               value="{{ old('second_last_name') }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                </div>

                <!-- ================= EMAIL Y CONTRASEÑAS ================= -->
                <!-- 2 columnas en desktop -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- CORREO -->
                    <div>
                        <label class="block text-sm font-medium">
                            Correo electrónico <span class="text-red-600">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>
                    <!-- CORREO VERFICACION -->
                    <div>
                        <label class="block text-sm font-medium">
                            Correo electrónico verificación <span class="text-red-600">*</span>
                        </label>
                        <input type="email_verified_at"
                               name="email_verified_at"
                               value="{{ old('email_verified_at') }}"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>

                    <!-- CONTRASEÑA -->
                    <!-- x-data crea un estado local Alpine -->
                    <div x-data="{ show: false }">

                        <label class="block text-sm font-medium">
                            Contraseña <span class="text-red-600">*</span>
                        </label>

                        <!-- relative permite posicionar el botón del ojito -->
                        <div class="relative">

                            <!-- :type cambia entre password y text -->
                            <input
                                :type="show ? 'text' : 'password'"
                                name="password"
                                class="w-full border rounded px-3 py-2 pr-10"
                                required
                            >

                            <!-- BOTÓN OJITO -->
                            <!-- @click cambia el estado -->
                            <button type="button"
                                    @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

                                <!-- Texto dinámico según estado -->
                                <span x-text="show ? '🙈' : '👁️'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- CONFIRMAR CONTRASEÑA -->
                    <div x-data="{ show: false }">

                        <label class="block text-sm font-medium">
                            Confirmar contraseña <span class="text-red-600">*</span>
                        </label>

                        <div class="relative">
                            <input
                                :type="show ? 'text' : 'password'"
                                name="password_confirmation"
                                class="w-full border rounded px-3 py-2 pr-10"
                                required
                            >

                            <button type="button"
                                    @click="show = !show"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700">

                                <span x-text="show ? '🙈' : '👁️'"></span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- ================= DEPENDENCIA Y ÁREA ================= -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- DEPENDENCIA -->
                    <div>
                        <label class="block text-sm font-medium">
                            Dependencia <span class="text-red-600">*</span>
                        </label>

                        <select name="id_dependencia"
                                id="id_dependencia"
                                class="w-full border rounded px-3 py-2"
                                required>

                            <option value="">Seleccione dependencia</option>

                            @foreach($dependencias as $dep)
                                <option value="{{ $dep->id }}" 
                                {{ old('id_dependencia') == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- ÁREA -->
                    <div>
                        <label class="block text-sm font-medium">
                            Área <span class="text-red-600">*</span>
                        </label>

                        <select name="id_dep_area"
                                id="id_dep_area"
                                class="w-full border rounded px-3 py-2"
                                required>
                            <option value="">Seleccione área</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}" 
                                    {{ old('id_dep_area') == $area->id ? 'selected' : '' }}>{{ $area->unidad_area }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- ================= ROL ================= -->
                <div>
                    <label class="block text-sm font-medium">
                        Rol <span class="text-red-600">*</span>
                    </label>

                    <select name="role"
                            class="w-full border rounded px-3 py-2"
                            required>

                        <option value="">Seleccione rol</option>

                        @foreach($roles as $role)
                            @if(
                                auth()->user()->hasRole('super-admin') ||
                                (auth()->user()->hasRole('administrador') &&
                                in_array($role->name, ['enlace-dependencia','capturista']))
                            )
                                <option value="{{ $role->name }}" 
                                    {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}
                                </option>
                            @endif
                        @endforeach

                    </select>
                </div>

                <!-- ================= BOTONES ================= -->
                <div class="flex justify-end gap-3 pt-4">

                    <!-- CANCELAR -->
                    <button type="button"
                            onclick="window.location.href='{{ route('users.index') }}'"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md shadow-sm transition-all">
                        Cancelar
                    </button>

                    <!-- GUARDAR -->
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Guardar
                    </button>

                </div>

                <!-- LEYENDA CAMPOS OBLIGATORIOS -->
                <p class="text-sm text-gray-500">
                    <span class="text-red-600">*</span> Campos obligatorios
                </p>

            </form>
        </div>
    </div>
<script>
    window.selectedDepAreaId = null;
</script>
</x-app-layout>
