// Inputs Handler
$(function () {

    const $digits = $('.js-otp-digit');
    const $hidden = $('#otp');
    const $submit = $('#otpSubmit');

    function syncHiddenField() {
        const value = $digits.map(function () {
            return $(this).val();
        }).get().join('');

        $hidden.val(value);
        $submit.prop('disabled', value.trim().length !== 6);
    }

    $digits.on('input', function () {
        // Keep only the last typed digit, strip non-numeric
        let val = $(this).val().replace(/[^0-9]/g, '').slice(-1);
        $(this).val(val);

        if (val && $(this).next('.js-otp-digit').length) {
            $(this).next('.js-otp-digit').focus();
        }

        syncHiddenField();
    });

    $digits.on('keydown', function (e) {
        if (e.key === 'Backspace' && !$(this).val() && $(this).prev('.js-otp-digit').length) {
            $(this).prev('.js-otp-digit').focus();
        }
    });

    // Paste a full 6-digit code into any box, distribute across all
    $digits.on('paste', function (e) {
        e.preventDefault();
        const pasted = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
        const clean = pasted.replace(/[^0-9]/g, '').slice(0, 6);

        clean.split('').forEach(function (digit, index) {
            $digits.eq(index).val(digit);
        });

        if (clean.length) {
            $digits.eq(Math.min(clean.length, 6) - 1).focus();
        }

        syncHiddenField();
    });

    syncHiddenField(); // initial state (handles old('otp') repopulation edge case)

});

// Timers Handler
$(function () {

    const STORAGE_KEY = 'otp_expiry_time';
    const $timer = $('#otpTimer');
    const $expiryText = $('#otpExpiry');
    // Clear the expiry timestamp if login canceled
    const query = new URLSearchParams(location.search)    
    if(sessionStorage.getItem(STORAGE_KEY) && query.get('reset')) sessionStorage.removeItem(STORAGE_KEY);


    // Get or set the expiry timestamp
    let expiryTime = sessionStorage.getItem(STORAGE_KEY);

    if (!expiryTime) {
        // First time loading this OTP form — set expiry 10 minutes from now
        expiryTime = Date.now() + (10 * 60 * 1000);
        sessionStorage.setItem(STORAGE_KEY, expiryTime);
    } else {
        expiryTime = parseInt(expiryTime, 10);
    }

    const countdown = setInterval(function () {
        const secondsLeft = Math.round((expiryTime - Date.now()) / 1000);

        if (secondsLeft <= 0) {
            clearInterval(countdown);
            expireForm();
            return;
        }

        const minutes = Math.floor(secondsLeft / 60);
        const seconds = secondsLeft % 60;
        $timer.text(minutes + ':' + String(seconds).padStart(2, '0'));
    }, 1000);

    function expireForm() {
        sessionStorage.removeItem(STORAGE_KEY);

        $('.js-otp-digit').prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
        $('#otpSubmit').prop('disabled', true);

        $expiryText
            .removeClass('text-gray-500 dark:text-gray-400')
            .addClass('text-red-600 dark:text-red-400 font-medium')
            .html('<i class="fa-solid fa-clock"></i> Le code a expiré. Veuillez vous reconnecter.');
    }

});