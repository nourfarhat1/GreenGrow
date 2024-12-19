<?php
require_once '../config/database.php';
require_once '../model/Animal.php';

// Vérifier si la méthode de requête est POST et si 'nom_a' est présent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom_a'])) {
    $nom_a = $_POST['nom_a'];  // Récupérer le nom de l'animal à supprimer

    // Initialiser la connexion à la base de données
    $db = Database::connect();


    // Initialiser l'objet Animal
    $animal = new Animal($db);

    try {
        // Appeler la méthode deleteAnimal pour supprimer l'animal par son nom
        $animal->deleteAnimal($nom_a);

        // Redirection vers la page d'affichage après suppression
        header("Location: afficherAnimaux.php");
        exit;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Nom de l'animal non fourni ou requête invalide.";
}
?>
