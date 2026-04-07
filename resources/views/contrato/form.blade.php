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
    <x-splade-textarea name="descripcion_inmueble" label="Descripción del inmueble (PRIMERA cláusula)" rows="3"
        placeholder="Ej: Inmueble ubicado en la Urbanización San Pedro, Av. Mejillones No. 24 en la ciudad de El Alto, en buen estado de habitabilidad, con servicios básicos (agua, luz y gas domiciliario)."
        required/>
</div>
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

{{-- Montos --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <x-splade-input name="monto" label="Monto mensual / precio Bs." type="number" min="0" step="0.01" required/>
    <x-splade-input name="garantia" label="Garantía Bs. (solo alquiler)" type="number" min="0" step="0.01"/>
    <x-splade-input name="dia_limite_pago" label="Día límite de pago (solo alquiler)" type="number" min="1" max="31"/>
</div>

<div class="mb-4">
    <x-splade-textarea name="notas" label="Notas / cláusulas adicionales" rows="3"/>
</div>

{{-- Archivo adjunto --}}
<div class="mb-4">
    <x-splade-file name="archivo" label="Archivo del contrato (PDF/Word, opcional)" filepond/>
</div>

<x-splade-submit label="Guardar"/>
