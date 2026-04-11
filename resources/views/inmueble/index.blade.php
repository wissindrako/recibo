<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Inmuebles
            </h2>
            <Link href="{{ route('inmueble.create') }}"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">
                + Nuevo inmueble
            </Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-splade-table :for="$inmuebles">
                    <x-slot name="head">
                        <thead class="bg-slate-200 dark:bg-gray-700">
                            <tr>
                                @foreach($inmuebles->columns() as $column)
                                    <th class="px-4 py-2 text-left border border-gray-200 dark:border-gray-600 dark:text-gray-300">{{ $column->label }}</th>
                                @endforeach
                            </tr>
                        </thead>
                    </x-slot>

                    <x-slot name="body">
                        <tbody>
                            @foreach($inmuebles->resource as $inmueble)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                <td class="px-4 py-3 font-semibold text-gray-800 dark:text-gray-100">{{ $inmueble->nombre }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $inmueble->patrimonio }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($inmueble->ubicacion, 60) }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <Link href="{{ route('inmueble.edit', $inmueble) }}"
                                            class="text-xs px-3 py-1.5 rounded bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200 font-semibold">
                                            Editar
                                        </Link>
                                        <form method="POST" action="{{ route('inmueble.destroy', $inmueble) }}" style="display:inline"
                                              onsubmit="return confirm('¿Eliminar {{ addslashes($inmueble->nombre) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-xs px-3 py-1.5 rounded bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 hover:bg-red-200 font-semibold border-0 cursor-pointer">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </x-slot>
                </x-splade-table>
            </div>
        </div>
    </div>
</x-app-layout>
