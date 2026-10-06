import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

const imageFiles = [
    'resources/images/gift.png',
    'resources/images/logo/amani-am.png',
    'resources/images/logo/amani-h.png',
    'resources/images/logo/amani.png',
];

const cssFiles = [
    'resources/css/app.css',
    'resources/css/admin/layout.css',
];

const jsFile = [
    // Main
    'resources/js/app.js',
    'resources/js/image-viewer.js',
    'resources/js/select-search.js',
    'resources/js/toolbar.js',

    // Admin
    'resources/js/admin/categories.js',
    'resources/js/admin/layout.js',
    'resources/js/admin/order-create.js',
    'resources/js/admin/order-edit.js',
    'resources/js/admin/order-labels.js',
    'resources/js/admin/otp.js',
    'resources/js/admin/pickups.js',
    'resources/js/admin/product-images.js',
    'resources/js/admin/supplier-form.js',

    // Products
    'resources/js/products/carousel.js',

    // Public
    'resources/js/public/header.js',

    // Validation
    'resources/js/validation/search-validation.js',

    // Admin CSS
    'resources/css/admin/layout.css',
];

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...jsFile,
                ...cssFiles,
                ...imageFiles,

            ],
            refresh: [
                'resources/js/**',
                'resources/css/**',
                'resources/images/**',
            ],
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,

        cors : true,

        hmr: {
            host: '192.168.1.100',
            port: 5173,
        },
    },
});
