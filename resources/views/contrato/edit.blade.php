<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Editar Contrato #{{ $contrato->nro_serie }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
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

                {{-- ── Sección de documentos ── --}}
                <div id="archivos" class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">

                    <h3 class="text-base font-bold text-gray-700 dark:text-gray-200 mb-4">
                        📎 Documentos adjuntos
                    </h3>

                    @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-sm">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-4 px-4 py-3 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-sm">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                    @endif

                    {{-- Lista de archivos existentes --}}
                    @php $archivos = (array) ($contrato->archivo ?? []); @endphp

                    @if(count($archivos) > 0)
                    <div class="flex flex-col gap-2 mb-6">
                        @foreach($archivos as $i => $path)
                        @php $isImg = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path); @endphp
                        <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                            <span class="text-xl flex-shrink-0">{{ $isImg ? '🖼' : '📄' }}</span>
                            <a href="{{ asset('storage/' . $path) }}" target="_blank"
                               class="flex-1 text-sm text-indigo-600 dark:text-indigo-400 hover:underline truncate"
                               title="{{ basename($path) }}">
                                {{ basename($path) }}
                            </a>
                            @if($isImg)
                            <a href="{{ asset('storage/' . $path) }}" target="_blank" class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $path) }}" alt=""
                                     class="w-12 h-12 object-cover rounded border border-gray-200 dark:border-gray-600">
                            </a>
                            @endif
                            <x-splade-link
                                href="{{ route('contrato.archivos.delete', [$contrato, $i]) }}"
                                method="DELETE"
                                confirm="¿Eliminar archivo?"
                                confirm-text="{{ basename($path) }}"
                                confirm-button="Sí, eliminar"
                                cancel-button="Cancelar"
                                class="flex-shrink-0 text-xs font-semibold px-3 py-1.5 rounded bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/60 cursor-pointer">
                                Eliminar
                            </x-splade-link>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">No hay documentos adjuntos.</p>
                    @endif

                    {{-- Formulario de subida --}}
                    <form method="POST"
                          action="{{ route('contrato.archivos.upload', $contrato) }}"
                          enctype="multipart/form-data"
                          class="border-2 border-dashed border-indigo-300 dark:border-indigo-700 rounded-xl p-5 bg-indigo-50 dark:bg-indigo-900/20">
                        @csrf
                        <p class="text-sm font-semibold text-indigo-700 dark:text-indigo-300 mb-3">
                            Agregar documentos
                        </p>
                        <div class="flex flex-wrap items-center gap-3">
                            <input type="file" name="archivos[]" multiple required
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp,.gif"
                                   class="text-sm flex-1 min-w-0 dark:text-gray-300">
                            <button type="submit"
                                    class="flex-shrink-0 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg border-0 cursor-pointer">
                                Subir
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                            PDF, Word e imágenes — máx. 50 MB por archivo. Puedes seleccionar varios a la vez.
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
