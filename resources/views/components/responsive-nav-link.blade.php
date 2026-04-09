@props(['active', 'as' => 'Link'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 focus:outline-none transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out';
@endphp

<{{ $as }} {{ $attributes->class($classes) }}>
    {{ $slot }}
</{{ $as }}>
