<?php
// Inclure la connexion à la base de données et les contrôleurs
require_once '../config/database.php';
require_once '../controller/CategorieController.php';
require_once '../controller/AnimalController.php';

// Initialiser la connexion à la base de données
$db = Database::connect();

// Initialiser les contrôleurs
$categorieController = new CategorieController($db);
$animalController = new AnimalController($db);

// Récupérer les catégories existantes
$categories = $categorieController->getAllCategories();

// Vérifier si le formulaire de catégorie a été soumis
if (isset($_POST['add_categorie'])) {
    $type = $_POST['type'];
    $race = $_POST['race'];
    $image = $_FILES['image']['name'];

    // Upload de l'image si elle est fournie
    if (!empty($image)) {
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    } else {
        $image = null; // Aucun fichier téléchargé
    }

    $categorieController->addCategorie($type, $race, $image);

    // Rafraîchir la liste des catégories après ajout
    $categories = $categorieController->getAllCategories();
}

// Vérifier si le formulaire d'animal a été soumis
if (isset($_POST['add_animal'])) {
    $nom_a = $_POST['nom_a'];
    $age = $_POST['age'];
    $age_type = $_POST['age_type'];
    $sexe = $_POST['sexe'];
    $symptomes = $_POST['symptomes'];
    $quantite_n = $_POST['quantite_n'];
    $categorie_id = $_POST['categorie_id'];

    $animalController->addAnimal($nom_a, $age, $age_type, $sexe, $symptomes, $quantite_n, $categorie_id);
    echo "<p style='color: green;'>Animal ajouté avec succès !</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Animal et une Catégorie</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-container {
            margin: 20px 0;
            text-align: center;
            width: 100%;
        }

        .button-container button {
            background: url('agriculture.png') no-repeat center center;
            background-size: cover;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: opacity 0.3s;
        }

        .button-container button:hover {
            opacity: 0.8;
        }

        .form-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin-top: 20px;
        }

        .form-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 48%;
            margin: 10px;
        }

        .form-box h1 {
            color: #228B22;
        }

        .form-box label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        .form-box input, .form-box select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-box button {
            background-color: #228B22;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-box button:hover {
            background-color: #006400;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Bouton Afficher les Animaux -->
    <div class="button-container">
        <button onclick="window.location.href='afficherAnimaux.php'">Afficher les Animaux</button>
    </div>

    <!-- Conteneur pour les formulaires côte à côte -->
    <div class="form-container">
        <!-- Formulaire pour ajouter une catégorie -->
        <div class="form-box">
            <h1>Ajouter une Catégorie</h1>
            <form method="POST" enctype="multipart/form-data" onsubmit="return validateCategorieForm();">
                <label for="type">Type:</label>
                <input type="text" name="type" id="type">

                <label for="race">Race:</label>
                <input type="text" name="race" id="race">

                <label for="image">Image (optionnelle):</label>
                <input type="file" name="image" id="image">

                <button type="submit" name="add_categorie">Ajouter Catégorie</button>
                <div id="categorie-error" class="error"></div>
            </form>
        </div>

        <!-- Formulaire pour ajouter un animal -->
        <div class="form-box">
            <h1>Ajouter un Animal</h1>
            <form method="POST" onsubmit="return validateAnimalForm();">
                <label for="nom_a">Nom de l'Animal:</label>
                <input type="text" name="nom_a" id="nom_a">

                <label for="age">Âge:</label>
                <input type="number" name="age" id="age">

                <label for="age_type">Type d'âge:</label>
                <select id="age_type" name="age_type">
                    <option value="jours">Jours</option>
                    <option value="mois">Mois</option>
                    <option value="années">Années</option>
                </select>

                <label for="sexe">Sexe:</label>
                <select name="sexe" id="sexe">
                    <option value="Mâle">Mâle</option>
                    <option value="Femelle">Femelle</option>
                </select>

                <label for="symptomes">Symptômes (optionnel):</label>
                <input type="text" name="symptomes" id="symptomes">

                <label for="quantite_n">Quantité de nourriture par jour (kg):</label>
                <input type="number" name="quantite_n" id="quantite_n">

                <label for="categorie_id">Catégorie:</label>
                <select name="categorie_id" id="categorie_id">
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['id'] ?>"><?= $categorie['type'] ?> - <?= $categorie['race'] ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="add_animal">Ajouter Animal</button>
                <div id="animal-error" class="error"></div>
            </form>
        </div>
    </div>

    <!-- Validation JavaScript -->
    <script>
        function validateCategorieForm() {
            let type = document.getElementById("type").value;
            let race = document.getElementById("race").value;
            let error = document.getElementById("categorie-error");

            // Réinitialiser l'erreur
            error.innerHTML = "";

            if (type === "" || race === "") {
                error.innerHTML = "Le type et la race sont obligatoires.";
                return false;
            }
            return true;
        }

        function validateAnimalForm() {
            let nom_a = document.getElementById("nom_a").value;
            let age = document.getElementById("age").value;
            let quantite_n = document.getElementById("quantite_n").value;
            let error = document.getElementById("animal-error");

            // Réinitialiser l'erreur
            error.innerHTML = "";

            // Vérification des champs obligatoires
            if (nom_a === "" || age === "" || quantite_n === "") {
                error.innerHTML = "Le nom, l'âge et la quantité de nourriture sont obligatoires.";
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
