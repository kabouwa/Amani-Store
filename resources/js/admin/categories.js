$(function () {

    // Badge clicked -> morph into edit form
    $(document).on('click', '.badge-display', function () {
        const $badge = $(this).closest('.category-badge');
        $(this).fadeOut(150, function () {
            $badge.find('.badge-edit').css('display', 'flex').hide().fadeIn(150);
        });
    });

    // Cancel -> morph back to display badge
    $(document).on('click', '.badge-cancel', function () {
        const $badge = $(this).closest('.category-badge');
        $badge.find('.badge-edit').fadeOut(150, function () {
            $badge.find('.badge-display').fadeIn(150);
        });
    });

    // Delete clicked -> point the shared modal's form at this category, then open it
    $(document).on('click', '.js-delete-btn', function () {
        const action = $(this).data('action');
        $('#deleteCategoryModalForm').attr('action', action);
        openModal('#deleteCategoryModal');
    });

    // Cancel / overlay click -> close modal
    $(document).on('click', '.js-modal-cancel', function () {
        closeModal('#' + $(this).closest('[id]').attr('id'));
    });

});

function openModal(selector) {
    const $modal = $(selector);
    $modal.removeClass('hidden').addClass('flex');
    setTimeout(() => {
        $modal.find('[data-modal-box]').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
    }, 10);
}

function closeModal(selector) {
    const $modal = $(selector);
    $modal.find('[data-modal-box]').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
    setTimeout(() => {
        $modal.removeClass('flex').addClass('hidden');
    }, 200);
}