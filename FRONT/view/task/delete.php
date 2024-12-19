<?php
require 'database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_POST['codeF']) && !empty($_POST['codeF'])) {
        $codeF = $_POST['codeF'];  // Identifiant de la question à supprimer

        try {
            $pdo->beginTransaction();

            // Étape 1 : Supprimer les réponses associées
            $stmt = $pdo->prepare("DELETE FROM message WHERE codeF = :codeF");
            $stmt->execute([':codeF' => $codeF]);

            // Étape 2 : Supprimer la question dans la table `forum`
            $stmt = $pdo->prepare("DELETE FROM forum WHERE codeF = :codeF");
            $stmt->execute([':codeF' => $codeF]);

            $pdo->commit();
            header("Location: createclient.php?message=deleted");
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "<p style='color: red;'>Erreur lors de la suppression : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Aucun identifiant de question fourni.</p>";
    }
} else {
    echo "<p style='color: red;'>Requête invalide. Seules les requêtes POST ou GET sont acceptées.</p>";
}
?>
