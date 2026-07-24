@props([
    'color' => 'red'
])

@php
    $styles = [
        'red'   => 'text-red-700 bg-red-50 border-red-200 dark:text-red-300 dark:bg-red-900/20 dark:border-red-800',
        'green' => 'text-green-700 bg-green-50 border-green-200 dark:text-green-300 dark:bg-green-900/20 dark:border-green-800',
        'blue'  => 'text-blue-700 bg-blue-50 border-blue-200 dark:text-blue-300 dark:bg-blue-900/20 dark:border-blue-800',
        'amani' => 'text-amani bg-amani/5 border-amani/20 dark:text-amani-light dark:bg-amani/10 dark:border-amani/40',
    ];

    $classes = $styles[$color] ?? $styles['red'];
@endphp

<div class="mb-4 text-sm border rounded-lg px-4 py-2 flex-1 {{ $classes }}">
    {{ $slot }}
</div>