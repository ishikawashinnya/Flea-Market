document.addEventListener('DOMContentLoaded', function () {
    const imgInput = document.getElementById("img");
    const previewImg = document.getElementById("profile__img");

    imgInput.addEventListener("change", function () {
        const file = imgInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});