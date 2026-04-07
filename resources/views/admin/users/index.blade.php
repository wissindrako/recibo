<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6">
                    <Link href="{{ route('user.create')}}" class="font-bold text-gray-500">
                        Nuevo Usuario (+)
                    </Link>
                </div>
                <div class="p-6 bg-white mx-auto border-b border-gray-200 gap-2">
                    <x-splade-table :for="$users" search-debounce="900">
                        @cell('action', $user)
                        <div class="flex flex-row items-center gap-1">
                            <Link href="{{ route('user.edit', $user) }}" title="Editar usuario">
                                <x-icon-edit color="#114ff1" ancho="28" alto="28"/>
                            </Link>
                            <Link href="{{ route('user.email_confirm', $user) }}" confirm title="Confirmar email">
                                <x-icon-chat-check color="#f59e0b" ancho="28" alto="28"/>
                            </Link>
                            <Link href="{{ route('user.active', $user) }}" confirm title="{{ $user->is_active ? 'Desactivar usuario' : 'Activar usuario' }}">
                                <x-icon-double-check color="{{ $user->is_active ? '#10b981' : '#9ca3af' }}" ancho="28" alto="28"/>
                            </Link>
                        </div>
                        @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
