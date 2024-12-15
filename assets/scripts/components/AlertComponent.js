export default class AlertComponent {
    /**
     * Crée une alerte et l'ajoute au DOM
     * @param {string} type - Le type de l'alerte ('information', 'success', 'caution', 'error')
     * @param {string} message - Le message à afficher
     */
    static create(type, message) {
        // Définition des classes de base
        const baseClasses = 'min-w-[300px] max-w-[500px] p-4 rounded-md shadow-lg fade-in';
        const typeClasses = {
            'success': 'bg-success text-alert-success border border-green-300',
            'error': 'bg-error text-alert-error border border-red-300',
        };

        // Sélection des classes dynamiques basées sur le type
        const alertClasses = `${baseClasses} ${typeClasses[type] || 'bg-error text-white'}`;

        const typeIcones = {
            'success': `<svg width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" class="mr-2 h-5 w-5" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="m9 12l2 2l4-4"></path></g></svg>`,
            'error': `<svg width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" class="mr-2 h-5 w-5" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="m15 9l-6 6m0-6l6 6"></path></g></svg>`,
        };

        // Création de la structure HTML de l'alerte
        const alertElement = document.createElement('div');
        alertElement.className = alertClasses;
        alertElement.setAttribute('role', 'alert');

        // Ajout du contenu interne (icône + message)
        alertElement.innerHTML = `
            <div class="flex items-center font-satoshi-regular text-p sm:text-p-sm md:text-p-md lg:text-p-lg xl:text-p-xl font-semibold">
                ${typeIcones[type]}
                <span>${message}</span>
            </div>
        `;

        // Ajout de l'alerte au conteneur ou au body
        const alertContainer = document.querySelector('.js_alert_container') || document.body;
        alertContainer.appendChild(alertElement);

        setTimeout(() => {
            alertElement.classList.remove('fade-in');
            alertElement.classList.add('fade-out');
        }, 3000);

        alertElement.addEventListener('animationend', (event) => {
            if (event.animationName === "fade-out") {
                alertElement.remove();
            }
        });
    }
}
