@props([
    'href' => '#',
    'active' => false
])

@php
    $baseClasses = 'flex items-center py-3 px-4 rounded-lg transition-colors duration-200';
    $activeClasses = 'bg-blue-700 text-white dark:bg-gray-700 dark:text-blue-300';
    $inactiveClasses = 'text-blue-100 hover:bg-blue-700 hover:text-white dark:text-gray-300 dark:hover:bg-gray-700';
    $classes = $active 
        ? $baseClasses.' '.$activeClasses 
        : $baseClasses.' '.$inactiveClasses;
@endphp

<a 
    href="{{ $href }}" 
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</a>