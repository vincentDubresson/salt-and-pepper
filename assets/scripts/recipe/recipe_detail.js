import $ from 'jquery';
import AlertComponent from '../components/AlertComponent.js';


function updatePlural(plural, number) {
    plural.text(number > 1 ? 's' : '');
}

function updateIngredientQuantities(ingredientRows, servingNumber) {
    ingredientRows.each(function () {
        const $row = $(this);
        const baseQuantity = parseFloat($row.data('quantity')); // Quantité de base depuis data-quantity
        const unit = $row.data('unit'); // Récupérer l'unité depuis l'attribut data-unit
        const pluralizableUnit = $row.data('pluralizable');
        const newQuantity = Math.ceil(baseQuantity * servingNumber); // Mise à jour proportionnelle et arrondi supérieur
        $row.find('.js_recipe_ingredient_quantity').text(newQuantity); // Mise à jour dans le DOM

        if (unit && pluralizableUnit) {
            const unitElement = $row.find('.js_recipe_ingredient_unit');
            unitElement.text(newQuantity > 1 ? unit + 's' : unit);
        }
    });
}

$(document).ready(() => {
    /**
     * Gestion des likes
     */
    const recipeLikeButton = $('.js_recipe_like_icon');
    const recipeUnlikeButton = $('.js_recipe_unlike_icon');

    if (recipeLikeButton && recipeUnlikeButton) {
        $(document).on('click', '.js_recipe_liked_icon, .js_recipe_unliked_icon', function(event) {
            event.preventDefault();
            const clickedButton = $(this);
            clickedButton.prop('disabled', true);

            const isLikeButton = clickedButton.hasClass('js_recipe_unliked_icon');

            const unlikedIcon = $('.js_recipe_unliked_icon');
            const likedIcon = $('.js_recipe_liked_icon');

            const userId = parseInt(clickedButton.data('user'), 10);
            const recipeId = parseInt(clickedButton.data('recipe'), 10);
            const isLikedRecipe = isLikeButton ? 1 : 0;

            $.ajax({
                // eslint-disable-next-line
                url: Routing.generate('sap_recipe_favorites'), // Remplacez par la bonne route
                method: 'POST',
                data: {
                    userId: userId,
                    recipeId: recipeId,
                    isLike: isLikedRecipe
                },
                success: function(response) {
                    if (response === false) {
                        AlertComponent.create('error', 'Impossible de traiter votre demande pour le moment.');
                    } else {
                        AlertComponent.create('success', response);
                    }
                },
                error: function() {
                    AlertComponent.create('error', 'Impossible de traiter votre demande pour le moment.');
                },
                complete: function() {
                    clickedButton.prop('disabled', false);
                    if (isLikedRecipe) {
                        unlikedIcon.addClass('hidden');
                        likedIcon.removeClass('hidden');
                    } else {
                        unlikedIcon.removeClass('hidden');
                        likedIcon.addClass('hidden');
                    }
                }
            });
        });
    }

    /**
     * Gestion des quantités
     */
    const servingNumber = $('.js_recipe_ingredient_serving_number');
    const plural = $('.js_recipe_ingredient_plural');
    const ingredientRows = $('.js_recipe_ingredient_row');


    $('.js_recipe_ingredient_plus_icon').on('click', function () {
        let currentNumber = parseInt(servingNumber.text(), 10);
        // eslint-disable-next-line
        servingNumber.text(++currentNumber);
        updatePlural(plural, currentNumber);
        updateIngredientQuantities(ingredientRows, currentNumber);
    });

    $('.js_recipe_ingredient_minus_icon').on('click', function () {
        let currentNumber = parseInt(servingNumber.text(), 10);
        if (currentNumber > 1) {
            // eslint-disable-next-line
            servingNumber.text(--currentNumber);
            updatePlural(plural, currentNumber);
            updateIngredientQuantities(ingredientRows, currentNumber);
        }
    });
});