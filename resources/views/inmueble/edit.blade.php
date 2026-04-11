<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Editar Inmueble — {{ $inmueble->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-splade-form action="{{ route('inmueble.update', $inmueble) }}" method="PUT"
                    :default="[
                        'nombre'      => $inmueble->nombre,
                        'patrimonio'  => $inmueble->patrimonio,
                        'ubicacion'   => $inmueble->ubicacion,
                        'descripcion' => $inmueble->descripcion,
                        'servicios'   => $inmueble->servicios ?? [],
                    ]">
                    @include('inmueble.form')
                </x-splade-form>
            </div>
        </div>
    </div>
</x-app-layout>
