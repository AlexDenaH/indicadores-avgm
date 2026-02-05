<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LOGO -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto text-gray-800" />
                </a>
            </div>

            <!-- ========================= -->
            <!-- MENU DESKTOP -->
            <!-- ========================= -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8 sm:ms-10">

                <!-- DASHBOARD -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-nav-link>
                <x-nav-link :href="route('concentrados.index')" :active="request()->routeIs('concentrados.index')">
                    Registro
                </x-nav-link>
                <!-- USUARIOS -->
                @role('super-admin|administrador')
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    Usuarios
                </x-nav-link>
                @endrole

                <!-- PERIODOS -->
                @role('super-admin|administrador')
                <x-nav-link :href="route('periodos.index')" :active="request()->routeIs('periodos.*')">
                    Periodos
                </x-nav-link>
                @endrole

                <!-- ========================= -->
                <!-- DROPDOWN PROGRAMAS -->
                <!-- ========================= -->
                <div x-data="{ openProgramas: false }" class="relative">
                    <button @click="openProgramas = !openProgramas"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Programas
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openProgramas" @click.away="openProgramas = false"
                        class="absolute mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">

                            {{-- SOLO SUPER-ADMIN --}}
                            @role('super-admin')
                            <x-dropdown-link :href="route('ejercicios.index')" :active="request()->routeIs('ejercicios.*')">
                                Ejercicios
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('programas.index')" :active="request()->routeIs('programas.*')">
                                Programas
                            </x-dropdown-link>
                            @endrole

                            {{-- SUPER-ADMIN Y ADMINISTRADOR --}}
                            @role('super-admin|administrador')
                            <x-dropdown-link :href="route('indicadores.index')" :active="request()->routeIs('indicadores.*')">
                                Indicadores
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('nivel-detalle.index')" :active="request()->routeIs('nivel-detalle.*')">
                                Detalle
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('componentes.index')" :active="request()->routeIs('componentes.*')">
                                Componentes
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('asignaciones.index')" :active="request()->routeIs('asignacion.*')">
                                Asignación
                            </x-dropdown-link>
                            @endrole
                        </div>
                    </div>
                </div>

                <!-- ========================= -->
                <!-- DROPDOWN CATALOGOS -->
                <!-- ========================= -->
                @role('super-admin')
                <div x-data="{ openCatalogos: false }" class="relative">
                    <button @click="openCatalogos = !openCatalogos"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Catálogos
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="openCatalogos" @click.away="openCatalogos = false"
                        class="absolute mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <x-dropdown-link :href="route('dependencias.index')">Dependencias</x-dropdown-link>
                            <x-dropdown-link :href="route('dependencia_areas.index')">Áreas de Dependencias</x-dropdown-link>
                            <x-dropdown-link :href="route('municipios.index')">Municipios</x-dropdown-link>
                        </div>
                    </div>
                </div>
                @endrole

            </div>

            <!-- ========================= -->
            <!-- USUARIO -->
            <!-- ========================= -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500">
                            {{ Auth::user()->name }}
                            <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- ========================= -->
            <!-- HAMBURGER -->
            <!-- ========================= -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-400 hover:bg-gray-100 rounded-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open }" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open }" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- ========================= -->
    <!-- MENU MOBILE -->
    <!-- ========================= -->
    <div x-show="open" class="sm:hidden">

        <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('concentrados.index')">Registro</x-responsive-nav-link>
        @role('super-admin|administrador')
        <x-responsive-nav-link :href="route('users.index')">Usuarios</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('periodos.index')">Periodos</x-responsive-nav-link>
        @endrole

        <div class="px-4 py-2 text-sm font-semibold text-gray-600">Programas</div>

        @role('super-admin')
        <x-responsive-nav-link :href="route('ejercicios.index')">Ejercicios</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('programas.index')">Programas</x-responsive-nav-link>
        @endrole

        @role('super-admin|administrador')
        <x-responsive-nav-link :href="route('indicadores.index')">Indicadores</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('nivel-detalle.index')">Detalle</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('componentes.index')">Componentes</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('asignaciones.index')">Asignación</x-responsive-nav-link>
        @endrole

        @role('super-admin')
        <div class="px-4 py-2 text-sm font-semibold text-gray-600">Catálogos</div>
        <x-responsive-nav-link :href="route('dependencias.index')">Dependencias</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('dependencia_areas.index')">Áreas</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('municipios.index')">Municipios</x-responsive-nav-link>
        @endrole

    </div>
</nav>