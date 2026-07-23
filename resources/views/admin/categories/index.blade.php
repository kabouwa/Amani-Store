<x-admin.layouts.app title="Gestion des catégories">
    <x-slot:heading>
        <i class="fa-solid fa-tags w-4 text-center"></i> Gestion des catégories
    </x-slot:heading>

    {{-- -Messages --}}
    @error('title')
        <x-alert>{{ $message }}</x-alert>
    @enderror
    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    {{-- Add new category --}}
    <form action="{{ route('admin.categories.store') }}" method="POST" class="flex gap-3 mb-8 w-full md:w-auto md:max-w-md" novalidate>
        @csrf
        <input type="text" name="title" placeholder="Nouvelle catégorie..." required
               class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900
                      focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
        <button type="submit"
                class="bg-amani hover:bg-amani-dark text-white px-4 py-2.5 rounded-lg transition flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Ajouter
        </button>
    </form>
    
    {{-- Category badges --}}
    <div class="gap-3 grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
        @foreach ($categories as $c)
            <div class="category-badge">

                {{-- Display state --}}
                <div class="badge-display flex items-center gap-2 bg-white border border-gray-200 rounded-full
                            px-5 py-2.5 shadow-sm cursor-pointer hover:border-amani hover:shadow-md transition-all duration-200">

                    <span class="text-gray-400">{{ $c->created_at->format('d M') }} | </span>
                    <span class="font-medium text-gray-700">{{ $c->title }}</span>
                </div>

                {{-- Edit state (hidden until badge is clicked) --}}
                <form action={{ route('admin.categories.update', $c->slug) }} method="POST"
                      class="badge-edit hidden items-center gap-1 bg-white border border-amani rounded-full px-3 py-2 shadow-md">
                    @csrf
                    @method('PUT')

                    <input type="text" name="title" value="{{ $c->title }}"
                           class="w-32 bg-transparent border-none focus:outline-none focus:ring-0 text-gray-800 font-medium px-2 w-full">

                    <button type="submit"
                            class="text-green-600 hover:text-green-700 w-8 h-8 flex items-center justify-center rounded-full hover:bg-green-50 transition cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                    </button>

                    <button type="button" class="js-delete-btn text-red-500 hover:text-red-600 w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-50 transition cursor-pointer"
                            data-action={{ route('admin.categories.destory', $c->slug) }}>
                        <i class="fa-solid fa-trash"></i>
                    </button>

                    <button type="button" class="badge-cancel text-gray-400 hover:text-gray-600 w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </form>

            </div>
        @endforeach
    </div>
    <div class="text-gray-400 my-3">
        <p>
            {{ count($categories) }} 
            @choice('catégorie a été trouvée.|catégories ont été trouvées.', count($categories))
        </p>
    </div>

    <x-modals.delete-category id="deleteCategoryModal" message="Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible." />


    @push('scripts')
        @vite('resources/js/admin/categories.js')
    @endpush
</x-admin.layouts.app>