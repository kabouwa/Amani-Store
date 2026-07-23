@props([
    'title' => 'Admin',
    'heading' => 'Management'
])
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Amani Store Administration</title>
    <style>
        #sidebar::-webkit-scrollbar {
            width: 4px;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(122, 18, 32, 0.3);
            border-radius: 4px;
        }
    </style>
    @vite(['resources/css/app.css','resources/js/app.js','resources/js/admin/layout.js'])
</head>
<body class="bg-gray-50 font-serif">

    <div class="min-h-screen">

        {{-- Fixed header --}}
        <x-admin.layouts.header></x-admin.layouts.header>

        {{-- Fixed sidebar --}}
        <x-admin.layouts.aside></x-admin.layouts.aside>

        {{-- Main content, offset by header height + aside width --}}
        <main class="pt-30 px-4 md:px-16 md:ml-64 min-h-screen transition-all duration-300" id="mainContent">
            <h1 class="text-4xl font-bold text-gray-700 capitalize mb-6">{{ $heading }}</h1>
            {{ $slot }}
        </main>

    </div>

     @stack('scripts')
</body>
</html>