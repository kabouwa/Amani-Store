<x-admin.layouts.app title="Ajouter un produit">
    <x-slot:heading>
        <i class="fa-solid fa-bag-shopping w-4 text-center"></i> Ajouter un produit
    </x-slot:heading>

    @error('title')
        <x-alert>{{ $message }}</x-alert>
    @enderror
    @if(session('success'))
        <x-alert color="green">{{ session('success') }}</x-alert>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST"
          class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                @error('title')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select name="category_id" id="category_id" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 bg-white
                               focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Non Classé</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Purchase price --}}
            <div>
                <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Prix d'achat</label>
                <div class="relative">
                    <input type="number" step="0.01" min="0" name="purchase_price" id="purchase_price"
                           value="{{ old('purchase_price') }}" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 pr-12 text-gray-900
                                  focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 text-sm">DH</span>
                </div>
                @error('purchase_price')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Selling price --}}
            <div>
                <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">Prix de vente</label>
                <div class="relative">
                    <input type="number" step="0.01" min="0" name="selling_price" id="selling_price"
                           value="{{ old('selling_price') }}" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 pr-12 text-gray-900
                                  focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 text-sm">DH</span>
                </div>
                @error('selling_price')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stock --}}
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 0) }}" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
                @error('stock')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Active switch --}}
            <div class="flex flex-col justify-center">
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <label class="inline-flex items-center cursor-pointer gap-3 w-fit">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer
                                peer-checked:bg-amani transition-colors duration-200
                                after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                after:bg-white after:rounded-full after:h-5 after:w-5
                                after:transition-all after:duration-200
                                peer-checked:after:translate-x-5">
                    </div>
                    <span class="text-sm text-gray-600">Produit actif</span>
                </label>
            </div>

            {{-- Description (full width) --}}
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900
                                 focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Submit --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('admin.products.index') }}"
               class="cursor-pointer px-5 py-2.5 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                Annuler
            </a>
            <button type="submit"
                    class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
                <i class="fa-solid fa-check"></i> Enregistrer
            </button>
        </div>

    </form>

</x-admin.layouts.app>
