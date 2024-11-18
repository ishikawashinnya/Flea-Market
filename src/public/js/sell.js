document.getElementById('img').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById('item__img');
    const label = document.querySelector('.img__select-label');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            label.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
        label.classList.remove('hidden');
    }
});