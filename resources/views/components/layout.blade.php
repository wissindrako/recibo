<div class="min-h-screen bg-gray-100 dark:bg-gray-950 dark:text-gray-100">
    <x-navigation />

    <!-- Page Heading -->
    @if(isset($header))
        <header class="bg-white dark:bg-gray-900 shadow dark:shadow-gray-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ $header }}
                </h2>
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="bg-gray-100 dark:bg-gray-950 min-h-screen">
        {{ $slot }}
    </main>
</div>
