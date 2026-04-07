<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arrendadores / Propietarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6">
                    <Link href="{{ route('admin.arrendador.create') }}" class="font-bold text-gray-500">
                        Nuevo Arrendador (+)
                    </Link>
                </div>
                <div class="p-6">
                    <x-splade-table :for="$arrendadores" striped search-debounce="900">
                        @cell('activo', $arrendador)
                            @if($arrendador->activo)
                                <span class="text-emerald-600 font-bold">Activo</span>
                            @else
                                <span class="text-slate-400 font-bold">Inactivo</span>
                            @endif
                        @endcell

                        @cell('action', $arrendador)
                            <div class="flex flex-row items-center gap-1">
                                <Link href="{{ route('admin.arrendador.edit', $arrendador->id) }}" title="Editar">
                                    <x-icon-edit color="#114ff1" ancho="28" alto="28"/>
                                </Link>
                                <Link href="{{ route('admin.arrendador.toggle', $arrendador->id) }}" confirm
                                      title="{{ $arrendador->activo ? 'Desactivar' : 'Activar' }}">
                                    <x-icon-double-check color="{{ $arrendador->activo ? '#10b981' : '#9ca3af' }}" ancho="28" alto="28"/>
                                </Link>
                            </div>
                        @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
