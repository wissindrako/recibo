<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Editar Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <x-splade-form :default="$persona" method="put" :action="route('persona.update', $persona)" class="space-y-4">
                        @include("persona.form")
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
