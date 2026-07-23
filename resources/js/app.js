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