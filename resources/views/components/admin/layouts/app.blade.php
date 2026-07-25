@props([
    'title' => 'Admin',
    'heading' => 'Management',
    'headingBtn' => ''
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
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>
    @vite(['resources/css/app.css','resources/js/app.js','resources/js/admin/layout.js','resources/css/admin/layout.css'])
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-serif">

    <div class="min-h-screen">

        {{-- Fixed header --}}
        <x-admin.layouts.header />

        {{-- Fixed sidebar --}}
        <x-admin.layouts.aside />

        {{-- Main content --}}
        <main class="py-30 px-4 md:px-16 md:ml-72 min-h-screen transition-all duration-300" id="mainContent">
            <div class="mb-6 flex flex-col lg:flex-row justify-between items-stretch gap-4">
                <h1 class="text-2xl md:text-4xl font-bold text-gray-700 dark:text-gray-100 capitalize">
                    {{ $heading }}
                </h1>
                {{ $headingBtn }}
            </div>
            {{ $slot }}
        </main>

    </div>

    @stack('scripts')
</body>
</html>
