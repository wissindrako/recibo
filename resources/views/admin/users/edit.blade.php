<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-modal>
                        <x-splade-form method="put" :default="$user" :action="route('user.update', $user)" class="space-y-4">
                            @include("admin.users.form")
                        </x-splade-form>
                    </x-splade-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
