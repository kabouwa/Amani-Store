// Phone Sidebar
$(function () {
    $('#toggleSidebar').on('click', function () {
        $('#sidebar').toggleClass('-translate-x-full');
        $('#sidebarOverlay').toggleClass('hidden');
    });
    $('#sidebarOverlay').on('click', function () {
        $('#sidebar').addClass('-translate-x-full');
        $(this).addClass('hidden');
    });
});

// Desktop Sidebar
$(function () {
    $('#toggleSidebarDesktop').on('click', function () {
        const html = document.documentElement;
        html.classList.toggle('sidebar-collapsed');

        const isCollapsed = html.classList.contains('sidebar-collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);

        $('#collapseIcon').toggleClass('fa-bars-staggered', !isCollapsed).toggleClass('fa-bars', isCollapsed);
    });

    // Sync icon on load with whatever the pre-paint script already applied
    if (document.documentElement.classList.contains('sidebar-collapsed')) {
        $('#collapseIcon').removeClass('fa-bars-staggered').addClass('fa-bars');
    }

});


// Delete Modals toggling
$(function () {
    // Delete clicked -> point the matching modal's form at this action, then open it
    $('.js-delete-btn').click(e => {
        const action = $(e.currentTarget).data('action');
        const modalId = $(e.currentTarget).data('modal') || 'deleteModal';
        $('#' + modalId + 'Form').attr('action', action);
        console.log(modalId);

        openModal('#' + modalId);
    });

    // Cancel / overlay click -> close modal
    $('.js-modal-cancel').click(e => {
        closeModal('#' + $(e.currentTarget).closest('[id]').attr('id'));
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
