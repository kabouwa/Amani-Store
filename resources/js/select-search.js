$(function () {
    $('#district_id').select2({
        placeholder: 'Choisir la ville',
        width: '100%',
        // class: 'w-full appearance-none rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-amani focus:border-amani transition cursor-pointer',
        dir: 'ltr',
        language: {
            noResults: function () {
                return 'Aucune ville trouvée';
            },
            searching: function () {
                return 'Recherche en cours...';
            }
        }
    });
});
