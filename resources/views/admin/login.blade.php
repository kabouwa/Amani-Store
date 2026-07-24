<!DOCTYPE html>
<html lang="fr" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Amani Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: radial-gradient(circle at top left, #f9f4f4 0%, #f3eeee 100%);
        }
        .dark body {
            background-image: radial-gradient(circle at top left, #2b1c20 0%, #131417 55%, #0b0c0f 100%);
        }
        input:focus {
            box-shadow: 0 0 0 3px rgba(122, 18, 32, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-950 min-h-screen flex items-center justify-center font-serif transition-colors duration-300">
    <div class="w-full max-w-md px-6">
        {{-- Card --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg dark:shadow-black/30 border border-gray-100 dark:border-gray-800 p-8 transition-colors duration-300">
            <div class="text-center">
                <img src="{{ Vite::asset('resources/images/LOGO/amani-am.png') }}" alt="Amani Store Logo" class="mx-auto h-28 lg:h-36 w-auto">
            </div>

            <h1 class="text-2xl font-bold text-amani text-center mb-1">Espace Administration</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-6">
                Connectez-vous pour gérer Amani Store
            </p>

            {{-- Session error / status --}}
            @if (session('error'))
                <x-alert>{{ session('error') }}</x-alert>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5" novalidate>
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Adresse e-mail
                    </label>

                    <input
                        type="text"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        autofocus
                        required
                        placeholder="vous@exemple.com"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                               focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani
                               transition"
                    >

                    @error('email')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Mot de passe
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            required
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                   focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 dark:text-gray-500 hover:text-amani dark:hover:text-white transition-colors cursor-pointer">
                        </button>
                    </div>

                    @error('password')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-amani hover:bg-amani-dark text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md hover:shadow-amani/30 cursor-pointer">
                    Se connecter
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-6">
            &copy; {{ date('Y') }} Amani Store. Tous droits réservés.
        </p>
    </div>

</body>
</html>