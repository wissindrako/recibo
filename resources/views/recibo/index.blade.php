<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recibo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6">
                    <Link href="{{ route('recibo.create')}}" class="font-bold text-gray-500">
                        Nuevo Recibo (+)
                    </Link>
                </div>
                
                <div class="p-6 ">
                    <x-splade-table :for="$recibos" striped auto class="table-fixed">
                        <x-slot name="head">
                            <thead class=" bg-slate-300">
                                <tr>
                                    @foreach($recibos->columns() as $column)
                                        <th class="border border-gray-100">{{ $column->label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                        </x-slot>
                    
                        <x-slot name="body">
                            <tbody class="">
                                @foreach($recibos->resource as $key => $recibo)
                                    <tr class="">
                                        <td class="px-2 text-center border">
                                            <p class="text-slate-500 font-semi-bold">{{ $key + 1 }}</p>
                                        </td>
                                        <td width=200px; class="text-slate-800 font-bold border">
                                            {{$recibo->cliente->nombre_completo}}
                                        </td>
                                        <td class="text-center border">{{f_formato($recibo->fecha)}}</td>
                                        <td class="text-center border"><p class="underline decoration-sky-600 hover:decoration-blue-400">{{$recibo->cantidad}}</p></td>
                                        <td width=400px; class="border">
                                            <p class="text-sky-600 font-bold">{{$recibo->concepto}}</p>
                                            <br>
                                            <p> {{$recibo->id}} <span class="italic">- {{$recibo->hash}}</span> </p>
                                        </td>
                                        <td class="text-center border">{{$recibo->estadoTexto }}</td>
                                        <td width=150px; class="border">
                                            <div class="flex flex-row items-center h-14">
                                                @if ($recibo->estado === 1)
                                                 <div class="px-1">
                                                    <Link href="{{ route('recibo.edit', $recibo->nroSerie) }}" class="font-bold text-indigo-500">
                                                        Editar
                                                    </Link>
                                                </div>
                                                @else
                                                <div class="px-1">
                                                    <Link class="font-bold text-slate-500">
                                                        Editar
                                                    </Link>
                                                </div>
                                                @endif
                                                <div class="px-1">
                                                    <a target="_blank" href="{{ route('recibo.show', [$recibo->id, 'reporte' => 'html']) }}" class="font-bold text-indigo-500">
                                                        <x-icon-file color="#7985f1" ancho="36" alto="36"/>
                                                    </a>
                                                </div>
                                                <div class="px-1">
                                                    <a target="_blank" href="{{ route('recibo.show', [$recibo->id, 'reporte' => 'pdf']) }}" class="font-bold text-indigo-500">
                                                        <x-icon-file-download color="#114ff1" ancho="36" alto="36"/>
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
