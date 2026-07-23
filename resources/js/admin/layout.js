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