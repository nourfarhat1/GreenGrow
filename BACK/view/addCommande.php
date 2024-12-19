<?php
require_once 'C:\xampp\htdocs\Kinza\FRONT\config\database.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $adresse = trim($_POST['adresse']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $livraison = 'En attente'; // Par défaut
    $reference = uniqid('CMD'); // Générer une référence unique

    // Connexion à la base de données
    $db = Database::connect();

    // Préparer la requête d'insertion
    $stmt = $db->prepare("INSERT INTO commandes (nom, prenom, adresse, email, telephone, livraison, reference) 
                           VALUES (:nom, :prenom, :adresse, :email, :telephone, :livraison, :reference)");

    // Associer les valeurs
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':livraison', $livraison);
    $stmt->bindParam(':reference', $reference);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "<script>alert('Commande ajoutée avec succès!'); window.location.href = 'listeCommande.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'ajout de la commande.'); history.back();</script>";
    }

    // Déconnexion
    Database::disconnect();
}
?>
