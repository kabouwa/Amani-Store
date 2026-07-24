import '../css/app.css';
import $ from 'jquery';
window.$ = $ // Make it from all js files
window.jQuery = $


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
