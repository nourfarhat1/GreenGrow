document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('animalForm');
    form.addEventListener('submit', (e) => {
        const requiredFields = ['nom_a', 'age', 'quantite_n', 'categorie_id', 'sexe'];
        let valid = true;

        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value) {
                valid = false;
                alert(`${field} est obligatoire !`);
            }
        });

        if (!valid) e.preventDefault();
    });
});
