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

});
