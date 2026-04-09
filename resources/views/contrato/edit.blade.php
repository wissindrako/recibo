<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Contrato #{{ $contrato->nro_serie }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-splade-form action="{{ route('contrato.update', $contrato) }}" method="PUT"
                    :default="[
                        'tipo'             => $contrato->tipo,
                        'arrendador_id'    => $contrato->arrendador_id,
                        'persona_id'       => $contrato->persona_id,
                        'descripcion_inmueble' => $contrato->descripcion_inmueble,
                        'descripcion_alquiler' => $contrato->descripcion_alquiler,
                        'fecha_inicio'     => $contrato->fecha_inicio?->format('Y-m-d'),
                        'fecha_fin'        => $contrato->fecha_fin?->format('Y-m-d'),
                        'monto'            => $contrato->monto,
                        'garantia'         => $contrato->garantia,
                        'dia_limite_pago'  => $contrato->dia_limite_pago,
                        'notas'            => $contrato->notas,
                    ]">

                    @include('contrato.form')
                </x-splade-form>
            </div>
        </div>
    </div>
</x-app-layout>
