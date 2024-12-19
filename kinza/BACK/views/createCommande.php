<?php
require 'C:\xampp\htdocs\Kinza\BACK\config\db.php'; // Connexion à la base de données
require '../controllers/CommandeController.php'; // Inclusion du contrôleur Commande

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
                'reference' => $_POST['reference']
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Commande - GREENGROW</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .form-field { background-color: #004d00; padding: 10px; border-radius: 5px; margin-bottom: 15px; color: white; }
        .form-field label { color: white; }
        .btn-confirm { background-color: #66bb66; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .btn-confirm:hover { background-color: #57a957; }
        .error-message { color: red; font-size: 14px; }
    </style>
</head>
<body class="main-layout">
    <header>
        <div class="header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 logo_section">
                        <div class="logo"><a href="index.html"><img src="assets/images/logo.png" alt="Logo Green Grow"></a></div>
                    </div>
                    <div class="col-md-9">
                        <ul class="location_icon_bottum_tt">
                            <li><img src="assets/icon/loc1.png" alt="location icon"> Ariana, Tunisie</li>
                            <li><img src="assets/icon/email1.png" alt="email icon"> green_grow@gmail.com</li>
                            <li><img src="assets/icon/call1.png" alt="call icon"> (+216) 30 300 300</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="py-5">
        <div class="container">
            <h2>Créer une nouvelle commande</h2>
            <?php
            // Afficher les messages d'erreur si existants
            if (!empty($errorMessages)) {
                echo '<div class="error-message">';
                foreach ($errorMessages as $error) {
                    echo "<p>$error</p>";
                }
                echo '</div>';
            }
            ?>
            <form action="createCommande.php" method="post">
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
                <div class="form-field">
                     <label for="prix_total">Prix Total:</label>
                     <input type="number" step="0.01" name="prix_total" required value="<?= isset($_POST['prix_total']) ? htmlspecialchars($_POST['prix_total']) : '0.00' ?>">
                </div>

                <button type="submit" class="btn-confirm">Ajouter la Commande</button>
                <a href="listCommandes.php" class="btn-confirm" style="background-color: #004d00;">Retour</a>
            </form>
        </div>
    </main>
</body>
</html>
