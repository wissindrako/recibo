<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Arrendador — {{ $arrendador->nombre_completo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-4 p-3 bg-slate-50 rounded border text-sm">
                    <p><strong>Usuario:</strong> {{ $arrendador->user->name }} — {{ $arrendador->user->email }}</p>
                </div>

                <x-splade-form action="{{ route('admin.arrendador.update', $arrendador->id) }}" method="PUT"
                    :default="['persona_id' => $arrendador->user?->persona?->id]">

                    <x-splade-select name="persona_id" label="Datos personales (Persona)"
                        :options="$personas" option-label="nombre_completo" option-value="id"
                        placeholder="Seleccionar persona..." required/>

                    <div class="mt-6">
                        <x-splade-submit label="Guardar"/>
                    </div>
                </x-splade-form>
            </div>
        </div>
    </div>
</x-app-layout>
