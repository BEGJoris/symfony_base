import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ 'select', 'preview' ];

    connect() {
        console.log('2eme controlleur');
    }

    preview(event) {
        const imageUrl= this.selectTarget.options[this.selectTarget.selectedIndex].textContent;
        this.previewTarget.src=imageUrl;
    }
}