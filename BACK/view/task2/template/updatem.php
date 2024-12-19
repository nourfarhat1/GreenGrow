<?php
require 'database.php'; // Inclure le fichier pour la connexion
require_once '../controller/ForumController2.php';

// Vérifier si les données sont présentes dans l'URL
if (isset($_POST['ID_rep'], $_POST['edit_reponse'])) {
    $ID_rep = $_POST['ID_rep'];
    $reponse = trim($_POST['edit_reponse']);

    if (!empty($reponse)) {
        try {
            // Mettre à jour la réponse dans la base de données
            $stmt = $conn->prepare("
                UPDATE message
                SET reponse = :reponse
                WHERE ID_rep = :ID_rep
            ");
            $stmt->execute([
                ':reponse' => $reponse,
                ':ID_rep' => $ID_rep
            ]);

            // Rediriger vers la page du forum
            header("Location: createm.php");
            exit();
        } catch (Exception $e) {
            echo "<p style='color: red;'>Erreur lors de la mise à jour : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Veuillez entrer une réponse.</p>";
    }
} else {
    echo "<p style='color: red;'>Données manquantes pour la mise à jour.</p>";
}
?>
