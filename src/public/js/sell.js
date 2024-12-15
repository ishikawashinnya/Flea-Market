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

document.getElementById('category').addEventListener('change', function (event) {
    const categoryId = event.target.value;
    const subcategoryContainer = document.getElementById('subcategory__container');  // 詳細カテゴリーのセレクトボックスが含まれる親要素
    const subcategorySelect = document.getElementById('subcategory');  // サブカテゴリーのセレクトボックス

    // カテゴリーが選択された場合に詳細カテゴリーセレクトボックスを表示
    if (categoryId) {
        subcategoryContainer.style.display = 'block';  // 詳細カテゴリーを表示

        // サブカテゴリーのリセット
        subcategorySelect.innerHTML = '<option value="" disabled selected>詳細カテゴリーを選択</option>';

        // サーバーからサブカテゴリーを取得する処理
        fetch(`/get-subcategories?category_id=${categoryId}`)
            .then(response => response.json())
            .then(data => {
                if (data.subcategories && data.subcategories.length > 0) {
                    data.subcategories.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;  // サブカテゴリーID
                        option.textContent = subcategory.name;  // サブカテゴリー名
                        subcategorySelect.appendChild(option);
                    });
                } else {
                    // サブカテゴリーがなければ選択肢を表示しない
                    subcategoryContainer.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('サブカテゴリーの取得に失敗しました', error);
            });
    } else {
        // カテゴリーが選択されていない場合は詳細カテゴリーセレクトボックスを非表示にする
        subcategoryContainer.style.display = 'none';
    }
});