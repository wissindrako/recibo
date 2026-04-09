<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ficha del Cliente</h2>
            <div class="flex gap-2">
                <Link href="{{ route('persona.edit', $persona) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </Link>
                <Link href="{{ route('personas') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-lg hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Volver
                </Link>
            </div>
        </div>
    </x-slot>

    @php
        $recibosActivos = $persona->recibos->where('estado', '!=', 0);
        $totalPagado    = $recibosActivos->sum('cantidad');
        $totalRecibos   = $persona->recibos->count();
        $ultimoPago     = $persona->recibos->first();
        $aprobados      = $persona->recibos->where('estado', 2)->count();
        $iniciales      = mb_strtoupper(mb_substr($persona->nombres ?? '', 0, 1))
                        . mb_strtoupper(mb_substr($persona->ap_paterno ?? $persona->ap_materno ?? '', 0, 1));
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===== TARJETA PERFIL ===== --}}
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                {{-- Banner con avatar y nombre integrados --}}
                <div class="bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 px-6 py-6 relative">
                    {{-- Patrón de fondo sutil --}}
                    <div class="absolute inset-0 opacity-10 pointer-events-none"
                         style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 28px 28px;"></div>

                    {{-- Badge estado (esquina superior derecha) --}}
                    <div class="absolute top-4 right-5">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                            {{ $persona->active ? 'bg-white/20 text-white ring-1 ring-white/30' : 'bg-red-500/30 text-red-100 ring-1 ring-red-300/30' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $persona->active ? 'bg-emerald-300' : 'bg-red-300' }}"></span>
                            {{ $persona->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>

                    {{-- Avatar + nombre --}}
                    <div class="flex items-center gap-4 relative">
                        <div class="w-20 h-20 rounded-2xl bg-white/20 ring-2 ring-white/40 flex items-center justify-center text-white text-3xl font-bold shadow-inner shrink-0">
                            {{ $iniciales }}
                        </div>
                        <div class="min-w-0">
                            @if($persona->titulo)
                                <span class="text-xs font-medium text-indigo-200 uppercase tracking-widest">{{ $persona->titulo }}</span>
                            @endif
                            <h1 class="text-xl font-bold text-white leading-tight truncate">{{ $persona->nombre_completo }}</h1>
                            @if($persona->ocupacion_profesion)
                                <p class="text-sm text-indigo-200 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    {{ $persona->ocupacion_profesion }}
                                </p>
                            @endif
                            <p class="text-xs text-indigo-300 mt-1">
                                Registrado {{ \Carbon\Carbon::parse($persona->created_at)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== ESTADÍSTICAS ===== --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center gap-2 border-t-2 border-indigo-500">
                    <div class="w-9 h-9 rounded-full bg-indigo-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">{{ $totalRecibos }}</span>
                    <span class="text-xs text-gray-400 text-center">Recibos emitidos</span>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center gap-2 border-t-2 border-emerald-500">
                    <div class="w-9 h-9 rounded-full bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">{{ $aprobados }}</span>
                    <span class="text-xs text-gray-400 text-center">Aprobados</span>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center gap-2 border-t-2 border-violet-500">
                    <div class="w-9 h-9 rounded-full bg-violet-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900 leading-tight">{{ number_format($totalPagado, 2) }}</span>
                    <span class="text-xs text-gray-400 text-center">Total Bs</span>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center gap-2 border-t-2 border-amber-400">
                    <div class="w-9 h-9 rounded-full bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-900 leading-tight">
                        {{ $ultimoPago ? \Carbon\Carbon::parse($ultimoPago->fecha)->format('d/m/Y') : '—' }}
                    </span>
                    <span class="text-xs text-gray-400 text-center">Último pago</span>
                </div>
            </div>

            {{-- ===== DATOS PERSONALES ===== --}}
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-3 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    <h3 class="text-sm font-semibold text-gray-600">Identificación</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-px bg-gray-100">

                    {{-- CI --}}
                    <div class="bg-white px-5 py-4">
                        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                            Cédula de Identidad
                        </p>
                        <p class="font-semibold text-gray-800 font-mono">
                            @if($persona->ci)
                                {{ $persona->ci }}{{ $persona->complemento ? ' ' . $persona->complemento : '' }}
                                @if($persona->expedido)
                                    <span class="ml-1 text-xs font-sans font-normal bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">{{ $persona->expedido }}</span>
                                @endif
                            @else
                                <span class="text-gray-300 font-sans font-normal">Sin registro</span>
                            @endif
                        </p>
                    </div>

                    {{-- Género --}}
                    <div class="bg-white px-5 py-4">
                        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Género
                        </p>
                        <p class="font-semibold text-gray-800">
                            @if($persona->genero === 'M') Masculino
                            @elseif($persona->genero === 'F') Femenino
                            @else <span class="text-gray-300 font-normal">—</span>
                            @endif
                        </p>
                    </div>

                    {{-- Fecha de nacimiento --}}
                    <div class="bg-white px-5 py-4">
                        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18z"/></svg>
                            Fecha de nacimiento
                        </p>
                        @if($persona->fecha_nacimiento)
                            <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->age }} años</p>
                        @else
                            <p class="text-gray-300">—</p>
                        @endif
                    </div>

                </div>

                {{-- Contacto --}}
                <div class="border-t border-gray-100 px-6 py-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <h3 class="text-sm font-semibold text-gray-600">Contacto y domicilio</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-px bg-gray-100 border-t border-gray-100">

                    <div class="bg-white px-5 py-4">
                        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Teléfono
                        </p>
                        <p class="font-semibold text-gray-800">{{ $persona->telefono ?? '—' }}</p>
                    </div>

                    <div class="bg-white px-5 py-4">
                        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Domicilio
                        </p>
                        <p class="font-semibold text-gray-800">{{ $persona->domicilio ?? '—' }}</p>
                    </div>

                </div>
            </div>

            {{-- ===== CUENTA VINCULADA ===== --}}
            @if($persona->user)
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-3 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <h3 class="text-sm font-semibold text-gray-600">Cuenta de usuario vinculada</h3>
                </div>
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-violet-100 flex items-center justify-center text-violet-700 font-bold text-sm shrink-0">
                        {{ mb_strtoupper(mb_substr($persona->user->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 text-sm">{{ $persona->user->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $persona->user->email }}</p>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-full font-semibold
                        {{ $persona->user->is_active ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-red-50 text-red-500 ring-1 ring-red-200' }}">
                        {{ $persona->user->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
            @endif

            {{-- ===== HISTORIAL DE RECIBOS ===== --}}
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-3 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <h3 class="text-sm font-semibold text-gray-600">Historial de recibos</h3>
                    </div>
                    @if($totalRecibos > 10)
                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                            Últimos 10 de {{ $totalRecibos }}
                        </span>
                    @endif
                </div>

                @if($persona->recibos->isNotEmpty())

                {{-- Cabecera tabla --}}
                <div class="hidden sm:grid grid-cols-12 gap-2 px-5 py-2 bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                    <div class="col-span-1 text-center">Nº</div>
                    <div class="col-span-5">Concepto</div>
                    <div class="col-span-2 text-center">Fecha</div>
                    <div class="col-span-2 text-right">Monto</div>
                    <div class="col-span-1 text-center">Estado</div>
                    <div class="col-span-1"></div>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach($persona->recibos as $recibo)
                    <div class="grid grid-cols-12 gap-2 px-5 py-3 items-center hover:bg-indigo-50/30 transition group">
                        <div class="col-span-1 text-center">
                            <span class="text-xs font-mono text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ $recibo->nroSerie }}</span>
                        </div>
                        <div class="col-span-5 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $recibo->concepto }}</p>
                        </div>
                        <div class="col-span-2 text-center">
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($recibo->fecha)->format('d/m/Y') }}</span>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-sm font-bold {{ $recibo->estado === 0 ? 'text-gray-300 line-through' : 'text-gray-800' }}">
                                {{ number_format($recibo->cantidad, 2) }}
                            </span>
                            <span class="text-xs text-gray-400"> Bs</span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <span class="text-xs px-1.5 py-0.5 rounded font-semibold
                                {{ $recibo->estado === 2 ? 'bg-emerald-100 text-emerald-700' : ($recibo->estado === 0 ? 'bg-red-100 text-red-400' : 'bg-sky-100 text-sky-600') }}">
                                {{ $recibo->estadoTexto }}
                            </span>
                        </div>
                        <div class="col-span-1 flex justify-center">
                            <a target="_blank"
                                href="{{ route('recibo.show', [$recibo->getRouteKey(), 'reporte' => 'pdf-codigo']) }}"
                                class="text-gray-300 group-hover:text-indigo-400 transition" title="Ver PDF">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-400">Total válido (excluye anulados)</span>
                    <span class="font-bold text-gray-900">{{ number_format($totalPagado, 2) }} <span class="text-sm font-normal text-gray-400">Bs</span></span>
                </div>

                @else
                <div class="py-12 flex flex-col items-center gap-2 text-gray-300">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-sm">Sin recibos registrados</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
