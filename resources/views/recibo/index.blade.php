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
                
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$recibos" striped auto class="table-fixed">
                        <x-slot name="head">
                            <thead>
                                <tr>
                                    @foreach($recibos->columns() as $column)
                                        <th>{{ $column->label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                        </x-slot>
                    
                        <x-slot name="body">
                            <tbody class="">
                                @foreach($recibos->resource as $key => $recibo)
                                    <tr class="border">
                                        <td class="px-2 text-center">
                                            <p class="text-slate-500 font-semi-bold">{{ $key + 1 }}</p>
                                        </td>
                                        <td width=200px; class="text-slate-800 font-bold">
                                            {{$recibo->cliente->nombre_completo}}
                                        </td>
                                        <td class="text-center">{{f_formato($recibo->fecha)}}</td>
                                        <td class="text-center"><p class="underline decoration-sky-600 hover:decoration-blue-400">{{$recibo->cantidad}}</p></td>
                                        <td width=500px;>
                                            <p class="text-sky-600 font-bold italic">{{$recibo->concepto}}</p>
                                        </td>
                                        <td width=150px;>
                                            <div class="flex flex-row items-center h-14">
                                                <div class="px-2">
                                                    <Link href="{{ route('recibo.edit', $recibo->id) }}" class="font-bold text-indigo-500">
                                                        Editar
                                                    </Link>
                                                </div>
                                                <div class="px-2">
                                                    <a target="_blank" href="{{ route('recibo.show', [$recibo->id, 'reporte' => 'pdf']) }}" class="font-bold text-indigo-500">
                                                        <x-icon-file-download color="#114ff1" ancho="24" alto="24"/>
                                                    </a>
                                                </div>
                                                <div class="px-2">
                                                    <a target="_blank" href="{{ route('recibo.show', [$recibo->id, 'reporte' => 'html']) }}" class="font-bold text-indigo-500">
                                                        <x-icon-file color="#7985f1" ancho="24" alto="24"/>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </x-slot>
                    </x-splade-table>
                    <x-splade-table :for="$recibos" as="$recibo" striped auto>
                        <x-splade-cell key>
                            <p class="text-black-500 font-bold"> {{ $key + 1 }}</p>
                        </x-splade-cell>
                        <x-splade-cell concepto>
                            <div class="w-1/2 hover:w-full">
                                <p class="code" style="white-space: pre-line;background:red;">{{$recibo->concepto}}</p>
                            </div>
                        </x-splade-cell>
                        @cell('action', $recibo)
                                <div class="h-full flex">
                                    {{-- <div
                                        class="flex h-full items-center">
                                        <div class="mx-2">
                                            <Link href="/recibo/crear" class="font-bold text-gray-500">
                                                Nueva Institución
                                            </Link>
                                        </div>
                                        <div class=" h-8 w-px bg-gray-300"></div>
                                    </div> --}}
                                    <div class="mx-2">
                                        <Link href="{{ route('recibo.edit', $recibo->id) }}" class="font-bold text-indigo-500">
                                            Editar
                                        </Link>
                                        <a target="_blank" href="{{ route('recibo.show', [$recibo->id, 'reporte' => 'pdf']) }}" class="font-bold text-indigo-500">
                                            <x-icon-file-download color="#114ff1" ancho="24" alto="24"/>
                                        </a>
                                        <a target="_blank" href="{{ route('recibo.show', [$recibo->id, 'reporte' => 'html']) }}" class="font-bold text-indigo-500">
                                            <x-icon-file color="#7985f1" ancho="24" alto="24"/>
                                        </a>
                                    </div>

                                </div>
                        @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
