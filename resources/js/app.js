import 'bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const flashMessages = document.querySelectorAll('[data-flash-message]');

    flashMessages.forEach((message) => {
        window.setTimeout(() => {
            if (typeof bootstrap === 'undefined') {
                message.remove();
                return;
            }

            const alert = bootstrap.Alert.getOrCreateInstance(message);
            alert.close();
        }, 4000);
    });
});