@props([
    'color' => 'red'
])

@php
    $styles = [
        'red'   => 'text-red-700 bg-red-50 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
        'green' => 'text-green-700 bg-green-50 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800',
        'blue'  => 'text-blue-700 bg-blue-50 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
        'amani' => 'text-amani bg-amani/5 border-amani/20',
    ];

    $classes = $styles[$color] ?? $styles['red'];
@endphp

<div class="js-alert mb-4 text-sm border rounded-lg px-4 py-2 flex items-center justify-between gap-3 {{ $classes }}">
    <span class="flex-1">{{ $slot }}</span>

    <button type="button" class="js-alert-close cursor-pointer shrink-0 w-6 h-6 flex items-center justify-center rounded-full hover:bg-black/5 dark:hover:bg-white/10 transition">
        <i class="fa-solid fa-xmark text-xs"></i>
    </button>
</div>