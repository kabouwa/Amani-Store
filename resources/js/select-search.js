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

    /*
     * Select 2 Theme css
    */

    // Select2 single selection
    $('.select2-container--default .select2-selection--single').css({
        height: '44px',
        border: '1px solid rgb(209 213 219)',
        borderRadius: '0.5rem',
        display: 'flex',
        alignItems: 'center',
        padding: '0 0.5rem'
    });

    // Rendered text
    $('.select2-container--default .select2-selection--single .select2-selection__rendered').css({
        lineHeight: '44px',
        paddingLeft: '0.5rem'
    });

    // Dropdown
    $('.select2-dropdown').css({
        borderRadius: '0.5rem',
        borderColor: 'rgb(209 213 219)'
    });

    // Focus
    $('.select2-container--default.select2-container--focus .select2-selection--single').css({
        borderColor: '#7A1220'
    });

    // Dark mode
    if ($('html').hasClass('dark')) {

        $('.select2-container--default .select2-selection--single').css({
            backgroundColor: 'rgb(31 41 55)',
            borderColor: 'rgb(55 65 81)'
        });

        $('.select2-container--default .select2-selection--single .select2-selection__rendered').css({
            color: 'rgb(243 244 246)'
        });

        $('.select2-dropdown').css({
            backgroundColor: 'rgb(31 41 55)',
            borderColor: 'rgb(55 65 81)'
        });

        $('.select2-results__option').css({
            color: 'rgb(229 231 235)'
        });

        $('.select2-results__option[aria-selected="true"]').css({
            backgroundColor: 'rgba(122, 18, 32, 0.25)',
            color: 'rgb(243 244 246)'
        });

        $('.select2-search--dropdown .select2-search__field').css({
            backgroundColor: 'rgb(17 24 39)',
            borderColor: 'rgb(55 65 81)',
            color: 'rgb(243 244 246)'
        });
    }

});
