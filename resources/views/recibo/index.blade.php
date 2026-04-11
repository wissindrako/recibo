<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Recibos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6 border-b border-gray-100 dark:border-gray-700">
                    <Link href="{{ route('recibo.create')}}" class="font-bold text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                        + Nuevo Recibo
                    </Link>
                </div>

                <div class="p-6">
                    <x-splade-table :for="$recibos" striped auto class="table-fixed">
                        <x-slot name="head">
                            <thead class="bg-slate-200 dark:bg-gray-700">
                                <tr>
                                    @foreach($recibos->columns() as $column)
                                        <th class="border border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ $column->label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                        </x-slot>

                        <x-slot name="body">
                            <tbody>
                                @foreach($recibos->resource as $key => $recibo)
                                    <tr class="transition">
                                        <td class="px-2 text-center border dark:border-gray-700">
                                            <p class="text-slate-500 dark:text-gray-400 font-semibold">{{ $key + 1 }}</p>
                                        </td>
                                        <td width="200px" class="text-slate-800 dark:text-gray-100 font-bold border dark:border-gray-700">
                                            {{$recibo->cliente->nombre_completo}}
                                        </td>
                                        <td class="text-center border dark:border-gray-700 dark:text-gray-300">{{f_formato($recibo->fecha)}}</td>
                                        <td class="text-center border dark:border-gray-700">
                                            <p class="underline decoration-sky-600 dark:text-gray-100 hover:decoration-blue-400"><strong>{{$recibo->cantidad}}</strong></p>
                                        </td>
                                        <td width="400px" class="border dark:border-gray-700">
                                            <p class="text-rose-600 dark:text-rose-400 font-bold">{{$recibo->concepto}}</p>
                                            <br>
                                            <p class="dark:text-gray-400"> {{$recibo->nroSerie}} <span class="italic">- {{$recibo->hash}}</span> </p>
                                        </td>
                                        <td class="text-center border dark:border-gray-700">
                                            @if ($recibo->estado === 1)
                                                <span class="text-sky-600 dark:text-sky-400 font-bold">{{$recibo->estadoTexto }}</span>
                                            @else
                                                <span class="text-emerald-500 dark:text-emerald-400 font-bold">{{$recibo->estadoTexto }}</span>
                                            @endif
                                        </td>
                                        <td width="150px" class="border dark:border-gray-700">
                                            <div class="flex flex-row items-center h-14">
                                                @if ($recibo->estado === 1)
                                                <div class="px-1">
                                                    <a href="{{ route('recibo.edit-estado', $recibo) }}">
                                                        <x-icon-unlock color="#114ff1" ancho="36" alto="36"/>
                                                    </a>
                                                </div>
                                                <div class="px-1">
                                                    <Link href="{{ route('recibo.edit', $recibo) }}" class="font-bold text-indigo-500 dark:text-indigo-400">
                                                        Editar
                                                    </Link>
                                                </div>
                                                @else
                                                <div class="px-1">
                                                    <a href="{{ route('recibo.edit-estado', $recibo) }}">
                                                        <x-icon-chat-locked color="#04b834" ancho="36" alto="36"/>
                                                    </a>
                                                </div>
                                                <div class="px-1">
                                                    <a href="#" onclick="return false;" class="font-bold text-slate-400 dark:text-gray-600">
                                                        Editar
                                                    </a>
                                                </div>
                                                @endif
                                                <div class="px-1">
                                                    <a target="_blank" href="{{ route('recibo.show', [$recibo->getRouteKey(), 'reporte' => 'hoja-entera']) }}">
                                                        <x-icon-library color="#7985f1" ancho="36" alto="36" />
                                                    </a>
                                                </div>
                                                <div class="px-1">
                                                    <a target="_blank" href="{{ route('recibo.show', [$recibo->getRouteKey(), 'reporte' => 'pdf-codigo']) }}">
                                                        <x-icon-file-done color="#114ff1" ancho="36" alto="36"/>
                                                    </a>
                                                </div>
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
