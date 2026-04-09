<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800">Panel Administrativo</h2>
                <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('l, d \d\e F \d\e Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ═══════════════════════════════════════
                 SECCIÓN: FINANCIERO
            ═══════════════════════════════════════ --}}
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Financiero
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Total recaudado --}}
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500">
                        <p class="text-xs text-gray-400 mb-1">Total recaudado</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalRecaudado, 2) }} <span class="text-sm font-normal text-gray-400">Bs</span></p>
                        <p class="text-xs text-gray-400 mt-2">Solo recibos aprobados</p>
                    </div>

                    {{-- Este mes --}}
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-emerald-500">
                        <p class="text-xs text-gray-400 mb-1">Recaudado este mes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($recaudadoEsteMes, 2) }} <span class="text-sm font-normal text-gray-400">Bs</span></p>
                        @if($variacionMes !== null)
                            <p class="text-xs mt-2 flex items-center gap-1 {{ $variacionMes >= 0 ? 'text-emerald-500' : 'text-red-400' }}">
                                @if($variacionMes >= 0)
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                @else
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                @endif
                                {{ abs($variacionMes) }}% vs mes anterior ({{ number_format($recaudadoMesAnterior, 2) }} Bs)
                            </p>
                        @else
                            <p class="text-xs text-gray-300 mt-2">Sin datos del mes anterior</p>
                        @endif
                    </div>

                    {{-- Promedio por recibo --}}
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-violet-500">
                        <p class="text-xs text-gray-400 mb-1">Promedio por recibo</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($promedioRecibo, 2) }} <span class="text-sm font-normal text-gray-400">Bs</span></p>
                        <p class="text-xs text-gray-400 mt-2">De recibos aprobados</p>
                    </div>

                    {{-- Mayor recibo --}}
                    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-400">
                        <p class="text-xs text-gray-400 mb-1">Mayor recibo</p>
                        @if($mayorRecibo)
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($mayorRecibo->cantidad, 2) }} <span class="text-sm font-normal text-gray-400">Bs</span></p>
                            <p class="text-xs text-gray-500 mt-2 truncate" title="{{ $mayorRecibo->cliente?->nombre_completo }}">
                                {{ $mayorRecibo->nroSerie }} · {{ $mayorRecibo->cliente?->nombre_completo ?? '—' }}
                            </p>
                        @else
                            <p class="text-gray-300 text-sm mt-2">Sin datos</p>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ═══════════════════════════════════════
                 SECCIÓN: RECIBOS
            ═══════════════════════════════════════ --}}
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Recibos
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                    {{-- KPIs de estados --}}
                    <div class="bg-white rounded-xl shadow-sm p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-700">Por estado</p>
                            <span class="text-xs text-gray-400">Total: {{ $totalRecibos }}</span>
                        </div>

                        <div class="space-y-3">
                            {{-- Aprobados --}}
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-emerald-600 font-medium">Aprobados</span>
                                    <span class="font-bold text-gray-700">{{ $aprobados }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ $totalRecibos > 0 ? round($aprobados/$totalRecibos*100) : 0 }}%"></div>
                                </div>
                            </div>
                            {{-- Registrados --}}
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-sky-600 font-medium">Registrados</span>
                                    <span class="font-bold text-gray-700">{{ $registrados }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-sky-400 h-1.5 rounded-full transition-all" style="width: {{ $totalRecibos > 0 ? round($registrados/$totalRecibos*100) : 0 }}%"></div>
                                </div>
                            </div>
                            {{-- Anulados --}}
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-red-400 font-medium">Anulados</span>
                                    <span class="font-bold text-gray-700">{{ $anulados }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-red-400 h-1.5 rounded-full transition-all" style="width: {{ $totalRecibos > 0 ? round($anulados/$totalRecibos*100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-gray-50 flex items-center justify-between">
                            <p class="text-xs text-gray-400">Tasa de aprobación</p>
                            <p class="text-sm font-bold {{ $tasaAprobacion >= 70 ? 'text-emerald-600' : ($tasaAprobacion >= 40 ? 'text-amber-500' : 'text-red-400') }}">
                                {{ $tasaAprobacion }}%
                            </p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-400">Emitidos este mes</p>
                            <p class="text-sm font-bold text-gray-700">{{ $emitidosEsteMes }}</p>
                        </div>
                    </div>

                    {{-- Tendencia últimos 6 meses --}}
                    <div class="bg-white rounded-xl shadow-sm p-5 lg:col-span-2">
                        <p class="text-sm font-semibold text-gray-700 mb-4">Recaudación últimos 6 meses (aprobados)</p>

                        @if($tendencia->isNotEmpty())
                            @php $maxMonto = $tendencia->max('monto') ?: 1; @endphp
                            <div class="space-y-2.5">
                                @foreach($tendencia as $t)
                                <div class="flex items-center gap-3 text-xs">
                                    <span class="text-gray-500 w-16 shrink-0 capitalize">{{ $t['mes'] }}</span>
                                    <div class="flex-1 bg-gray-100 rounded-full h-5 relative overflow-hidden">
                                        <div class="h-5 rounded-full bg-indigo-500 transition-all flex items-center justify-end pr-2"
                                             style="width: {{ round($t['monto']/$maxMonto*100) }}%; min-width: 2px;">
                                        </div>
                                    </div>
                                    <span class="text-gray-600 font-semibold w-28 text-right shrink-0">
                                        {{ number_format($t['monto'], 2) }} Bs
                                    </span>
                                    <span class="text-gray-400 w-14 text-right shrink-0">
                                        {{ $t['total'] }} rec.
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-28 text-gray-300 gap-2">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                <p class="text-sm">Sin datos aún</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ═══════════════════════════════════════
                 SECCIÓN: MORA
            ═══════════════════════════════════════ --}}
            <div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span class="text-red-400">Clientes en mora</span>
                    @if($enMora->isNotEmpty())
                        <span class="bg-red-100 text-red-500 text-xs font-bold px-2 py-0.5 rounded-full">{{ $enMora->count() }}</span>
                    @endif
                </h3>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    @if($enMora->isNotEmpty())

                    {{-- Resumen --}}
                    <div class="px-5 py-3 bg-red-50 border-b border-red-100 flex flex-wrap gap-4 text-sm">
                        <div>
                            <span class="text-red-400 text-xs">Clientes con mora</span>
                            <p class="font-bold text-red-700">{{ $enMora->count() }}</p>
                        </div>
                        <div>
                            <span class="text-red-400 text-xs">Total pendiente</span>
                            <p class="font-bold text-red-700">{{ number_format($enMora->sum('total_pendiente'), 2) }} Bs</p>
                        </div>
                        <div>
                            <span class="text-red-400 text-xs">Recibos sin aprobar</span>
                            <p class="font-bold text-red-700">{{ $enMora->sum('cantidad') }}</p>
                        </div>
                    </div>

                    {{-- Cabecera tabla --}}
                    <div class="hidden sm:grid grid-cols-12 gap-2 px-5 py-2 bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                        <div class="col-span-4">Cliente</div>
                        <div class="col-span-2 text-center">Recibos pendientes</div>
                        <div class="col-span-3 text-right">Total pendiente</div>
                        <div class="col-span-2 text-center">Días en mora</div>
                        <div class="col-span-1"></div>
                    </div>

                    <div class="divide-y divide-gray-50">
                        @foreach($enMora as $item)
                        @php
                            $diasMora = $item['dias_mora'];
                            $colorMora = $diasMora >= 90 ? 'text-red-600 bg-red-100' : ($diasMora >= 30 ? 'text-amber-600 bg-amber-100' : 'text-sky-600 bg-sky-100');
                        @endphp
                        <div class="grid grid-cols-12 gap-2 px-5 py-3.5 items-center hover:bg-red-50/40 transition">
                            <div class="col-span-4 flex items-center gap-2 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600 text-xs font-bold shrink-0">
                                    {{ mb_strtoupper(mb_substr($item['persona']->nombres ?? '', 0, 1)) }}{{ mb_strtoupper(mb_substr($item['persona']->ap_paterno ?? '', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $item['persona']->nombre_completo }}</p>
                                    @if($item['persona']->telefono)
                                        <p class="text-xs text-gray-400">{{ $item['persona']->telefono }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="inline-block bg-sky-100 text-sky-700 text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ $item['cantidad'] }}
                                </span>
                            </div>
                            <div class="col-span-3 text-right">
                                <span class="text-sm font-bold text-gray-800">{{ number_format($item['total_pendiente'], 2) }}</span>
                                <span class="text-xs text-gray-400"> Bs</span>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="text-xs font-bold px-2 py-1 rounded-full {{ $colorMora }}">
                                    {{ $diasMora }}d
                                </span>
                            </div>
                            <div class="col-span-1 flex justify-center">
                                <Link href="{{ route('persona.show', $item['persona']) }}"
                                    class="text-gray-300 hover:text-indigo-500 transition" title="Ver ficha">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </Link>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @else
                    <div class="py-14 flex flex-col items-center gap-2 text-gray-300">
                        <svg class="w-10 h-10 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-emerald-400 font-medium">Sin clientes en mora</p>
                        <p class="text-xs text-gray-300">Todos los recibos están al día</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
