<div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900 sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        @isset($logo)
            {{ $logo }}
        @else
            <h1 class="text-4xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold uppercase leading-tight tracking-tight">
                <span class="text-yellow-500">Ingreso</span>
            </h1>
        @endisset
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-300 dark:bg-gray-800 text-gray-100 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
