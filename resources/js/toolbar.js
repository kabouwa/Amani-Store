// Toggle filter and sort dropdowns
$(function () {

    const allPanels = ['#filterPanel', '#sortPanel'];

    function setupDropdown(toggleId, panelId, wrapperId) {
        $(toggleId).on('click', function (e) {
            e.stopPropagation();

            const isHidden = $(panelId).css('display') === 'none';

            // Close every other dropdown first
            allPanels.forEach(function (otherPanel) {
                if (otherPanel !== panelId) {
                    $(otherPanel).fadeOut(200);
                }
            });

            // Then toggle this one
            isHidden ? $(panelId).fadeIn(200) : $(panelId).fadeOut(200);
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest(wrapperId).length) {
                $(panelId).fadeOut(200);
            }
        });

        $(panelId).on('click', function (e) {
            e.stopPropagation();
        });
    }

    setupDropdown('#filterToggle', '#filterPanel', '#filterDropdownWrapper');
    setupDropdown('#sortToggle', '#sortPanel', '#sortDropdownWrapper');

});