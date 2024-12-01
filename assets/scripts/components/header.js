/*document.addEventListener("DOMContentLoaded", () => {
    const menuButton = document.getElementById("menu-button");
    const dropdownMenu = document.querySelector('[role="menu"]');

    // Toggle menu visibility
    menuButton.addEventListener("click", () => {
        const isExpanded = menuButton.getAttribute("aria-expanded") === "true";

        menuButton.setAttribute("aria-expanded", !isExpanded);
        toggleMenuVisibility(dropdownMenu, !isExpanded);
    });

    // Function to toggle menu visibility with animation
    function toggleMenuVisibility(menu, isVisible) {
        if (isVisible) {
            menu.classList.remove("menu-hidden");
            menu.classList.add("menu-visible", "transition-enter");
            setTimeout(() => menu.classList.remove("transition-enter"), 100); // End of enter transition
        } else {
            menu.classList.add("transition-leave");
            setTimeout(() => {
                menu.classList.remove("menu-visible", "transition-leave");
                menu.classList.add("menu-hidden");
            }, 75); // End of leave transition
        }
    }

    // Close menu on outside click
    document.addEventListener("click", (event) => {
        if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            menuButton.setAttribute("aria-expanded", false);
            toggleMenuVisibility(dropdownMenu, false);
        }
    });
});*/
