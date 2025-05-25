<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 pl-6">
                    <Link href="{{ route('user.create')}}" class="font-bold text-gray-500">
                        Nuevo Usuario (+)
                    </Link>
                </div>
                <div class="p-6 bg-white mx-auto border-b border-gray-200 gap-2">
                    <x-splade-table :for="$users" search-debounce="900">
                        @cell('action', $user)
                        <div class="flex justify-between w-24">
                            <div>
                                <Link href="{{ route('user.edit', $user) }}" class="font-bold text-indigo-500">
                                    <x-icon-edit color="#114ff1" ancho="24" alto="24"/>
                                </Link>
                            </div>
                            <div>
                                <Link href="{{ route('user.email_confirm', $user) }}" confirm class="font-bold text-indigo-500">
                                    <x-icon-chat-check color="#fce343" ancho="24" alto="24"/>
                                </Link>
                            </div>
                            <div>
                                <Link href="{{ route('user.active', $user) }}" confirm class="font-bold text-indigo-500">
                                    <x-icon-double-check color="#0bb005" ancho="24" alto="24"/>
                                </Link>
                            </div>
                        </div>
                        @endcell
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
