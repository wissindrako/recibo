<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            @isset($origen)
                Renovar Contrato — basado en #{{ $origen->nro_serie }}
            @else
                Nuevo Contrato
            @endisset
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @isset($origen)
                <div class="mb-4 p-3 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700 rounded text-sm text-indigo-700 dark:text-indigo-300">
                    Renovación basada en contrato <strong>#{{ $origen->nro_serie }}</strong> —
                    {{ $origen->persona->nombre_completo }} —
                    {{ $origen->fecha_inicio->format('d/m/Y') }} al {{ $origen->fecha_fin ? $origen->fecha_fin->format('d/m/Y') : 'indefinido' }}
                </div>
                @endisset

                <x-splade-form action="{{ route('contrato.store') }}" method="POST"
                    :default="[
                        'tipo'               => $origen->tipo ?? ($ultimo->tipo ?? 'alquiler'),
                        'arrendador_id'      => $origen->arrendador_id ?? ($ultimo->arrendador_id ?? null),
                        'persona_id'         => $origen->persona_id ?? null,
                        'inmueble_id'        => $origen->inmueble_id ?? null,
                        'descripcion_alquiler' => $origen->descripcion_alquiler ?? '',
                        'monto'              => $origen->monto ?? '',
                        'garantia'           => $origen->garantia ?? '',
                        'dia_limite_pago'    => $origen->dia_limite_pago ?? '',
                        'contrato_origen_id' => $origen->id ?? null,
                    ]">

                    <input type="hidden" name="contrato_origen_id" value="{{ $origen->id ?? '' }}"/>
                    @include('contrato.form')
                </x-splade-form>
            </div>
        </div>
    </div>
</x-app-layout>
