@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center cursor-pointer px-1 pt-1 border-b-2 border-red-400 dark:border-red-600 text-sm font-medium leading-5 text-white focus:outline-none focus:border-red-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center cursor-pointer px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white dark:text-red-400 hover:text-red-100 dark:hover:text-red-300 hover:border-red-500 dark:hover:border-red-700 focus:outline-none focus:text-red-700 dark:focus:text-red-300 focus:border-red-300 dark:focus:red-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
