<!DOCTYPE html>
<html lang="fr" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Amani Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/admin/otp.js'])
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

            {{-- Session error / success --}}
            @if (session('error'))
                <x-alert>{{ session('error') }}</x-alert>
            @endif
            @if (session('success'))
                <x-alert color="green">{{ session('success') }}</x-alert>
            @endif
                
            @unless (session('otp-form'))
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5" novalidate>
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Adresse e-mail
                    </label>

                    <input type="text"name="email" id="email" value="{{ old('email') }}" autofocus required placeholder="vous@exemple.com"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                               focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
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
                        <input type="password" name="password" id="password" placeholder="••••••••" required class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500
                                   focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        <button type="button" data-target="password"
                            class="js-toggle-password absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 dark:text-gray-500 hover:text-amani dark:hover:text-white transition-colors cursor-pointer">
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-amani hover:bg-amani-dark text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md hover:shadow-amani/30 cursor-pointer">
                    Se connecter
                </button>
            </form>

            @else

            {{-- OTP-VERIFICATION FORM --}}
            <form method="POST" action="{{ route('admin.login.verification') }}" class="space-y-5" novalidate id="otpForm">
                @csrf

                <input type="hidden" name="otp" id="otp" value="{{ old('otp') }}">

                {{-- Explanation --}}
                <div class="text-center">
                    <div class="w-14 h-14 rounded-full bg-amani/10 text-amani flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-envelope-open-text text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Un code de vérification à 6 chiffres a été envoyé à
                    </p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 mt-0.5">
                        {{ session('otp_email') ?? 'votre adresse e-mail' }}
                    </p>
                </div>

                <div>
                    <div class="flex justify-center gap-2 scale-90 md:scale-100" id="otpInputs">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" inputmode="numeric" maxlength="1" autocomplete="off"
                                class="js-otp-digit w-11 h-12 text-center text-lg font-semibold rounded-lg border border-gray-300 dark:border-gray-700
                                        bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
                                        focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        @endfor
                    </div>
                    @error('otp')
                        <p class="text-xs text-red-600 dark:text-red-400 mt-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Expiry countdown --}}
                <p class="text-center text-sm text-gray-500 dark:text-gray-400" id="otpExpiry">
                    Le code expire dans <span id="otpTimer" class="font-medium text-gray-700 dark:text-gray-200">10:00</span>
                </p>

                <button type="submit" id="otpSubmit" disabled
                        class="w-full bg-amani hover:bg-amani-dark disabled:bg-gray-300 dark:disabled:bg-gray-700 disabled:cursor-not-allowed
                            text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md hover:shadow-amani/30 cursor-pointer">
                    Vérifier
                </button>

                <div class="text-center">
                    <a href="{{ route('admin.login',['reset' => true]) }}" class="cursor-pointer text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Retour à la connexion
                    </a>
                </div>

            </form>

            @endunless
        </div>

        <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-6">
            &copy; {{ date('Y') }} Amani Store. Tous droits réservés.
        </p>
    </div>
</body>
</html>