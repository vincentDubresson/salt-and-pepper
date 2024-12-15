import $ from 'jquery';
import AlertComponent from '../components/AlertComponent.js';

$(document).ready(() => {
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
                error: function(xhr) {
                    AlertComponent.create('error', 'Impossible de traiter votre demande pour le moment.');
                },
                complete: function() {
                    // Réactiver le bouton après la requête
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
});