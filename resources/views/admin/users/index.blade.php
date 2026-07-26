<x-admin.layouts.app title="Gestion des administrateurs">
    <x-slot:heading>
        <i class="fa-solid fa-users-gear w-4 text-center"></i> Gestion des administrateurs
    </x-slot:heading>

    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.users.create') }}"
           class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-lg transition
                  flex items-center justify-center gap-2 text-sm font-medium">
            <i class="fa-solid fa-plus"></i> Ajouter un administrateur
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($users as $user)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5
                        {{ $user->id === auth()->id() ? 'ring-2 ring-amani/30' : '' }}">

                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-amani text-white flex items-center justify-center text-lg font-semibold shrink-0">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $user->name }}</p>
                            @if($user->id === auth()->id())
                                <span class="text-xs text-amani font-medium">Vous</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1.5 pt-3 border-t border-gray-100 dark:border-gray-800">
                    <p class="truncate"><i class="fa-solid fa-envelope w-4 text-gray-400 dark:text-gray-500"></i> {{ $user->email }}</p>
                    <p><i class="fa-solid fa-calendar w-4 text-gray-400 dark:text-gray-500"></i> Depuis le {{ $user->created_at->format('d/m/Y') }}</p>
                </div>

            </div>
        @endforeach
    </div>

    @if(count($users) === 0)
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                <i class="fa-solid fa-users-gear text-gray-300 dark:text-gray-600 text-2xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-medium">Aucun administrateur pour le moment</p>
        </div>
    @endif
</x-admin.layouts.app>