<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6 border-b border-gray-100 dark:border-gray-700">
                    <Link href="{{ route('persona.create') }}" class="font-bold text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                        + Nuevo Cliente
                    </Link>
                </div>
                <div class="p-6">
                    <x-splade-table :for="$personas">
                        @cell('action', $persona)
                            <div class="flex flex-row items-center gap-1">
                                <Link href="{{ route('persona.show', $persona) }}" title="Ver detalle">
                                    <x-icon-user color="#6b7280" ancho="28" alto="28"/>
                                </Link>
                                <Link href="{{ route('persona.edit', $persona) }}" title="Editar">
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
