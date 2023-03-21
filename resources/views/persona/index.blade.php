<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3">

                    <Link href="{{ route('persona.create') }}" class="font-bold text-gray-500">
                        Nuevo Cliente (+)
                    </Link>

                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$personas">
                        @cell('action', $persona)
                            <Link href="{{ route('persona.show', $persona->id) }}" class="font-bold text-gray-500">
                                Mostrar
                            </Link>
                            <Link href="{{ route('persona.edit', $persona->id) }}" class="font-bold text-indigo-500">
                                Editar
                            </Link>
                        @endcell
                    </x-splade-table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
