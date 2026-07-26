import $ from 'jquery';
import select2 from 'select2';
import 'select2/dist/css/select2.min.css';
import '../css/app.css';
window.$ = $ // Make it from all js files
window.jQuery = $
select2(window, $)

// Theme switcher
$(function () {

    const html = document.documentElement;

    // Apply saved preference on load
    if (localStorage.getItem('theme') === 'dark') {
        html.classList.add('dark');
    }
    updateSwitch();

    $('#themeToggle').on('click', function () {
        html.classList.toggle('dark');
        localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        updateSwitch();
    });

    function updateSwitch() {
        const isDark = html.classList.contains('dark');

        $('#themeSwitch').toggleClass('bg-amani', isDark).toggleClass('bg-gray-200', !isDark);
        $('#themeKnob').toggleClass('translate-x-4', isDark);
        $('#themeIcon').toggleClass('fa-moon', !isDark).toggleClass('fa-sun', isDark);
    }

});


// Utilities
$(function () {
    const showIcon = `<i class="fa-regular fa-eye"></i>`;
    const hideIcon = `<i class="fa-regular fa-eye-slash"></i>`;

    $('.js-toggle-password').each(function () {
        $(this).html(showIcon);
    });

    $('.js-toggle-password').on('click', function () {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        if (!input.length) return;

        const isPassword = input.attr('type') === 'password';
        input.attr('type', isPassword ? 'text' : 'password');
        $(this).html(isPassword ? hideIcon : showIcon);
    });
});

// Preserve scroll
const scroll = sessionStorage.getItem('scrollY');

if (scroll) {
    window.scrollTo(0, scroll);
    sessionStorage.removeItem('scrollY');
}

$('form.save-position').submit(e => {
    e.preventDefault()
    sessionStorage.setItem('scrollY', window.scrollY);
    e.currentTarget.submit()
})

// Alert Close Button Event
$(document).on('click', '.js-alert-close', function () {
    $(this).closest('.js-alert').fadeOut(200, function () {
        $(this).remove();
    });
});
