@props([])

<footer class="bg-gray-950 dark:bg-black text-gray-300 mt-16">

    <div class="max-w-7xl mx-auto px-4 md:px-6 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Logo + about --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <img src="{{ Vite::asset('resources/images/logo/amani-h.png') }}" alt="Amani Store" class="w-2/3 lg:w-full mb-4 brightness-0 invert">
                <p class="text-sm text-gray-400 leading-relaxed">
                    Votre boutique en ligne au Maroc — qualité, style et service après-vente disponible 24h/7j.
                </p>
                <div class="flex items-center gap-3 mt-5">
                    <a href="https://wa.me/212612773355" class="w-9 h-9 rounded-full bg-white/5 hover:bg-amani flex items-center justify-center transition">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                    <a href="https://www.instagram.com/amanistore.ma" class="w-9 h-9 rounded-full bg-white/5 hover:bg-amani flex items-center justify-center transition">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                    {{-- <a href="#" class="w-9 h-9 rounded-full bg-white/5 hover:bg-amani flex items-center justify-center transition">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a> --}}
                </div>
            </div>

            {{-- Quick links --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-4">Boutique</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-amani-light transition">Accueil</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-amani-light transition">Toutes les collections</a></li>
                    <li><a href="{{ route('products.index', ['promo' => 1]) }}" class="hover:text-amani-light transition">Promotions</a></li>
                    <li><a href="" class="hover:text-amani-light transition">Mon panier</a></li>
                </ul>
            </div>

            {{-- Info links --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-4">Informations</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="" class="hover:text-amani-light transition">Contact</a></li>
                    <li><a href="" class="hover:text-amani-light transition">À propos</a></li>
                    <li><a href="" class="hover:text-amani-light transition">Livraison &amp; retours</a></li>
                    <li><a href="" class="hover:text-amani-light transition">Questions fréquentes</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-white font-semibold text-sm uppercase tracking-wide mb-4">Contact</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2.5">
                        <i class="fa-brands fa-whatsapp text-green-500"></i>
                        <a href="https://wa.me/212612773355" class="hover:text-amani-light transition">06 12 77 33 55</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fa-solid fa-envelope text-gray-500"></i>
                        <a href="mailto:contact@amanistore.ma" class="hover:text-amani-light transition">contact@amanistore.ma</a>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-location-dot text-gray-500 mt-0.5"></i>
                        <span>Maroc</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fa-solid fa-headset text-gray-500"></i>
                        <span>Service disponible 24h/7j</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-500">
                &copy; {{ date('Y') }} Amani Store. Tous droits réservés.
            </p>

            <div class="flex items-center gap-3 text-gray-500 text-lg">
                <i class="fa-solid fa-money-bill-wave" title="Paiement à la livraison"></i>
            </div>
        </div>
    </div>

</footer>
