<x-admin.layouts.app title="Ajouter un administrateur">
    <x-slot:heading>
        <i class="fa-solid fa-user-plus w-4 text-center"></i> Ajouter un administrateur
    </x-slot:heading>
        
    <form action="{{ route('admin.users.store') }}" method="POST" novalidate
          class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 max-w-2xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Name --}}
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div class="md:col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Phone --}}
            <div class="md:col-span-2">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Télephone</label>
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="0XXXXXXXXX"
                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                  focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                    <button type="button" class="js-toggle-password cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-amani"
                            data-target="password">
                        <i class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
                @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Password confirmation --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmer le mot de passe</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                  focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                    <button type="button" class="js-toggle-password cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-amani"
                            data-target="password_confirmation">
                        <i class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

        </div>

        <div class="flex flex-col md:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
            <a href="{{ route('admin.users.index') }}"
               class="cursor-pointer px-5 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition hidden md:block">
                Annuler
            </a>
            <button type="submit"
                    class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2 ">
                <i class="fa-solid fa-check"></i> Créer le compte
            </button>
        </div>

    </form>

</x-admin.layouts.app>