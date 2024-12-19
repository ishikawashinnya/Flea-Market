document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.text__search-input');
    const categorySearch = document.getElementById('category__search');

    if (searchInput && categorySearch) {
        searchInput.addEventListener('focus', function () {
            categorySearch.style.display = 'block';
        });

        searchInput.addEventListener('blur', function () {
            setTimeout(() => {
                categorySearch.style.display = 'none';
            }, 200);
        });

        categorySearch.addEventListener('mousedown', function (event) {
            event.preventDefault();
        });
    }
});