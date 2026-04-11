<div class="min-h-screen bg-gray-300 dark:bg-gray-700">
    @include('layouts.navigation')

    <!-- Page Heading -->
    <header class="bg-white dark:bg-gray-900 border-b border-transparent dark:border-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
