<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Arrendador
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-splade-form action="{{ route('admin.arrendador.store') }}" method="POST">
                    @include('admin.arrendadores.form')
                </x-splade-form>
            </div>
        </div>
    </div>
</x-app-layout>
