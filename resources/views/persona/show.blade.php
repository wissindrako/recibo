<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nombre completo</span>
                        <span class="font-bold">{{ $persona->titulo }} {{ $persona->nombre_completo }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">C.I.</span>
                        <span>{{ $persona->ci }}{{ $persona->complemento ? ' ' . $persona->complemento : '' }}{{ $persona->expedido ? ' ' . $persona->expedido : '' }}</span>
                    </div>
                    @if($persona->fecha_nacimiento)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Fecha de nacimiento</span>
                        <span>{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') }}</span>
                    </div>
                    @endif
                    @if($persona->genero)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Género</span>
                        <span>{{ $persona->genero }}</span>
                    </div>
                    @endif
                    @if($persona->telefono)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Teléfono</span>
                        <span>{{ $persona->telefono }}</span>
                    </div>
                    @endif
                    @if($persona->domicilio)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Domicilio</span>
                        <span>{{ $persona->domicilio }}</span>
                    </div>
                    @endif
                    @if($persona->ocupacion_profesion)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Ocupación / Profesión</span>
                        <span>{{ $persona->ocupacion_profesion }}</span>
                    </div>
                    @endif
                </div>
                <div class="px-6 pb-4">
                    <Link href="{{ route('persona.edit', $persona->id) }}" class="font-bold text-indigo-500">
                        Editar
                    </Link>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
