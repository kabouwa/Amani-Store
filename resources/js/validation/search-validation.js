$(() => {
    const searchForm = $('#search-form');
    const searchInput = searchForm.find('[name="search"]');
    const searchButton = searchForm.find('button[type="submit"]');

    function validateSearch() {
        searchButton.prop('disabled', searchInput.val().trim() === '');
    }

    searchInput.on('input', validateSearch);

    validateSearch();
});
