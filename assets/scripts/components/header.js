import $ from 'jquery';

$(document).ready(function () {
    const $headerSearchBarContainer = $('.js_header_search_bar');

    if ($headerSearchBarContainer.length) {
        const $headerSearchButton = $('.js_header_search_button');
        const $headerUserMenuButton = $('.js_header_user_button');
        const $headerUserMenuContainer = $('.js_header_user_menu');
        const $headerRecipeMenuButton = $('.js_header_recipe_button');
        const $headerRecipeMenuContainer = $('.js_header_recipe_menu');

        function toggleRecipeMenuVisibility($recipeMenu, isVisible) {
            if (isVisible) {
                $recipeMenu.addClass('sap-header-nav-recipe-menu-collapse');
            } else {
                $recipeMenu.removeClass('sap-header-nav-recipe-menu-collapse');
            }
        }

        function toggleUserMenuVisibility($userMenu, isVisible) {
            if (isVisible) {
                $userMenu.addClass('sap-header-nav-user-menu-collapse');
            } else {
                $userMenu.removeClass('sap-header-nav-user-menu-collapse');
            }
        }

        function toggleSearchBarVisibility($searchBar, isVisible) {
            if (isVisible) {
                $searchBar.addClass('sap-header-nav-search-bar-collapse');
            } else {
                $searchBar.removeClass('sap-header-nav-search-bar-collapse');
            }
        }

        $headerRecipeMenuButton.on('click', function (e) {
            e.preventDefault();
            const isExpanded = $headerRecipeMenuContainer.attr('aria-expanded') === "false";

            $headerRecipeMenuContainer.attr('aria-expanded', isExpanded ? 'true' : 'false');
            toggleRecipeMenuVisibility($headerRecipeMenuContainer, isExpanded);

            $headerUserMenuContainer.attr('aria-expanded', 'false');
            toggleUserMenuVisibility($headerUserMenuContainer, false);

            $headerSearchBarContainer.attr('aria-expanded', 'false');
            toggleSearchBarVisibility($headerSearchBarContainer, false);
        });

        $headerUserMenuButton.on('click', function (e) {
            e.preventDefault();
            const isExpanded = $headerUserMenuContainer.attr('aria-expanded') === "false";

            $headerUserMenuContainer.attr('aria-expanded', isExpanded ? 'true' : 'false');
            toggleUserMenuVisibility($headerUserMenuContainer, isExpanded);

            $headerRecipeMenuContainer.attr('aria-expanded', 'false');
            toggleRecipeMenuVisibility($headerRecipeMenuContainer, false);

            $headerSearchBarContainer.attr('aria-expanded', 'false');
            toggleSearchBarVisibility($headerSearchBarContainer, false);
        });

        $headerSearchButton.on('click', function (e) {
            e.preventDefault();
            const isExpanded = $headerSearchBarContainer.attr('aria-expanded') === "false";

            $headerSearchBarContainer.attr('aria-expanded', isExpanded ? 'true' : 'false');
            toggleSearchBarVisibility($headerSearchBarContainer, isExpanded);

            $headerUserMenuContainer.attr('aria-expanded', 'false');
            toggleUserMenuVisibility($headerUserMenuContainer, false);

            $headerRecipeMenuContainer.attr('aria-expanded', 'false');
            toggleRecipeMenuVisibility($headerRecipeMenuContainer, false);
        });

        $(document).on('click', function (event) {
            if (
                !$headerSearchButton.is(event.target) &&
                !$headerSearchButton.has(event.target).length &&
                !$headerSearchBarContainer.is(event.target) &&
                !$headerSearchBarContainer.has(event.target).length
            ) {
                $headerSearchBarContainer.attr('aria-expanded', 'false');
                toggleSearchBarVisibility($headerSearchBarContainer, false);
            }

            if (
                !$headerUserMenuButton.is(event.target) &&
                !$headerUserMenuButton.has(event.target).length &&
                !$headerUserMenuContainer.is(event.target) &&
                !$headerUserMenuContainer.has(event.target).length
            ) {
                $headerUserMenuContainer.attr('aria-expanded', 'false');
                toggleUserMenuVisibility($headerUserMenuContainer, false);
            }

            if (
                !$headerRecipeMenuButton.is(event.target) &&
                !$headerRecipeMenuButton.has(event.target).length &&
                !$headerRecipeMenuContainer.is(event.target) &&
                !$headerRecipeMenuContainer.has(event.target).length
            ) {
                $headerRecipeMenuContainer.attr('aria-expanded', 'false');
                toggleRecipeMenuVisibility($headerRecipeMenuContainer, false);
            }
        });
    }
});
