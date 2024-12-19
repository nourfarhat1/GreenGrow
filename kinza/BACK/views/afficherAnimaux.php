<?php
// Inclure la connexion à la base de données et les contrôleurs
require_once '../config/database.php';
require_once '../controller/AnimalController.php';
require_once '../controller/CategorieController.php';

// Initialiser la connexion à la base de données
$db = Database::connect();

// Initialiser les contrôleurs
$animalController = new AnimalController($db);
$categorieController = new CategorieController($db);

// Vérifier si un terme de recherche a été soumis
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Récupérer les animaux avec un filtre si une recherche est effectuée
if ($searchTerm != '') {
    $animaux = $animalController->getAnimauxByName($searchTerm);
} else {
    $animaux = $animalController->getAllAnimaux();
}

// Récupérer toutes les catégories
$categories = $categorieController->getAllCategories();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les Animaux</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        /* Styles pour le tableau et le formulaire de recherche */
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #228B22;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
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
        }

        .card h2 {
            margin-top: 0;
            color: #228B22;
        }

        .card p {
            margin: 5px 0;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /* Styles pour le header */
       
    </style>
</head>
<body>
    

   
    <!-- Formulaire de recherche -->
    <form method="GET" action="">
        <label for="search">Rechercher un animal par nom:</label>
        <input type="text" id="search" name="search" placeholder="Entrez un nom d'animal" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">Rechercher</button>
    </form>

    <!-- Liste des animaux -->
    <h1 style="text-align: center; color: #228B22;">Liste des Animaux</h1>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Âge</th> <!-- Afficher Âge et Type dans la même colonne -->
                <th>Sexe</th>
                <th>Symptômes</th>
                <th>Quantité de Nourriture</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($animaux)): ?>
                <?php foreach ($animaux as $animal): ?>
                    <tr>
                        <td><?= htmlspecialchars($animal['nom_a']) ?></td>
                        <td><?= htmlspecialchars($animal['age']) ?> <?= htmlspecialchars($animal['age_type']) ?></td>
                        <td><?= htmlspecialchars($animal['sexe']) ?></td>
                        <td><?= htmlspecialchars($animal['symptomes']) ?></td>
                        <td><?= htmlspecialchars($animal['quantite_n']) ?> kg</td>
                        <td>
                            <?php 
                            // Rechercher la catégorie associée à l'ID de catégorie
                            $categorie = $animalController->getCategorieById($animal['categorie_id']);
                            if ($categorie):
                                echo htmlspecialchars($categorie['type']) . " - " . htmlspecialchars($categorie['race']);
                            else:
                                echo "Catégorie inconnue";
                            endif;
                            ?>
                        </td>
                        <td>
                            <!-- Bouton Modifier -->
                            <a href="modifierAnimal.php?nom_a=<?= urlencode($animal['nom_a']) ?>"
                               style="padding: 5px 10px; background-color: #228B22; color: white; border: none; border-radius: 5px; cursor: pointer;">Modifier</a>

                            <!-- Bouton Supprimer -->
                            <form method="POST" action="supprimerAnimal.php" style="display: inline;">
                                <input type="hidden" name="nom_a" value="<?= htmlspecialchars($animal['nom_a']) ?>">
                                <button type="submit" name="delete_animal" 
                                        style="padding: 5px 10px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer; "
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?');">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Aucun animal trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Liste des catégories -->
    <h1 style="text-align: center; color: #228B22;">Liste des Catégories</h1>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Race</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $categorie): ?>
                    <tr>
                        <td><?= htmlspecialchars($categorie['type']) ?></td>
                        <td><?= htmlspecialchars($categorie['race']) ?></td>
                        <td>
                            <?php if (!empty($categorie['image'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($categorie['image']) ?>" alt="<?= htmlspecialchars($categorie['type']) ?>" style="max-width: 100px; height: auto; border-radius: 5px;">
                            <?php else: ?>
                                Aucune image
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Aucune catégorie trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
