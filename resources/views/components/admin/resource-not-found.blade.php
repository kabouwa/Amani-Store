@props([
    'title' => '',
    'description' => '',
    'icon' => '',
])

<div class="col-span-full flex flex-col items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-10 text-center">
    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 mb-3">
        <i class="fa-solid {{ $icon }} text-xl"></i>
    </div>
    <p class="font-semibold text-gray-700 dark:text-gray-200">
        {{ $title }}
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
        {{ $description }}
    </p>
</div>
