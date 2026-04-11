<div class="mb-4">
    <x-splade-input name="nombre" label="Patrimonio" placeholder="Ej: San Pedro N° 20" required/>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <x-splade-input name="patrimonio" label="Tipo de patrimonio"
        placeholder="Ej: Inmueble, Departamento, Local comercial" required/>
    <x-splade-select name="servicios[]" label="Servicios básicos" multiple
        :options="['agua' => 'Agua', 'luz' => 'Luz', 'gas' => 'Gas domiciliario', 'internet' => 'Internet']"/>
</div>

<div class="mb-4">
    <x-splade-textarea name="ubicacion" label="Ubicación" rows="2"
        placeholder="Ej: Av. Mejillones No. 24, ciudad de El Alto" required/>
</div>

<div class="mb-4">
    <x-splade-textarea name="descripcion" label="Descripción para el documento (opcional)" rows="3"
        placeholder="Ej: Inmueble ...."/>
    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500" v-if="form.patrimonio || form.ubicacion">
        Vista previa (clic para copiar a descripción):
        <span
            class="text-indigo-500 dark:text-indigo-400 cursor-pointer hover:underline"
            @click="form.descripcion = (form.patrimonio || 'Inmueble') + ' ubicado en ' + (form.ubicacion || '') + (form.servicios && form.servicios.length ? ' con servicios de ' + form.servicios.join(', ') : '') + '.'">@{{ (form.patrimonio || 'Inmueble') + ' ubicado en ' + (form.ubicacion || '') + (form.servicios && form.servicios.length ? ' con servicios de ' + form.servicios.join(', ') : '') + '' }}</span>
    </p>
</div>

<x-splade-submit label="Guardar"/>
