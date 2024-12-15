import $ from 'jquery';

/**
 * Crée une alerte et l'ajoute au DOM
 * @param {string} type - Le type de l'alerte ('information', 'success', 'caution', 'error')
 * @param {string} message - Le message à afficher
 */
function createAlertComponent(type, message) {
    // Définition des classes de base
    const baseClasses = 'min-w-[300px] max-w-[500px] p-4 rounded-md shadow-lg fade-in';
    const typeClasses = {
        'information': 'bg-information text-white',
        'success': 'bg-success text-black',
        'caution': 'bg-caution text-black',
        'error': 'bg-error text-white',
    };

    // Sélection des classes dynamiques basées sur le type
    const alertClasses = `${baseClasses} ${typeClasses[type] || 'bg-error text-white'}`;

    // Création de la structure HTML de l'alerte
    const $alertElement = $('<div></div>', {
        class: alertClasses,
        role: 'alert',
        html: `
            <div class="flex items-center font-satoshi-regular text-p sm:text-p-sm md:text-p-md lg:text-p-lg xl:text-p-xl font-semibold">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${getIconPath(type)}"></path>
                </svg>
                <span>${message}</span>
            </div>
        `
    });

    // Ajout de l'alerte au conteneur ou au body
    const $alertContainer = $('.js_alert_container');
    if ($alertContainer.length) {
        $alertContainer.append($alertElement);
    } else {
        $('body').append($alertElement);
    }

    // Ajoute l'animation de disparition après 4 secondes
    setTimeout(function() {
        $alertElement.removeClass('fade-in').addClass('fade-out');
    }, 3000);

    // Supprime l'alerte une fois l'animation terminée
    $alertElement.on('animationend', function(event) {
        if (event.originalEvent.animationName === "fadeOut") {
            $alertElement.remove();
        }
    });
}

/**
 * Retourne le chemin de l'icône correspondant au type
 * @param {string} type - Le type de l'alerte ('information', 'success', 'caution', 'error')
 * @returns {string} Le chemin SVG de l'icône
 */
function getIconPath(type) {
    const icons = {
        'information': 'M13 16h-1v-4h-1m0-4h.01M12 12h.01M12 6h.01M12 16v.01M12 20a8 8 0 100-16 8 8 0 000 16z',
        'success': 'M9 12l2 2 4-4m2 6a9 9 0 11-6.219-8.854',
        'caution': 'M10 14h4m-2-6h.01M12 18a8.003 8.003 0 11-3.938-6.5A8.003 8.003 0 0112 18z',
        'error': 'M18 6L6 18M6 6l12 12',
    };
    return icons[type] || icons['error'];
}

$(document).ready(function() {
    const alerts = $('.fade-in');

    alerts.each(function() {
        const alert = $(this);

        setTimeout(function() {
            alert.removeClass('fade-in').addClass('fade-out');
        }, 3000);

        alert.on('animationend', function(event) {
            if (event.originalEvent.animationName === "fadeOut") {
                alert.remove();
            }
        });
    });
});