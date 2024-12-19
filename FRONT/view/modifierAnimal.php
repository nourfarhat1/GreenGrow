<?php
// modifierAnimal.php
// Inclure les fichiers nécessaires
require_once '../config/database.php';
require_once '../model/Animal.php';

// Initialiser la connexion à la base de données
$db = Database::connect();

$animal = new Animal($db);

// Récupérer le nom de l'animal passé dans l'URL
$nom_a = isset($_GET['nom_a']) ? $_GET['nom_a'] : '';

// Si aucun nom d'animal n'est passé, afficher une erreur ou rediriger.
if (empty($nom_a)) {
    die("Nom de l'animal non fourni.");
}

// Récupérer les informations de l'animal depuis la base de données
$animalData = $animal->getAnimalByName($nom_a);

// Si les données de l'animal n'ont pas été trouvées, afficher une erreur.
if (!$animalData) {
    die("Aucun animal trouvé avec ce nom.");
}

// Extraire les données pour pré-remplir le formulaire
$ageData = explode(' ', $animalData['age']); // Exemple : "2 années"
$age = $ageData[0];
$age_type = isset($ageData[1]) ? $ageData[1] : "jours";
$sexe = $animalData['sexe'];
$symptomes = $animalData['symptomes'];
$quantite_n = $animalData['quantite_n'];
$commentaire = $animalData['commentaire'];

// Si le formulaire est soumis, mettre à jour l'animal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_a = $_POST['nom_a'];
    $age = $_POST['age'];
    $age_type = $_POST['age_type'];
    $sexe = $_POST['sexe'];
    $symptomes = $_POST['symptomes'];
    $quantite_n = $_POST['quantite_n'];
    $commentaire = $_POST['commentaire'];
    $original_nom_a = $_POST['original_nom_a'];

    // Mettre à jour l'animal dans la base de données
    $animal->updateAnimal($nom_a, $age, $age_type, $sexe, $symptomes, $quantite_n, $commentaire, $original_nom_a);
    echo "Animal mis à jour avec succès!";

    // Rediriger vers la page d'affichage des animaux
    header("Location: afficherAnimaux.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Animal</title>
    <style>
        /* Stylisation simple */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            margin: auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            text-decoration: none;
            display: inline-block;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }
        a:hover {
            background-color: #d32f2f;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>
<body>
    <h1>Modifier un Animal</h1>
    <div class="container">
        <form method="POST" action="modifierAnimal.php?nom_a=<?= urlencode($nom_a) ?>">
            <input type="hidden" name="original_nom_a" value="<?= htmlspecialchars($nom_a) ?>">

            <label for="nom_a">Nom de l'Animal:</label>
            <input type="text" name="nom_a" id="nom_a" value="<?= htmlspecialchars($nom_a) ?>" required>

            <label for="age">Âge:</label>
            <input type="number" name="age" id="age" value="<?= htmlspecialchars($age) ?>" required>

            <label for="age_type">Unité de l'Âge:</label>
            <select name="age_type" id="age_type" required>
                <option value="jours" <?= ($age_type == 'jours') ? 'selected' : '' ?>>Jours</option>
                <option value="mois" <?= ($age_type == 'mois') ? 'selected' : '' ?>>Mois</option>
                <option value="années" <?= ($age_type == 'années') ? 'selected' : '' ?>>Années</option>
            </select>

            <label for="sexe">Sexe:</label>
            <select name="sexe" id="sexe" required>
                <option value="mâle" <?= ($sexe == 'mâle') ? 'selected' : '' ?>>Mâle</option>
                <option value="femelle" <?= ($sexe == 'femelle') ? 'selected' : '' ?>>Femelle</option>
            </select>

            <label for="symptomes">Symptômes:</label>
            <input type="text" name="symptomes" id="symptomes" value="<?= htmlspecialchars($symptomes) ?>">

            <label for="quantite_n">Quantité de Nourriture (kg):</label>
            <input type="number" name="quantite_n" id="quantite_n" value="<?= htmlspecialchars($quantite_n) ?>" required>

            <label for="commentaire">Commentaire:</label>
            <textarea name="commentaire" id="commentaire"><?= htmlspecialchars($commentaire) ?></textarea>

            <button type="submit" name="modifier">Modifier l'Animal</button>
        </form>
        <a href="afficherAnimaux.php">Retour à la liste des animaux</a>
    </div>
</body>
</html>
