<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Nuevo Rol
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-splade-form action="{{ route('rol.store') }}" method="POST"
                        :default="['guard_name' => 'web']"
                        class="space-y-4">
                        <x-splade-input name="name" label="Nombre del rol" placeholder="Ej: arrendador, editor..." required/>
                        <x-splade-input name="guard_name" label="Guard" placeholder="web"/>
                        <x-splade-submit label="Crear rol"/>
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
