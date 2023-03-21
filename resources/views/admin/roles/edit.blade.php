<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>Rol</h1>
                    <x-splade-form :default="$rol" method="put" :action="route('rol.update', $rol)" class="space-y-4">
                        <x-splade-input name="name" label="Nombre"/>
                        <x-splade-input name="guard_name" label="Slug"/>
                        <x-splade-submit/>
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
