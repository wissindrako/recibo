<x-splade-select name="user_id" label="Usuario del sistema"
    :options="$usuarios" option-label="name" option-value="id"
    placeholder="Seleccionar usuario..." required/>

<div class="mt-4">
    <x-splade-select name="persona_id" label="Datos personales (Persona)"
        :options="$personas" option-label="nombre_completo" option-value="id"
        placeholder="Seleccionar persona..." required/>
    <p class="text-xs text-slate-400 mt-1">
        Solo aparecen personas sin usuario asignado. Si la persona aún no existe, créala primero en <a href="{{ route('persona.create') }}" class="text-indigo-500">Clientes</a>.
    </p>
</div>

<div class="mt-6">
    <x-splade-submit label="Guardar"/>
</div>
