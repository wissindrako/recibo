<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }} — {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Cuenta de usuario --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-slate-700 mb-4">Cuenta</h3>
                <x-splade-form method="put" :default="$user" :action="route('user.update', $user)" class="space-y-4">
                    @include('admin.users.form')
                </x-splade-form>
            </div>

            {{-- Datos personales --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-slate-700 mb-4">Datos personales</h3>

                @if($user->persona)
                    <x-splade-form method="put"
                        :action="route('user.persona.update', $user)"
                        :default="$user->persona"
                        class="space-y-4">
                        @include('admin.users.persona-form')
                    </x-splade-form>
                @else
                    <x-splade-form method="post"
                        :action="route('user.persona.store', $user)"
                        class="space-y-4">
                        @include('admin.users.persona-form')
                    </x-splade-form>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
