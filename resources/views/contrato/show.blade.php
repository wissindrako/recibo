<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contrato #{{ $contrato->nro_serie }} — {{ $contrato->tipoTexto }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Estado --}}
            <div class="flex items-center gap-4">
                @php $estado = $contrato->calcularEstado(); @endphp
                @if($estado === 1)
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full font-bold">Vigente</span>
                @elseif($estado === 2)
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full font-bold">Vencido</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full font-bold">Anulado</span>
                @endif

                <a target="_blank" href="{{ route('contrato.show', [$contrato->id, 'reporte' => 'pdf']) }}"
                   class="px-3 py-1 bg-indigo-600 text-white rounded font-bold text-sm hover:bg-indigo-700">
                    Descargar PDF
                </a>

                @if($contrato->archivo)
                <a href="{{ asset('storage/' . $contrato->archivo) }}" target="_blank"
                   class="px-3 py-1 bg-slate-600 text-white rounded font-bold text-sm hover:bg-slate-700">
                    Ver archivo adjunto
                </a>
                @endif

                @if($estado !== 0)
                <Link href="{{ route('contrato.renovar', $contrato->id) }}"
                   class="px-3 py-1 bg-emerald-600 text-white rounded font-bold text-sm hover:bg-emerald-700">
                    Renovar contrato
                </Link>
                @endif
            </div>

            {{-- Datos principales --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Tipo</p>
                        <p class="font-bold text-indigo-600">{{ $contrato->tipoTexto }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">N° Serie</p>
                        <p class="font-bold">{{ $contrato->nro_serie }}</p>
                    </div>
                </div>

                <hr/>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Arrendador / Propietario</p>
                        <p class="font-bold">
                            {{ $contrato->arrendador?->persona?->titulo }}
                            {{ $contrato->arrendador?->persona?->nombre_completo ?? $contrato->arrendador?->name }}
                        </p>
                        <p class="text-sm text-slate-500">
                            C.I. {{ $contrato->arrendador?->persona?->ci }}
                            {{ $contrato->arrendador?->persona?->complemento }}
                            {{ $contrato->arrendador?->persona?->expedido }}
                        </p>
                        <p class="text-xs text-slate-400">{{ $contrato->arrendador?->email }}</p>
                        @if($contrato->arrendador?->user)
                            <p class="text-xs text-slate-400">{{ $contrato->arrendador->user->email }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Arrendatario / Contratante</p>
                        <p class="font-bold">{{ $contrato->persona->nombre_completo }}</p>
                    </div>
                </div>

                <hr/>

                <div>
                    <p class="text-xs text-slate-500 uppercase">Bien</p>
                    <p>{{ $contrato->descripcion_bien }}</p>
                </div>

                <hr/>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Fecha inicio</p>
                        <p class="font-bold">{{ $contrato->fecha_inicio->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Fecha fin</p>
                        <p class="font-bold">{{ $contrato->fecha_fin ? $contrato->fecha_fin->format('d/m/Y') : 'Indefinido' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Monto Bs.</p>
                        <p class="font-bold text-lg">{{ number_format($contrato->monto, 2) }}</p>
                    </div>
                </div>

                @if($contrato->garantia || $contrato->dia_limite_pago)
                <div class="grid grid-cols-2 gap-4">
                    @if($contrato->garantia)
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Garantía Bs.</p>
                        <p class="font-bold">{{ number_format($contrato->garantia, 2) }}</p>
                    </div>
                    @endif
                    @if($contrato->dia_limite_pago)
                    <div>
                        <p class="text-xs text-slate-500 uppercase">Día límite de pago</p>
                        <p class="font-bold">Hasta el día {{ $contrato->dia_limite_pago }} de cada mes</p>
                    </div>
                    @endif
                </div>
                @endif

                @if($contrato->notas)
                <hr/>
                <div>
                    <p class="text-xs text-slate-500 uppercase">Notas</p>
                    <p class="text-sm">{{ $contrato->notas }}</p>
                </div>
                @endif

                @if($contrato->contratoOrigen)
                <hr/>
                <div>
                    <p class="text-xs text-slate-500 uppercase">Renovación de</p>
                    <Link href="{{ route('contrato.show', $contrato->contratoOrigen->id) }}" class="text-indigo-500 font-bold">
                        Contrato #{{ $contrato->contratoOrigen->nro_serie }}
                    </Link>
                </div>
                @endif

                <hr/>
                <div>
                    <p class="text-xs text-slate-500 uppercase">Registrado por</p>
                    <p class="text-sm">{{ $contrato->usuario->name ?? '-' }} — {{ $contrato->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="flex gap-4">
                <Link href="{{ route('contratos') }}" class="text-slate-500 font-bold text-sm">
                    ← Volver a contratos
                </Link>
            </div>
        </div>
    </div>
</x-app-layout>
