<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-modal>
                        <x-splade-form method="post" :action="route('persona.store')" class="space-y-4">
                            @include("persona.form")
                        </x-splade-form>
                    </x-splade-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
