import '../css/app.css';
import $ from 'jquery';
window.$ = $ // Make it from all js files
window.jQuery = $


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
    const toggler = $('#togglePassword')    
    if(!toggler) return
    const showIcon = `<i class="fa-regular fa-eye"></i>`
    const hideIcon = `<i class="fa-regular fa-eye-slash"></i>`
    toggler.html(showIcon)
    toggler.click(function () {
        const input = $('#password');
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

