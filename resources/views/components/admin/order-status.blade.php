@props(['status'])
@php
    $styles = [
        'PENDING'         => 'text-yellow-700 bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-400',
        'TO_PREPARE'      => 'text-yellow-700 bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-400',
        'PREPARING'       => 'text-yellow-700 bg-yellow-50 dark:bg-yellow-900/30 dark:text-yellow-400',
        'NEW_DESTINATION' => 'text-orange-700 bg-orange-50 dark:bg-orange-900/30 dark:text-orange-400',
        'TOPICKUP'        => 'text-blue-700 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400',
        'PICKEDUP'        => 'text-blue-700 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400',
        'WAREHOUSE'       => 'text-indigo-700 bg-indigo-50 dark:bg-indigo-900/30 dark:text-indigo-400',
        'TRANSIT'         => 'text-purple-700 bg-purple-50 dark:bg-purple-900/30 dark:text-purple-400',
        'DISTRIBUTED'     => 'text-purple-700 bg-purple-50 dark:bg-purple-900/30 dark:text-purple-400',
        'DELIVERING'      => 'text-purple-700 bg-purple-50 dark:bg-purple-900/30 dark:text-purple-400',
        'UNREACHABLE'     => 'text-gray-700 bg-gray-100 dark:bg-gray-900/30 dark:text-gray-400',
        'POSTPONED'       => 'text-gray-700 bg-gray-100 dark:bg-gray-900/30 dark:text-gray-400',
        'DELIVERED'       => 'text-green-700 bg-green-50 dark:bg-green-900/30 dark:text-green-400',
        'CANCELED'        => 'text-red-700 bg-red-50 dark:bg-red-900/30 dark:text-red-400',
        'REJECTED'        => 'text-red-700 bg-red-50 dark:bg-red-900/30 dark:text-red-400',
    ];

    $labels = [
        'PENDING'         => 'En attente',
        'TO_PREPARE'      => 'À préparer',
        'PREPARING'       => 'En cours de préparation',
        'NEW_DESTINATION' => 'À changer',
        'TOPICKUP'        => 'Ramassage en cours',
        'PICKEDUP'        => 'Ramassé',
        'WAREHOUSE'       => 'Entrepôt',
        'TRANSIT'         => 'En transit',
        'DISTRIBUTED'     => 'Distribué',
        'DELIVERING'      => 'En cours de livraison',
        'UNREACHABLE'     => 'Injoignable',
        'POSTPONED'       => 'Reporté',
        'DELIVERED'       => 'Livré',
        'CANCELED'        => 'Annulé',
        'REJECTED'        => 'Refusé',
    ];

    $key = strtoupper($status ?? 'PREPARING');
    $class = $styles[$key] ?? $styles['PREPARING'];
    $label = $labels[$key] ?? $labels['PREPARING'];
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $class }}">
    {{ $label }}
</span>