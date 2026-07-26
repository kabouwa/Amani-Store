<x-admin.layouts.app title="Paramètres du compte">
    <x-slot:heading>
        <i class="fa-solid fa-gear w-4 text-center"></i> Paramètres du compte
    </x-slot:heading>

    @if($errors->any())
        <x-alert>{{ $errors->first() }}</x-alert>
    @endif
    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Profile summary card --}}
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-full bg-amani text-white flex items-center justify-center text-2xl font-semibold mx-auto mb-4">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <p class="font-semibold text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ auth()->user()->email }}</p>

                <div class="pt-4 border-t border-gray-100 dark:border-gray-800 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fa-solid fa-calendar w-4 text-gray-400 dark:text-gray-500"></i>
                    Membre depuis le {{ auth()->user()->created_at->format('d/m/Y') }}
                </div>

                <div class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-800">
                    <button type="button" class="js-delete-btn cursor-pointer w-full flex items-center justify-center gap-2 text-sm text-red-600 dark:text-red-400
                                hover:bg-red-50 dark:hover:bg-red-900/30 px-4 py-2.5 rounded-lg transition"
                            data-action="{{ route('admin.users.destroy' , auth()->user()->slug ) }}"
                            data-modal="deleteAccountModal">
                        <i class="fa-solid fa-trash"></i> Supprimer mon compte
                    </button>
                </div>
            </div>
        </div>

        {{-- Editable forms --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Profile info --}}
            <form action="{{ route('admin.users.update',auth()->user()->slug) }}" method="POST"
                  class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                @csrf
                @method('PUT')

                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                    Informations personnelles
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                               class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                        @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                    <button type="submit"
                            class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-check"></i> Enregistrer
                    </button>
                </div>
            </form>

            {{-- Password change --}}
            {{-- <form action="{{ route('admin.users.password') }}" method="POST" --}}
            <form action="" method="POST"
                  class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
                @csrf
                @method('PUT')

                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                    Changer le mot de passe
                </h2>

                <div class="grid grid-cols-1 gap-5">

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe actuel</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" required
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                            <button type="button" class="js-toggle-password cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-amani"
                                    data-target="current_password">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('current_password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nouveau mot de passe</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                                <button type="button" class="js-toggle-password cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-amani"
                                        data-target="password">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                            </div>
                            @error('password')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmer</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                                <button type="button" class="js-toggle-password cursor-pointer absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-amani"
                                        data-target="password_confirmation">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex justify-end mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                    <button type="submit"
                            class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-key"></i> Mettre à jour le mot de passe
                    </button>
                </div>
            </form>

        </div>

    </div>


    <x-modals.confirm-delete id="deleteAccountModal"
                   title="Supprimer votre compte"
                   message="Cette action est irréversible. Êtes-vous sûr de vouloir supprimer définitivement votre compte administrateur ?" />

</x-admin.layouts.app>