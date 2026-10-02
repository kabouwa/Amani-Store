// OTP TIMER FORGET
if (sessionStorage.getItem('otp_expiry_time')) {
    sessionStorage.removeItem('otp_expiry_time');
}


// Sidebar icon
function updateSidebarIcon(isOpen) {
    $('.collapseIcon')
        .toggleClass('fa-bars-staggered', isOpen)
        .toggleClass('fa-bars', !isOpen);
}


// Mobile sidebar
$(function () {

    // On mobile, sidebar starts closed
    if (window.innerWidth < 768) {
        $('#sidebar').addClass('-translate-x-full');
        $('#sidebarOverlay').addClass('hidden');
        $('html, body').removeClass('overflow-hidden');

        updateSidebarIcon(false);
    }


    $('#toggleSidebar').on('click', function () {

        $('#sidebar').toggleClass('-translate-x-full');
        $('#sidebarOverlay').toggleClass('hidden');

        const isOpen = !$('#sidebar').hasClass('-translate-x-full');

        $('html, body').toggleClass('overflow-hidden', isOpen);

        updateSidebarIcon(isOpen);
    });


    $('#sidebarOverlay').on('click', function () {

        $('#sidebar').addClass('-translate-x-full');
        $(this).addClass('hidden');

        $('html, body').removeClass('overflow-hidden');

        updateSidebarIcon(false);
    });


    $(window).on('resize', function () {
        if (window.innerWidth < 768) {
            $('#sidebar').addClass('-translate-x-full');
            $('#sidebarOverlay').addClass('hidden');
            $('html, body').removeClass('overflow-hidden');

            updateSidebarIcon(false);
        }
    });

});


// Desktop sidebar
$(function () {

    // Only initialize desktop state on md and above
    if (window.innerWidth >= 768) {

        const isCollapsed =
            document.documentElement.classList.contains('sidebar-collapsed');

        updateSidebarIcon(!isCollapsed);
    }


    $('#toggleSidebarDesktop').on('click', function () {

        const html = document.documentElement;

        html.classList.toggle('sidebar-collapsed');

        const isCollapsed =
            html.classList.contains('sidebar-collapsed');

        localStorage.setItem('sidebarCollapsed', isCollapsed);

        updateSidebarIcon(!isCollapsed);
    });

});
