$(function () {

    function updateSelectionState() {
        const $checked = $('.js-order-checkbox:checked');

        const uniqueCodes = [...new Set($checked.map(function () {
            return $(this).val();
        }).get())];

        const count = uniqueCodes.length;

        $('.js-selected-orders-count').text(count);

        if (count > 0) {
            $('#labelsBar').removeClass('hidden').addClass('flex');
        } else {
            $('#labelsBar').addClass('hidden').removeClass('flex');
            $('#printDropdownPanel').addClass('hidden');
        }

        // FIXED: count unique order codes, not raw checkbox elements
        const totalUniqueCodes = [...new Set($('.js-order-checkbox').map(function () {
            return $(this).val();
        }).get())].length;

        $('.js-select-all-orders').prop('checked', count === totalUniqueCodes && totalUniqueCodes > 0);
    }

    function updateCardAppearance($checkbox) {
        const $card = $checkbox.closest('.js-order-card');
        const isChecked = $checkbox.is(':checked');

        if (isChecked) {
            $card
                .removeClass('border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900')
                .addClass('border-amani/60 bg-amani/20 dark:bg-amani/15 backdrop-blur-md shadow-lg shadow-amani/20 scale-[1.01] ring-1 ring-amani/30');
        } else {
            $card
                .removeClass('border-amani/60 bg-amani/20 dark:bg-amani/15 backdrop-blur-md shadow-lg shadow-amani/20 scale-[1.01] ring-1 ring-amani/30')
                .addClass('border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900');
        }
    }

    function syncCheckingBetweenPhoneAndDesktop($changed) {
        const orderCode = $changed.val();
        const isChecked = $changed.is(':checked');

        // Find EVERY checkbox sharing this same order code (could be 1 or 2: table row + mobile card)
        // and force them all to match the one that was actually clicked.
        $('.js-order-checkbox[value="' + orderCode + '"]').prop('checked', isChecked);

        // Now animate every matching card/row (there may be more than one DOM representation)
        $('.js-order-checkbox[value="' + orderCode + '"]').each(function () {
            updateCardAppearance($(this));
        });
    }

    $(document).on('change', '.js-order-checkbox', function () {
        updateCardAppearance($(this));
        syncCheckingBetweenPhoneAndDesktop($(this));
        updateSelectionState();
    });

    $('.js-select-all-orders').on('change', function () {
        const isChecked = $(this).is(':checked');

        $('.js-order-checkbox').prop('checked', isChecked);

        $('.js-order-checkbox').each(function () {
            updateCardAppearance($(this));
        });

        updateSelectionState();
    });

    $('#printDropdownToggle').on('click', function (e) {
        e.stopPropagation();
        $('#printDropdownPanel').toggleClass('hidden');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#printDropdownWrapper').length) {
            $('#printDropdownPanel').addClass('hidden');
        }
    });

    // --- Before either print form submits, inject the selected codes as codes[] ---
    $('.js-print-form').on('submit', function () {
        const $form = $(this);
        const $container = $form.find('.js-codes-container');

        $container.empty();

        // For every currently checked row, add one hidden input named codes[]
        $('.js-order-checkbox:checked').each(function () {
            $container.append(
                `<input type="hidden" name="codes[]" value="${$(this).val()}">`
            );
        });
    });

    updateSelectionState();

});
