document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[type="text"]');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(input);
        });
    });

    form.addEventListener('submit', function(event) {
        let isValid = true;
        inputs.forEach(input => {
            if (!validateInput(input)) {
                isValid = false;
            }
        });
        if (!isValid) {
            event.preventDefault();
        }
    });

    function validateInput(input) {
        const value = input.value.trim();
        const errorSpan = input.nextElementSibling;
        const regexReference = /^r\d+$/;

        if (value === '') {
            errorSpan.textContent = 'Ce champ est obligatoire.';
            return false;
        } else if ((input.id === 'reference_zone' || input.id === 'reference_f') && !regexReference.test(value)) {
            errorSpan.textContent = 'La référence doit commencer par "r" suivi de chiffres.';
            return false;
        } else {
            errorSpan.textContent = '';
            return true;
        }
    }
});
