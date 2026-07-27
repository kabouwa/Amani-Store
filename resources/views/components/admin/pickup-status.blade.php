@props(['status'])
@php
    $styles = [
        'PENDING'   => 'text-yellow-700 bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-400',
        'SCHEDULED' => 'text-blue-700 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400',
        'TOPICKUP'  => 'text-orange-700 bg-orange-50 dark:bg-orange-900/30 dark:text-orange-400',
        'PICKEDUP'  => 'text-green-700 bg-green-50 dark:bg-green-900/30 dark:text-green-400',
        'WAREHOUSE' => 'text-gray-700 bg-gray-100 dark:bg-gray-800 dark:text-gray-300',
        'CANCELED'           => 'text-red-700 bg-red-50 dark:bg-red-900/30 dark:text-red-400',
    ];

    $labels = [
        'PENDING'   => 'En attente',
        'SCHEDULED' => 'Programmé',
        'TOPICKUP'  => 'Ramassage en cours',
        'PICKEDUP'  => 'Ramassé',
        'WAREHOUSE' => 'Entrepôt',
        'CANCELED'  => 'Annulé',
    ];

    $class = $styles[$status] ?? $styles['PENDING'];
    $label = $labels[$status] ?? $status;
@endphp


<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $class }}">
    {{ $label }}
</span>