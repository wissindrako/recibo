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
                    <x-splade-table :for="$recibos" as="$recibo" striped auto>
                        <x-splade-cell key>
                            <p class="text-black-500 font-bold"> {{ $key + 1 }}</p>
                        </x-splade-cell>
                        <x-splade-cell concepto class=" break-words">
                            <div class="break-words">
                                <p class="text-cyan-700 font-bold">{{$recibo->concepto}}</p>
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
