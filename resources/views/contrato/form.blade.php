{{-- Arrendador --}}
<div class="mb-4">
    <x-splade-select name="arrendador_id" label="Propietario / Arrendador"
        :options="$arrendadores" option-label="nombre_completo" option-value="id"
        placeholder="Seleccionar arrendador..." required/>
</div>

<hr class="my-4"/>

{{-- Tipo y persona --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <x-splade-select name="tipo" label="Tipo de contrato"
        :options="['alquiler' => 'Alquiler', 'venta' => 'Venta', 'otro' => 'Otro']" required/>
    <x-splade-select name="persona_id" label="Arrendatario / Contratante"
        :options="$personas" option-label="nombre_completo" option-value="id"
        placeholder="Seleccionar persona..." required/>
</div>

<div class="mb-4">
    <x-splade-select name="inmueble_id" label="Inmueble"
        :options="$inmuebles" option-label="nombre" option-value="id"
        placeholder="Seleccionar inmueble..." required
        @change="form.servicios_contrato = []"/>
</div>

{{-- Servicios del inmueble seleccionado --}}
@php
$serviciosLabels = [
    'agua'          => 'Agua',
    'luz'           => 'Luz eléctrica',
    'gas'           => 'Gas domiciliario',
    'alcantarillado'=> 'Alcantarillado',
    'internet'      => 'Internet',
];
@endphp
@foreach($inmuebles as $inmueble)
    @if(!empty($inmueble->servicios))
    <div v-if="form.inmueble_id == {{ $inmueble->id }}" class="mb-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Servicios incluidos en el contrato:</p>
        <div class="flex flex-wrap gap-4">
            @foreach($inmueble->servicios as $servicio)
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox"
                       v-model="form.servicios_contrato"
                       value="{{ $servicio }}"
                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
                {{ $serviciosLabels[$servicio] ?? $servicio }}
            </label>
            @endforeach
        </div>
    </div>
    @endif
@endforeach
<div class="mb-4">
    <x-splade-textarea name="descripcion_alquiler" label="Lo que se alquila / vende (SEGUNDA cláusula)" rows="2"
        placeholder="Ej: tres cuartos  |  dos piezas (un cuarto y una cocina)"
        required/>
</div>

<hr class="my-4"/>

{{-- Fechas --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <x-splade-input name="fecha_inicio" label="Fecha de inicio" date required/>
    <x-splade-input name="fecha_fin" label="Fecha de fin (dejar vacío si indefinido)" date/>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <x-splade-input name="fecha_documento" label="Fecha del documento (para el contrato impreso)" date/>
    <div></div>
</div>

{{-- Montos --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <x-splade-input name="monto" label="Monto mensual / precio Bs." type="number" min="0" step="0.01" required/>
    <x-splade-input name="garantia" label="Garantía Bs. (solo alquiler)" type="number" min="0" step="0.01"/>
    <x-splade-input name="dia_limite_pago" label="Día límite de pago (solo alquiler)" type="number" min="1" max="31"/>
</div>

<div class="mb-4">
    <x-splade-textarea name="notas" label="Notas / cláusulas adicionales" rows="3"/>
</div>


<x-splade-submit label="Guardar"/>
