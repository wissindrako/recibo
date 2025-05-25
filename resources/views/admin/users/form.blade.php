<x-splade-input id="name" type="text" name="name" :label="__('Nombre')" required autofocus />
<x-splade-input id="email" type="email" name="email" :label="__('Email')" required />
 <x-splade-select :label="__('Roles')"
  name="roles[]" 
  :options="$roles" 
  option-label="name"
  option-value="id"
  multiple
  relation
  choices
 /> 

<x-splade-select name="is_active" :label="__('Estado')" required>
    <option value="1">Activo</option>
    <option value="0">Inactivo</option>
</x-splade-select>

<x-splade-input id="password" type="password" name="password" :label="__('Password')" autocomplete="new-password" />

<x-splade-submit/>
