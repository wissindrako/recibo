<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <x-splade-input name="nombres" label="Nombre(s)" required/>
    <x-splade-input name="ap_paterno" label="Apellido paterno"/>
    <x-splade-input name="ap_materno" label="Apellido materno"/>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <x-splade-select name="titulo" label="Tratamiento">
        <option value="">-</option>
        <option value="Sr.">Sr.</option>
        <option value="Sra.">Sra.</option>
        <option value="Lic.">Lic.</option>
        <option value="Ing.">Ing.</option>
        <option value="Dr.">Dr.</option>
        <option value="Dra.">Dra.</option>
    </x-splade-select>
    <x-splade-select name="genero" label="Género">
        <option value="">-</option>
        <option value="M">M</option>
        <option value="F">F</option>
    </x-splade-select>
</div>

<div class="grid grid-cols-3 gap-4">
    <x-splade-input name="ci" type="number" label="C.I."/>
    <x-splade-input name="complemento" maxlength="4" label="Complemento"/>
    <x-splade-select name="expedido" label="Expedido">
        <option value="">-</option>
        <option value="LP">LP</option>
        <option value="SC">SC</option>
        <option value="CB">CB</option>
        <option value="OR">OR</option>
        <option value="PT">PT</option>
        <option value="BN">BN</option>
        <option value="PA">PA</option>
        <option value="TJ">TJ</option>
        <option value="CH">CH</option>
        <option value="QR">QR</option>
    </x-splade-select>
</div>

<x-splade-input name="domicilio" label="Domicilio"/>
<x-splade-input name="telefono" type="number" label="Teléfono"/>

<x-splade-submit label="Guardar datos personales"/>
