document.addEventListener("DOMContentLoaded", function() {
    const ingredientImportActionButton = document.querySelector('.js_ingredient_import_action');

    ingredientImportActionButton.addEventListener('click', function(e) {
        e.preventDefault();

        const ingredientImportBox = document.querySelector('.js_ingredient_import_box');
        const ingredientImportBoxCloseButton = document.querySelector('.js_ingredient_import_block_close_button');
        const ingredientImportBoxSubmitButton = document.querySelector('.js_ingredient_import_block_submit_button');

        ingredientImportBox.classList.add('display-block');

        ingredientImportBoxSubmitButton.addEventListener('click', function() {
            e.preventDefault();

            const ingredientImportBoxForm = document.querySelector('.js_ingredient_import_box_form');

            ingredientImportBoxSubmitButton.disabled = true;
            ingredientImportBoxCloseButton.disabled = true;

            ingredientImportBoxForm.submit();
        });

        ingredientImportBoxCloseButton.addEventListener('click', function(e) {
            e.preventDefault();

            ingredientImportBox.classList.remove('display-block');
        });
    });
});