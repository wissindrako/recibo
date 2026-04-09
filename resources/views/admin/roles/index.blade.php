<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
