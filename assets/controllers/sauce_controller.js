import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ 'selected' ];

    connect() {
        console.log('Sauce controller');
    }

    selectSauce() {
        // Récupère toutes les cases à cocher cochées
        const checkedSauces = Array.from(this.element.querySelectorAll('input[type="checkbox"]:checked'));
        const selectedSauces = checkedSauces.map(checkbox => checkbox.nextElementSibling.textContent.trim());
        // Met à jour le texte avec les sauces sélectionnées
        if (this.hasSelectedTarget) {
            this.selectedTarget.textContent = selectedSauces.length > 0
                ? `Vous avez sélectionné : ${selectedSauces.join(', ')}`
                : 'Sélectionnez une sauce';
        }
    }
}