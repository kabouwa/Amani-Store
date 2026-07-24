@props([
    'color' => 'red'
])

@php
    $styles = [
        'red'   => 'text-red-700 bg-red-50 border-red-200',
        'green' => 'text-green-700 bg-green-50 border-green-200',
        'blue'  => 'text-blue-700 bg-blue-50 border-blue-200',
        'amani' => 'text-amani bg-amani/5 border-amani/20',
    ];
    $classes = $styles[$color] ?? $styles['red'];
@endphp
<div class="mb-4 text-sm border rounded-lg px-4 py-2 flex-1 {{ $classes }}">
    {{ $slot }}
</div>