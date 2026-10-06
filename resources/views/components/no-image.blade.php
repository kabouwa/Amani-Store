@props([
    'classes' => '',
    'size' => 'text-4xl'
])
<div class="h-full flex items-center justify-center text-gray-300 dark:text-gray-600 {{ $classes }}">
     <i class="fa-solid fa-image {{ $size }}"></i>
</div>
