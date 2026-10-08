$(function () {

    // ---------- Image dropzone: preview + drag & drop ----------
    const $input = $('#image');
    const $dropzone = $('#dropzone');
    const $preview = $('#imagePreview');
    const $placeholder = $('#imagePlaceholder');
    const $overlay = $('#imageOverlay');
    const $imageError = $('#imageError');

    const ALLOWED = ['image/png', 'image/jpeg'];
    const MAX_SIZE = 10 * 1024 * 1024; // 10 MB

    function showImageError(msg) {
        $imageError.text(msg).removeClass('hidden');
    }

    function showPreview(file) {
        $imageError.addClass('hidden').text('');

        if (!ALLOWED.includes(file.type)) {
            showImageError('Format invalide (PNG ou JPG uniquement).');
            $input.val('');
            return;
        }
        if (file.size > MAX_SIZE) {
            showImageError('Image trop lourde (2 Mo maximum).');
            $input.val('');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            $preview.attr('src', event.target.result).removeClass('hidden');
            $placeholder.addClass('hidden');
            $overlay.removeClass('hidden').addClass('flex');
        };
        reader.readAsDataURL(file);
    }

    // Normal click selection
    $input.on('change', function () {
        const file = this.files[0];
        if (file) showPreview(file);
    });

    // Highlight the zone while dragging a file over it
    $dropzone.on('dragenter dragover', function (e) {
        e.preventDefault();
        $dropzone.addClass('border-amani bg-amani/5');
    });

    $dropzone.on('dragleave drop', function (e) {
        e.preventDefault();
        $dropzone.removeClass('border-amani bg-amani/5');
    });

    // Dropped file goes into the real input so it gets submitted with the form
    $dropzone.on('drop', function (e) {
        const files = e.originalEvent.dataTransfer.files;
        if (!files.length) return;
        $input[0].files = files;
        showPreview(files[0]);
    });

    // ---------- Validation before submit ----------
    $('#supplierForm').on('submit', function (e) {
        let valid = true;
        $('.js-error').addClass('hidden').text('');

        const name = $('#name').val().trim();
        if (!name) {
            $('#name').next('.js-error').text('Le nom est requis.').removeClass('hidden');
            valid = false;
        }

        const phone = $('#phone').val().trim();
        if (!/^0[567]\d{8}$/.test(phone)) {
            $('#phone').next('.js-error').text('Format invalide. Exemple : 0612345678').removeClass('hidden');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

});
