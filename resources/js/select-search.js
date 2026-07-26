$(function () {
    $('#city').select2({
        placeholder: 'Choisir la ville',
        width: '100%',
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