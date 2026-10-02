$(function () {

    // Live image preview
    $('#image').on('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const allowed = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!allowed.includes(file.type)) {
            $('#imageError').text('Format invalide. Utilisez PNG ou JPG.').removeClass('hidden');
            $(this).val('');
            return;
        }

        $('#imageError').addClass('hidden');

        const reader = new FileReader();
        reader.onload = function (event) {
            $('#imagePreview').attr('src', event.target.result).removeClass('hidden');
            $('#imagePlaceholderIcon').addClass('hidden');
        };
        reader.readAsDataURL(file);
    });

    // Validation before submit
    $('#supplierForm').on('submit', function (e) {
        let valid = true;
        $('.js-error').addClass('hidden').text('');

        const name = $('#name').val().trim();
        if (!name) {
            $('#name').next('.js-error').text('Le nom est requis.').removeClass('hidden');
            valid = false;
        }

        const phone = $('#phone').val().trim();
        if (!/^06\d{8}$/.test(phone)) {
            $('#phone').next('.js-error').text('Format invalide. Exemple : 0612345678').removeClass('hidden');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

});
