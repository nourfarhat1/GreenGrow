<!-- afficherAnimaux.php -->
<?php
// Inclure la connexion à la base de données et le contrôleur Animal
require_once '../config/database.php';
require_once '../controller/AnimalController.php';

// Initialiser la connexion à la base de données
$db = Database::connect();

// Initialiser le contrôleur Animal
$animalController = new AnimalController($db);

// Vérifier si un terme de recherche a été soumis
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Récupérer les animaux avec un filtre si une recherche est effectuée
if ($searchTerm != '') {
    $animaux = $animalController->getAnimauxByName($searchTerm);
} else {
    $animaux = $animalController->getAllAnimaux();
}

// Vérifier si un commentaire a été soumis
if (isset($_POST['submit_review'])) {
    $animalId = $_POST['animal_id'];
    $commentaire = $_POST['commentaire'];
    $animalController->updateCommentaire($animalId, $commentaire);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les Animaux</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        /* Styles pour le formulaire de recherche */
        form {
            margin-bottom: 20px;
            text-align: center;
        }

        form input[type="text"] {
            padding: 8px;
            width: 250px;
            margin-right: 10px;
        }

        form button {
            padding: 8px 12px;
            background-color: #228B22; /* Vert ferme */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #006400; /* Vert plus foncé */
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            background: url('agriculture.png') no-repeat center center;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button-container button:hover {
            background-color: #006400;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            background-color: #e2f0e2; /* Vert clair */
        }

        .card h2 {
            margin-top: 0;
            color: #228B22;
        }

        .card p {
            margin: 5px 0;
        }

        .card button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #228B22;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .card button:hover {
            background-color: #006400;
        }

        .card form button {
            background-color: red;
        }

        .card form button:hover {
            background-color: darkred;
        }

        .review-form {
            margin-top: 20px;
        }

        .review-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .review-form button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #228B22;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .review-form button:hover {
            background-color: #006400;
        }

    </style>
</head>
<body>

    <!-- Bouton Ajouter un Animal -->
    <div class="button-container">
        <button onclick="window.location.href='ajouterAnimal.php'">Ajouter un Animal</button>
    </div>

    <!-- Formulaire de recherche -->
    <form method="GET" action="">
        <label for="search">Rechercher un animal par nom:</label>
        <input type="text" id="search" name="search" placeholder="Entrez un nom d'animal" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">Rechercher</button>
    </form>

    <!-- Liste des animaux -->
    <h1 style="text-align: center; color: #228B22;">Liste des Animaux</h1>
    <div class="card-container">
        <?php if (!empty($animaux)): ?>
            <?php foreach ($animaux as $animal): ?>
                <div class="card">
                    <h2><?= htmlspecialchars($animal['nom_a']) ?></h2>
                    <p>Âge: <?= htmlspecialchars($animal['age']) ?> <?= htmlspecialchars($animal['age_type']) ?></p>
                    <p>Sexe: <?= htmlspecialchars($animal['sexe']) ?></p>
                    <p>Symptômes: <?= htmlspecialchars($animal['symptomes']) ?></p>
                    <p>Quantité de Nourriture: <?= htmlspecialchars($animal['quantite_n']) ?> kg</p>
                    <p>
                        <?php
                        // Rechercher la catégorie associée à l'ID de catégorie
                        $categorie = $animalController->getCategorieById($animal['categorie_id']);
                        if ($categorie):
                            echo htmlspecialchars($categorie['type']) . " - " . htmlspecialchars($categorie['race']);
                        else:
                            echo "Catégorie inconnue";
                        endif;
                        ?>
                    </p>
                    <!-- Bouton Modifier -->
                    <a href="modifierAnimal.php?nom_a=<?= urlencode($animal['nom_a']) ?>"
                       style="padding: 5px 10px; background-color: #228B22; color: white; border: none; border-radius: 5px; cursor: pointer;">Modifier</a>

                    <!-- Bouton Supprimer -->
                    <form method="POST" action="supprimerAnimal.php" style="display: inline;">
                        <input type="hidden" name="nom_a" value="<?= htmlspecialchars($animal['nom_a']) ?>">
                        <button type="submit" name="delete_animal"
                                style="padding: 5px 10px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?');">
                            Supprimer
                        </button>
                    </form>

                    <!-- Formulaire de commentaire -->
                    <div class="review-form">
                        <form method="POST" action="">
                            <input type="hidden" name="animal_id" value="<?= htmlspecialchars($animal['id']) ?>">
                            <textarea name="commentaire" placeholder="Votre avis..."><?= htmlspecialchars($animal['commentaire']) ?></textarea>
                            <button type="submit" name="submit_review">Soumettre</button>
                        </form>
                    </div>

                    <!-- Afficher le commentaire existant -->
                    <div>
                        <h3>Commentaire:</h3>
                        <?php if (!empty($animal['commentaire'])): ?>
                            <p><?= htmlspecialchars($animal['commentaire']) ?></p>
                        <?php else: ?>
                            <p>Aucun commentaire pour le moment.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun animal trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>
