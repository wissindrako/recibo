<x-splade-input name="titulo" label="Titulo"/>
<x-splade-input name="nombres" label="Nombre(s)"/>
<x-splade-input name="ap_paterno" label="Apellido paterno"/>
<x-splade-input name="ap_materno" label="Apellido materno"/>

<x-splade-toggle>
    <div class="flex justify-end">
        <div>
            <button @click.prevent="toggle" class="justify-self-end text-sky-500">Mostrar / Ocultar datos opcionales</button>
        </div>
    </div>
    <x-splade-transition show="toggled">
        <x-splade-input name="rude" type="number" min="9999" max="999999999999" label="Rude del estudiante"/>
        <div class="-mx-3 md:flex my-2">
            <div class="md:w-1/3 px-3">
                {{-- <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-city">
                City
                </label> --}}
                <x-splade-input name="ci" type="number" min="9999" max="999999999" label="Cedula de Identidad"/>
            </div>
            <div class="md:w-1/3 px-3">
                <x-splade-input name="complemento" maxlength="4" label="Complemento (Segip)"/>
            </div>
            <div class="md:w-1/3 px-3">
                <x-splade-select name="expedido" label="Expedido en">
                    <option value="LP">LP</option>
                    <option value="SC">SC</option>
                    <option value="CB">CB</option>
                    <option value="OR">OR</option>
                    <option value="PT">PT</option>
                    <option value="BN">BN</option>
                    <option value="PA">PA</option>
                    <option value="TJ">TJ</option>
                    <option value="CH">CH</option>
                </x-splade-select>
            </div>
        </div>
        <div class="-mx-3 md:flex my-2">
            <div class="md:w-1/2 px-3">
                <x-splade-input name="fecha_nacimiento" label="Fecha de Nacimiento" date/>
            </div>
            <div class="md:w-1/2 px-3">
                <x-splade-select name="genero" label="Género">
                    <option value="M">M</option>
                    <option value="F">F</option>
                    <option value="Otro">Otro</option>
                    <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                </x-splade-select>
            </div>
        </div>
        <div class="-mx-3 md:flex mb-2">
            <div class="md:w-1/2 px-3">
                <x-splade-input name="domicilio" label="Domicilio"/>
            </div>
            <div class="md:w-1/2 px-3">
                <x-splade-input name="telefono" min="999999" max="99999999" label="Telefono de contacto" type="number"/>
            </div>
        </div>

    </x-splade-transition>
</x-splade-toggle>
<br>

<x-splade-submit label="Enviar"/>

