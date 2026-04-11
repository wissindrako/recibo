<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4">
                        <Link href="{{ route('rol.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">
                            + Nuevo rol
                        </Link>
                    </div>
                    <x-splade-table :for="$roles">
                        @cell('action', $rol)
                            <div class="flex flex-row items-center gap-1">
                                <Link href="{{ route('rol.show', $rol->id) }}" title="Ver detalle">
                                    <x-icon-list color="#6b7280" ancho="28" alto="28"/>
                                </Link>
                                <Link href="{{ route('rol.edit', hid($rol->id)) }}" title="Editar">
                                    <x-icon-edit color="#114ff1" ancho="28" alto="28"/>
                                </Link>
                            </div>
                        @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
