<?php
require 'C:\xampp\htdocs\BACK\config\config.php';

// Instantiate the Database class and get the connection
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ID_rep = $_POST['ID_rep'] ?? null;
    $codeF = $_POST['codeF'] ?? null;

    if ($ID_rep) {
        $stmt = $conn->prepare("DELETE FROM message WHERE ID_rep = :ID_rep");
        $stmt->execute(['ID_rep' => $ID_rep]);
    }
     elseif ($codeF) {
        // Supprimer une question et toutes ses réponses
        $stmt = $conn->prepare("DELETE FROM forum WHERE codeF = :codeF");
        $stmt->execute(['codeF' => $codeF]);

        $stmt = $conn->prepare("DELETE FROM message WHERE codeF = :codeF");
        $stmt->execute(['codeF' => $codeF]);
    }
    // Rediriger vers la page de la question après la suppression
    header("Location: createm.php?codeF=$codeF");
    exit();
}
?>

