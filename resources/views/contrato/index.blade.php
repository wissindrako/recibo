<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contratos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6">
                    <Link href="{{ route('contrato.create') }}" class="font-bold text-gray-500">
                        Nuevo Contrato (+)
                    </Link>
                </div>

                <div class="p-6">
                    <x-splade-table :for="$contratos" striped auto class="table-fixed">
                        <x-slot name="head">
                            <thead class="bg-slate-300">
                                <tr>
                                    @foreach($contratos->columns() as $column)
                                        <th class="border border-gray-100">{{ $column->label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                        </x-slot>

                        <x-slot name="body">
                            <tbody>
                                @foreach($contratos->resource as $contrato)
                                    <tr>
                                        <td class="px-2 text-center border">
                                            <span class="text-slate-500 font-semibold">{{ $contrato->nro_serie }}</span>
                                        </td>
                                        <td class="px-2 text-center border">
                                            <span class="font-semibold
                                                @if($contrato->tipo === 'alquiler') text-indigo-600
                                                @elseif($contrato->tipo === 'venta') text-emerald-600
                                                @else text-slate-500 @endif">
                                                {{ $contrato->tipoTexto }}
                                            </span>
                                        </td>
                                        <td class="px-2 border font-bold text-slate-800">
                                            {{ $contrato->persona->nombre_completo }}
                                        </td>
                                        <td class="px-2 text-center border">
                                            {{ $contrato->fecha_inicio ? $contrato->fecha_inicio->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-2 text-center border">
                                            {{ $contrato->fecha_fin ? $contrato->fecha_fin->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-2 text-center border font-bold">
                                            {{ number_format($contrato->monto, 2) }}
                                        </td>
                                        <td class="px-2 text-center border">
                                            @php $estado = $contrato->calcularEstado(); @endphp
                                            @if($estado === 1)
                                                <span class="text-emerald-600 font-bold">Vigente</span>
                                            @elseif($estado === 2)
                                                <span class="text-amber-500 font-bold">Vencido</span>
                                            @else
                                                <span class="text-red-500 font-bold">Anulado</span>
                                            @endif
                                        </td>
                                        <td class="border px-2">
                                            <div class="flex flex-row items-center gap-1 h-14">
                                                <a target="_blank" href="{{ route('contrato.show', $contrato) }}" class="text-indigo-500 font-bold px-1">
                                                    <x-icon-file color="#7985f1" ancho="32" alto="32"/>
                                                </a>
                                                @if($contrato->calcularEstado() !== 0)
                                                <Link href="{{ route('contrato.edit', $contrato) }}" class="text-indigo-500 font-bold px-1">
                                                    <x-icon-edit color="#114ff1" ancho="32" alto="32"/>
                                                </Link>
                                                <a href="{{ route('contrato.renovar', $contrato) }}" class="text-emerald-500 font-bold px-1" title="Renovar">
                                                    <x-icon-return-back color="#10b981" ancho="32" alto="32"/>
                                                </a>
                                                @if($contrato->calcularEstado() !== 0)
                                                <a href="{{ route('contrato.anular', $contrato) }}"
                                                   onclick="return confirm('¿Anular este contrato?')"
                                                   class="text-red-500 font-bold px-1" title="Anular">
                                                    <x-icon-delete color="#ef4444" ancho="32" alto="32"/>
                                                </a>
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </x-slot>
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
