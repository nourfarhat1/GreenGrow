document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form[action='createclient.php']");
    const inputNom = document.getElementById("nom_utilisateur");
    const selectCategorie = document.getElementById("categorie");
    const textareaQuestion = document.getElementById("question");
    const photoInput = document.getElementById("photo");

    // Validation des champs lors de la soumission du formulaire
    form.addEventListener("submit", function (event) {
        let isValid = true;

        // Réinitialiser les messages d'erreur
        clearErrors();

        // Vérification du nom utilisateur
        if (!inputNom.value.trim()) {
            showError(inputNom, "Le nom est obligatoire.");
            isValid = false;
        } else if (!validerNom(inputNom.value.trim())) {
            showError(inputNom, "Le nom doit contenir uniquement des lettres, espaces et accents.");
            isValid = false;
        }

        // Vérification de la catégorie sélectionnée
        if (!selectCategorie.value.trim()) {
            showError(selectCategorie, "Veuillez sélectionner une catégorie.");
            isValid = false;
        }

        // Vérification de la question
        if (!textareaQuestion.value.trim() || textareaQuestion.value.length < 10) {
            showError(textareaQuestion, "La question doit contenir au moins 10 caractères.");
            isValid = false;
        }

        // Vérification du type de fichier pour la photo (optionnelle)
        if (photoInput.files.length > 0) {
            const file = photoInput.files[0];
            const validTypes = ["image/jpeg", "image/png", "image/jpg"];
            if (!validTypes.includes(file.type)) {
                showError(photoInput, "Le fichier doit être une image (JPEG, JPG ou PNG).");
                isValid = false;
            }
        }

        // Annuler la soumission si un champ est invalide
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Fonction pour afficher un message d'erreur
    function showError(input, message) {
        const error = document.createElement("span");
        error.className = "error-message";
        error.textContent = message;
        input.parentNode.appendChild(error);
    }

    // Fonction pour effacer les messages d'erreur
    function clearErrors() {
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach(error => error.remove());
    }

    // Fonction pour afficher dynamiquement le formulaire ou les questions
    window.afficherFormulaire = function () {
        document.getElementById('form-section').style.display = 'block';
        document.getElementById('questions-section').style.display = 'none';
    };

    window.afficherQuestions = function () {
        document.getElementById('form-section').style.display = 'none';
        document.getElementById('questions-section').style.display = 'block';
        chargerQuestions();
    };

    // Charger dynamiquement les questions via fetch
    function chargerQuestions() {
        fetch('createclient.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('questions-section').innerHTML = data;
            })
            .catch(error => console.error('Erreur lors du chargement des questions :', error));
    }

    // Toggle pour afficher/masquer les questions
    const toggleQuestionsButton = document.getElementById("toggleQuestionsButton");
    const questionsSection = document.getElementById("questions-section");

    toggleQuestionsButton.addEventListener("click", function () {
        if (questionsSection.style.display === "none") {
            questionsSection.style.display = "block";
            toggleQuestionsButton.textContent = "Masquer les questions";
        } else {
            questionsSection.style.display = "none";
            toggleQuestionsButton.textContent = "Afficher les questions";
        }
    });

    // Validation du nom utilisateur
    const nomUtilisateurInput = document.getElementById("nom_utilisateur");
    const erreurMessage = document.getElementById("nomErreur");

    // Fonction pour valider le nom (lettres uniquement)
    function validerNom(nom) {
        const regex = /^[A-Za-zÀ-ÿ\s]+$/; // Autorise les lettres, espaces et accents
        return regex.test(nom);
    }
});
