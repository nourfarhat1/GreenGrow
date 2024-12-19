
<?php
require 'C:\xampp\htdocs\Kinza\BACK\config\db.php'; // Connexion à la base de données
require '../../controllers/CommandeController.php'; // Inclusion du contrôleur Commande

// Initialiser les messages d'erreur
$errorMessages = [];

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des champs du formulaire
    if (empty($_POST['nom']) || strlen($_POST['nom']) > 20) {
        $errorMessages[] = 'Le nom est requis et ne doit pas dépasser 20 caractères.';
    }
    if (empty($_POST['prenom']) || strlen($_POST['prenom']) > 20) {
        $errorMessages[] = 'Le prénom est requis et ne doit pas dépasser 20 caractères.';
    }
    if (empty($_POST['adresse']) || strlen($_POST['adresse']) > 40) {
        $errorMessages[] = 'L\'adresse est requise et ne doit pas dépasser 40 caractères.';
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = 'L\'email est requis et doit être valide.';
    }
    if (empty($_POST['telephone']) || !is_numeric($_POST['telephone'])) {
        $errorMessages[] = 'Le téléphone est requis et doit être un numéro valide.';
    }
    if (!isset($_POST['livraison']) || !in_array($_POST['livraison'], ['oui', 'non'])) {
        $errorMessages[] = 'Le statut de livraison est invalide.';
    }
    if (empty($_POST['reference']) || strlen($_POST['reference']) > 50) {
        $errorMessages[] = 'La référence est requise et ne doit pas dépasser 50 caractères.';
    }

    // Si aucun message d'erreur, procéder à la création de la commande
    if (empty($errorMessages)) {
        try {
            $controller = new CommandeController($conn);

            // Préparer les données
            $commandeData = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'adresse' => $_POST['adresse'],
                'email' => $_POST['email'],
                'telephone' => $_POST['telephone'],
                'livraison' => $_POST['livraison'],
                'reference' => $_POST['reference'],
                'prix_total' => $_POST['prix_total']
            ];

            // Appeler la méthode pour créer la commande
            $result = $controller->createCommande($commandeData);

            if ($result) {
                // Redirection en cas de succès
                header('Location: listCommandes.php');
                exit();
            } else {
                $errorMessages[] = 'Échec de la création de la commande. Veuillez réessayer.';
            }
        } catch (Exception $e) {
            $errorMessages[] = 'Erreur : ' . $e->getMessage();
        }
    }
}
?>

<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Formulaire pour soumettre les données à CommandeController.php -->
            <form action="CommandeView.php" method="post">
                <div class="form-field">
                    <label for="nom">Nom:</label>
                    <input type="text" name="nom" required maxlength="20" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
                </div>
                <div class="form-field">
                    <label for="prenom">Prénom:</label>
                    <input type="text" name="prenom" required maxlength="20" value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">
                </div>
                <div class="form-field">
                    <label for="adresse">Adresse:</label>
                    <input type="text" name="adresse" required maxlength="40" value="<?= isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : '' ?>">
                </div>
                <div class="form-field">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required maxlength="50" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
                <div class="form-field">
                    <label for="telephone">Téléphone:</label>
                    <input type="number" name="telephone" required value="<?= isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : '' ?>">
                </div>
                <div class="form-field">
                    <label for="livraison">Livraison:</label>
                    <select name="livraison" required>
                        <option value="oui" <?= isset($_POST['livraison']) && $_POST['livraison'] == 'oui' ? 'selected' : '' ?>>Oui</option>
                        <option value="non" <?= isset($_POST['livraison']) && $_POST['livraison'] == 'non' ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>
                <div class="form-field">
                    <label for="reference">Référence:</label>
                    <input type="text" name="reference" required maxlength="50" value="<?= isset($_POST['reference']) ? htmlspecialchars($_POST['reference']) : '' ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>
