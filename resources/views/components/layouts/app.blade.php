@props([
    'title' => 'Admin',
    'heading' => 'Management',
    'headingBtn' => '',
])
<!DOCTYPE html>
<html lang="fr" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Amani Store</title>
    
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-serif">

    <div class="min-h-screen">

        {{-- Fixed header --}}
        <x-layouts.header />

        {{-- Fixed sidebar --}}
        {{-- <x-layouts.footer /> --}}


    </div>

    @stack('scripts')
</body>
</html>
