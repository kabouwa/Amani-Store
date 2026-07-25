@props(['status'])

@php
    $styles = [
        'pending'   => 'text-yellow-700 bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-400',
        'confirmed' => 'text-blue-700 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400',
        'shipped'   => 'text-purple-700 bg-purple-50 dark:bg-purple-900/30 dark:text-purple-400',
        'delivered' => 'text-green-700 bg-green-50 dark:bg-green-900/30 dark:text-green-400',
        'cancelled' => 'text-red-700 bg-red-50 dark:bg-red-900/30 dark:text-red-400',
    ];

    $labels = [
        'pending'   => 'En attente',
        'confirmed' => 'Confirmée',
        'shipped'   => 'Expédiée',
        'delivered' => 'Livrée',
        'cancelled' => 'Annulée',
    ];

    $class = $styles[$status] ?? $styles['pending'];
    $label = $labels[$status] ?? $status;
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $class }}">
    {{ $label }}
</span>