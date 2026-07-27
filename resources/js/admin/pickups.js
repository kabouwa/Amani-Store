// resources/js/admin/pickup.js
$(function () {

    function updateCount() {
        const $checkboxes = $('.js-pickup-checkbox');
        const checked = $checkboxes.filter(':checked').length;
        const total = $checkboxes.length;

        $('#selectedCount').text(checked + ' sélectionnée(s)');
        $('#submitCount').text(checked);
        $('#pickupSubmit').prop('disabled', checked === 0);

        const $selectAll = $('#selectAll');
        $selectAll.prop('checked', checked === total && total > 0);
        $selectAll.prop('indeterminate', checked > 0 && checked < total);
    }

    $(document).on('change', '.js-pickup-checkbox', updateCount);

    $('#selectAll').on('change', function () {
        const isChecked = $(this).is(':checked');
        $('.js-pickup-checkbox').prop('checked', isChecked);
        updateCount();
    });

    updateCount();
});