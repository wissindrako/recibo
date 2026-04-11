<x-splade-toggle>
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                {{-- Links de escritorio --}}
                <div class="flex">
                    <div class="hidden space-x-1 sm:-my-px sm:ml-4 sm:flex sm:items-center">
                        @role('admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Panel
                        </x-nav-link>
                        @endrole
                        <x-nav-link :href="route('users')" :active="request()->routeIs('users', 'user.*')">
                            Usuarios
                        </x-nav-link>
                        <x-nav-link :href="route('roles')" :active="request()->routeIs('roles', 'rol.*')">
                            Roles
                        </x-nav-link>
                        <x-nav-link :href="route('personas')" :active="request()->routeIs('personas', 'persona.*')">
                            Clientes
                        </x-nav-link>
                        <x-nav-link :href="route('recibos')" :active="request()->routeIs('recibos', 'recibo.*')">
                            Recibos
                        </x-nav-link>
                        <x-nav-link :href="route('contratos')" :active="request()->routeIs('contratos', 'contrato.*')">
                            Contratos
                        </x-nav-link>
                        <x-nav-link :href="route('inmuebles')" :active="request()->routeIs('inmuebles', 'inmueble.*')">
                            Inmuebles
                        </x-nav-link>
                    </div>
                </div>

                {{-- Derecha: tema + usuario (escritorio) --}}
                <div class="hidden sm:flex sm:items-center sm:ml-6 gap-3">
                    {{-- Toggle dark mode --}}
                    <button onclick="
                        const html = document.documentElement;
                        if (html.classList.contains('dark')) {
                            html.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        } else {
                            html.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        }
                    " class="p-2 rounded-lg text-gray-400 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition" title="Cambiar tema">
                        <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <x-dropdown placement="bottom-end">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-900 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Perfil
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link as="a" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- Hamburger (móvil) --}}
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="toggle" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path v-bind:class="{ hidden: toggled, 'inline-flex': !toggled }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-bind:class="{ hidden: !toggled, 'inline-flex': toggled }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- Menú desplegable móvil --}}
        <div v-bind:class="{ block: toggled, hidden: !toggled }" class="sm:hidden dark:bg-gray-900 dark:border-t dark:border-gray-800">

            {{-- Navegación principal --}}
            <div class="pt-2 pb-3 space-y-1">
                @role('admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Panel Admin
                </x-responsive-nav-link>
                @endrole
                <x-responsive-nav-link :href="route('users')" :active="request()->routeIs('users', 'user.*')">
                    Usuarios
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('roles')" :active="request()->routeIs('roles', 'rol.*')">
                    Roles
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('personas')" :active="request()->routeIs('personas', 'persona.*')">
                    Clientes
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('recibos')" :active="request()->routeIs('recibos', 'recibo.*')">
                    Recibos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('contratos')" :active="request()->routeIs('contratos', 'contrato.*')">
                    Contratos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inmuebles')" :active="request()->routeIs('inmuebles', 'inmueble.*')">
                    Inmuebles
                </x-responsive-nav-link>
            </div>

            {{-- Usuario + acciones --}}
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
                <div class="px-4 flex items-center justify-between">
                    <div>
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                    {{-- Toggle dark mode móvil --}}
                    <button onclick="
                        const html = document.documentElement;
                        if (html.classList.contains('dark')) {
                            html.classList.remove('dark');
                            localStorage.setItem('theme', 'light');
                        } else {
                            html.classList.add('dark');
                            localStorage.setItem('theme', 'dark');
                        }
                    " class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Perfil
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link as="a" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>

        </div>
    </nav>
</x-splade-toggle>
