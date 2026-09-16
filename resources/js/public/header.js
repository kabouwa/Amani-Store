// Toggle Search for products
$(function () {
    $('#mobileSearchToggle, #mobileSearchToggleSm').on('click', function () {
        $('#mobileSearchBar').slideToggle(200);
    });
});


// toggle menu on phone
$(function () {

    $('#navCategoriesToggle').on('click', function (e) {
        e.stopPropagation();
        $('#navCategoriesPanel').toggleClass('hidden');
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('#navCategoriesWrapper').length) {
            $('#navCategoriesPanel').addClass('hidden');
        }
    });

    $('#mobileSearchToggle').on('click', function () {
        $('#mobileSearchBar').slideToggle(200);
    });

    $('#mobileMenuToggle').on('click', function () {
        $('#mobileMenu').slideToggle(200);
        $(this).find('i').toggleClass('fa-bars fa-xmark');
    });

});