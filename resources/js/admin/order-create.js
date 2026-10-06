$(function () {

    const products = JSON.parse(document.getElementById('productsData').textContent);
    let articles = {}; // slug -> { title, price, stock, image, quantity }

    // ---- Product search ----
    $('#productSearchInput').on('input', function () {
        const query = $(this).val().toLowerCase().trim();
        const $results = $('#productSearchResults');

        if (!query) {
            $results.addClass('hidden').empty();
            return;
        }

        const matches = products.filter(p => p.title.toLowerCase().includes(query)).slice(0, 8);

        if (!matches.length) {
            $results.html('<p class="text-sm text-gray-400 text-center py-4">Aucun produit trouvé</p>').removeClass('hidden');
            return;
        }

        $results.empty();
        matches.forEach(p => {
            const $item = $(`
                <div class="js-product-result flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                     data-slug="${p.slug}">
                    ${
                        p.image ? `<img src="${p.image}" class="w-10 h-10 rounded-lg object-cover bg-gray-100 dark:bg-gray-800 shrink-0">`
                        : `<div class="h-full flex items-center justify-center text-gray-300 dark:text-gray-600">
                                <i class="fa-solid fa-image text-xl"></i>
                            </div>
                        `
                    }
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">${p.title}</p>
                        <p class="text-xs text-gray-400">${p.price.toFixed(2)} DH — ${p.stock} en stock</p>
                    </div>
                    <p class="ml-auto text-sm text-gray-500">${p.category}</p>
                </div>
            `);
            $results.append($item);
        });

        $results.removeClass('hidden');
    });

    $(document).on('click', '.js-product-result', function () {
        const slug = $(this).data('slug');
        addArticle(slug);
        $('#productSearchInput').val('');
        $('#productSearchResults').addClass('hidden').empty();
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#productSearchWrapper').length) {
            $('#productSearchResults').addClass('hidden');
        }
    });

    // ---- Article management ----
    function addArticle(slug) {
        const product = products.find(p => p.slug === slug);
        if (!product) return;

        if (articles[slug]) {
            if (articles[slug].quantity < product.stock) {
                articles[slug].quantity++;
            }
        } else {
            if (product.stock < 1) return; // out of stock, refuse
            articles[slug] = { ...product, quantity: 1 };
        }

        renderArticles();
    }

    function changeQuantity(slug, delta) {
        const article = articles[slug];
        if (!article) return;

        const newQty = article.quantity + delta;

        if (newQty < 1) {
            delete articles[slug];
        } else if (newQty > article.stock) {
            return; // block exceeding stock
        } else {
            article.quantity = newQty;
        }

        renderArticles();
    }

    function removeArticle(slug) {
        delete articles[slug];
        renderArticles();
    }

    function renderArticles() {
        const $tbody = $('#articlesTableBody');
        const slugs = Object.keys(articles);

        $tbody.empty();
        $('#noArticles').toggleClass('hidden', slugs.length > 0);

        let total = 0;
        let count = 0;

        slugs.forEach(slug => {
            const a = articles[slug];
            const lineTotal = a.price * a.quantity;
            total += lineTotal;
            count += a.quantity;

            const atMaxStock = a.quantity >= a.stock;

            const $row = $(`
                <tr>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="${a.image}" class="w-10 h-10 rounded-lg object-cover bg-gray-100 dark:bg-gray-800 shrink-0">
                            <span class="text-gray-800 dark:text-gray-200 font-medium whitespace-nowrap">${a.title}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" class="js-qty-minus cursor-pointer w-7 h-7 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition" data-slug="${slug}">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>
                            <span class="w-6 text-center font-medium text-gray-800 dark:text-gray-100">${a.quantity}</span>
                            <button type="button" class="js-qty-plus cursor-pointer w-7 h-7 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition disabled:opacity-30 disabled:cursor-not-allowed" data-slug="${slug}" ${atMaxStock ? 'disabled' : ''}>
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                        ${atMaxStock ? '<p class="text-[10px] text-orange-500 text-center mt-1">Stock max atteint</p>' : ''}
                    </td>
                    <td class="px-5 py-3 text-right text-gray-600 dark:text-gray-300 whitespace-nowrap">${a.price.toFixed(2)} DH</td>
                    <td class="px-5 py-3 text-right font-medium text-gray-800 dark:text-gray-100 whitespace-nowrap">${lineTotal.toFixed(2)} DH</td>
                    <td class="px-5 py-3 text-right">
                        <button type="button" class="js-remove-article cursor-pointer w-7 h-7 rounded-full text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition" data-slug="${slug}">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </td>
                </tr>
            `);

            $tbody.append($row);
        });

        $('#summaryCount').text(count);
        $('#summaryTotal').text(total.toFixed(2) + ' DH');

        if (slugs.length > 0) {
            $('#articlesError').addClass('hidden');
        }

        syncHiddenInputs();
    }

    $(document).on('click', '.js-qty-plus', function () { changeQuantity($(this).data('slug'), 1); });
    $(document).on('click', '.js-qty-minus', function () { changeQuantity($(this).data('slug'), -1); });
    $(document).on('click', '.js-remove-article', function () { removeArticle($(this).data('slug')); });

    // ---- Sync hidden inputs so the form actually submits items[i][slug] / items[i][quantity] ----
    function syncHiddenInputs() {
        const $container = $('#itemsContainer');
        $container.empty();

        Object.keys(articles).forEach((slug, index) => {
            $container.append(`<input type="hidden" name="items[${index}][slug]" value="${slug}">`);
            $container.append(`<input type="hidden" name="items[${index}][quantity]" value="${articles[slug].quantity}">`);
        });
    }

    // ---- Client-side validation before submit ----
    $('#orderForm').on('submit', function (e) {
        let valid = true;

        $('.js-error').addClass('hidden').text('');

        const requiredFields = [
            { id: 'name', message: 'Le nom est requis.' },
            { id: 'address', message: "L'adresse est requise." },
            { id: 'district_id', message: 'La ville est requise.' },
        ];

        requiredFields.forEach(field => {
            const $input = $('#' + field.id);
            if (!$input.val() || !$input.val().trim()) {
                $input.next('.js-error').length
                    ? $input.next('.js-error').text(field.message).removeClass('hidden')
                    : $input.closest('div').find('.js-error').text(field.message).removeClass('hidden');
                valid = false;
            }
        });

        // Phone: Moroccan mobile format 06XXXXXXXX (10 digits, starts with 06)
        const phone = $('#phone').val().trim();
        if (!/^0[567]\d{8}$/.test(phone)) {
            $('#phone').next('.js-error').text('Format invalide. Exemple : 0612345678').removeClass('hidden');
            valid = false;
        }

        // At least one article
        if (Object.keys(articles).length === 0) {
            $('#articlesError').removeClass('hidden');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

});
