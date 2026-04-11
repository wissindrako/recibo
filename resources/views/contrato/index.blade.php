<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Contratos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6 border-b border-gray-100 dark:border-gray-700">
                    <Link href="{{ route('contrato.create') }}" class="font-bold text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                        + Nuevo Contrato
                    </Link>
                </div>

                <div class="p-6">
                    <x-splade-table :for="$contratos" striped auto class="table-fixed">
                        <x-slot name="head">
                            <thead class="bg-slate-200 dark:bg-gray-700">
                                <tr>
                                    @foreach($contratos->columns() as $column)
                                        <th class="border border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ $column->label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                        </x-slot>

                        <x-slot name="body">
                            <tbody>
                                @foreach($contratos->resource as $contrato)
                                    <tr class="transition">
                                        <td class="px-2 text-center border dark:border-gray-700">
                                            <span class="text-slate-500 dark:text-gray-400 font-semibold">{{ $contrato->nro_serie }}</span>
                                        </td>
                                        <td class="px-2 text-center border dark:border-gray-700">
                                            <span class="font-semibold
                                                @if($contrato->tipo === 'alquiler') text-indigo-600 dark:text-indigo-400
                                                @elseif($contrato->tipo === 'venta') text-emerald-600 dark:text-emerald-400
                                                @else text-slate-500 dark:text-gray-400 @endif">
                                                {{ $contrato->tipoTexto }}
                                            </span>
                                        </td>
                                        <td class="px-2 border dark:border-gray-700 font-bold text-slate-800 dark:text-gray-100">
                                            {{ $contrato->persona->nombre_completo }}
                                        </td>
                                        <td class="px-2 text-center border dark:border-gray-700 dark:text-gray-300">
                                            {{ $contrato->fecha_inicio ? $contrato->fecha_inicio->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-2 text-center border dark:border-gray-700 dark:text-gray-300">
                                            {{ $contrato->fecha_fin ? $contrato->fecha_fin->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-2 text-center border dark:border-gray-700 font-bold dark:text-gray-100">
                                            {{ number_format($contrato->monto, 2) }}
                                        </td>
                                        <td class="px-2 text-center border dark:border-gray-700">
                                            @php $estado = $contrato->calcularEstado(); @endphp
                                            @if($estado === 1)
                                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">Vigente</span>
                                            @elseif($estado === 2)
                                                <span class="text-amber-500 dark:text-amber-400 font-bold">Vencido</span>
                                            @else
                                                <span class="text-red-500 dark:text-red-400 font-bold">Anulado</span>
                                            @endif
                                        </td>
                                        <td class="border dark:border-gray-700 px-2">
                                            <div class="flex flex-row items-center gap-1 h-14">
                                                <a target="_blank" href="{{ route('contrato.show', $contrato) }}" class="px-1">
                                                    <x-icon-file color="#7985f1" ancho="32" alto="32"/>
                                                </a>
                                                @if($contrato->calcularEstado() !== 0)
                                                <Link href="{{ route('contrato.edit', $contrato) }}" class="px-1">
                                                    <x-icon-edit color="#114ff1" ancho="32" alto="32"/>
                                                </Link>
                                                <a href="{{ route('contrato.renovar', $contrato) }}" class="px-1" title="Renovar">
                                                    <x-icon-return-back color="#10b981" ancho="32" alto="32"/>
                                                </a>
                                                <a href="{{ route('contrato.anular', $contrato) }}"
                                                   onclick="return confirm('¿Anular este contrato?')"
                                                   class="px-1" title="Anular">
                                                    <x-icon-delete color="#ef4444" ancho="32" alto="32"/>
                                                </a>
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
