@props(['supplier', 'action'])

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="supplierForm" novalidate
      class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-6 max-w-4xl mx-auto">
    @csrf
    @if ($supplier->exists)
        @method('PUT')
    @endif

    {{-- Profile image --}}
    <div class="flex flex-col items-center mb-8">
        <div class="relative">
            <div id="imagePreviewWrapper"
                 class="w-28 h-28 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 flex items-center justify-center">

                <img src="{{ $supplier->image ? route('admin.storage.supplier', $supplier) : '' }}"
                     alt="{{ $supplier->name }}"
                     id="imagePreview"
                     class="w-full h-full object-cover {{ $supplier->image ? '' : 'hidden' }}">

                    <div id="imagePlaceholderIcon" class="lex items-center justify-center text-3xl {{ $supplier->image ? 'hidden' : '' }}">
                        <i class="fa-solid fa-user text-gray-300 dark:text-gray-600"></i>
                    </div>
            </div>

            <label for="image"
                   class="cursor-pointer absolute bottom-0 right-0 w-9 h-9 rounded-full bg-amani hover:bg-amani-dark text-white flex items-center justify-center shadow-md transition">
                <i class="fa-solid fa-camera text-sm"></i>
            </label>
            <input type="file" name="image" id="image" accept=".png,.jpg,.jpeg" class="hidden">
        </div>
        <p class="text-xs text-gray-400 mt-2">Photo du fournisseur</p>
        <p class="js-error text-xs text-red-600 mt-1 hidden" id="imageError"></p>
        @error('image')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required maxlength="80"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
            @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Phone --}}
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Téléphone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}" required
                   placeholder="06XXXXXXXX" maxlength="10" inputmode="numeric"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
            <p class="js-error text-xs text-red-600 mt-1 hidden"></p>
            @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Address --}}
        <div class="md:col-span-2">
            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse</label>
            <input type="text" name="address" id="address" value="{{ old('address', $supplier->address) }}"
                   class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                          focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition">
            @error('address')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Note --}}
        <div class="md:col-span-2">
            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Note</label>
            <textarea name="note" id="note" rows="4"
                      class="w-full rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800
                             focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition resize-none">{{ old('note', $supplier->note) }}</textarea>
            @error('note')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

    </div>

    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
        <a href="{{ route('admin.suppliers.index') }}"
           class="cursor-pointer px-5 py-2.5 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            Annuler
        </a>
        <button type="submit"
                class="cursor-pointer bg-amani hover:bg-amani-dark text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
            <i class="fa-solid fa-check"></i> {{ $supplier->exists ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
    </div>

</form>
