<?php
require_once 'C:\xampp\htdocs\Kinza\BACK\models\commande.php';

class CommandeController {
    private $conn;

    // Constructor accepts the database connection as an argument
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Méthode pour récupérer toutes les commandes
    // In your CommandeController.php, update the method where you retrieve commandes
    public function getAllCommandes($searchQuery = '', $sortColumn = 'num_c', $sortOrder = 'asc') {
        $sql = "SELECT * FROM commandes WHERE num_c LIKE :search ORDER BY " . $sortColumn . " " . $sortOrder;
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':search', '%' . $searchQuery . '%');  // Match any part of the order number
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function displayCommande() {
        try {
            $commandes = $this->getAllCommandes(); // Récupère toutes les commandes via une méthode existante
            if (empty($commandes)) {
                echo "<p>Aucune commande trouvée.</p>";
            } else {
                echo "<table border='1'>";
                echo "<tr><th>Numéro</th><th>Nom</th><th>Prénom</th><th>Adresse</th><th>Email</th><th>Téléphone</th><th>Livraison</th><th>Référence</th><th>Prix Total</th></tr>";
                foreach ($commandes as $commande) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($commande['num_c']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['nom']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['prenom']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['adresse']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['telephone']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['livraison']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['reference']) . "</td>";
                    echo "<td>" . htmlspecialchars($commande['prix_total']) . " DT</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'affichage des commandes: " . $e->getMessage();
        }
    }
    public function getBestSeller() {
        try {
            $sql = "SELECT reference, COUNT(reference) AS total_commandes, SUM(prix_total) AS total_ventes
                    FROM commandes
                    GROUP BY reference
                    ORDER BY total_commandes DESC
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => 'Erreur lors de la récupération du produit best-seller : ' . $e->getMessage()];
        }
    }
    
    
    
    


    // Méthode pour récupérer les statistiques sur les commandes
    public function getCommandeStats() {
        try {
            $sql = "SELECT COUNT(*) AS total_commandes, SUM(prix_total) AS total_revenue FROM commandes";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des statistiques: " . $e->getMessage();
            return null;
        }
    }

    // Méthode pour récupérer une commande par son ID (num_c)
    public function getCommandeById($num_c) {
        try {
            $sql = "SELECT * FROM commandes WHERE num_c = :num_c";  // Sélectionner une commande par son ID
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':num_c', $num_c, PDO::PARAM_INT);
            $stmt->execute();
            $commande = $stmt->fetch(PDO::FETCH_ASSOC);
            return $commande;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la commande: " . $e->getMessage();
            return null;
        }
    }

    // Méthode pour créer une commande
    public function createCommande($data) {
        $errors = [];

        // Extraire les valeurs du tableau
        $nom = $data['nom'] ?? '';
        $prenom = $data['prenom'] ?? '';
        $adresse = $data['adresse'] ?? '';
        $email = $data['email'] ?? '';
        $telephone = $data['telephone'] ?? '';
        $livraison = $data['livraison'] ?? null;
        $reference = $data['reference'] ?? '';
        $prix_total = $data['prix_total'] ?? ''; 

        // Validation des données
        if (empty($nom)) $errors[] = "Le nom est obligatoire.";
        if (empty($prenom)) $errors[] = "Le prénom est obligatoire.";
        if (empty($adresse)) $errors[] = "L'adresse est obligatoire.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'email est invalide.";
        }
        if (empty($telephone) || !preg_match('/^\d{8}$/', $telephone)) {
            $errors[] = "Le numéro de téléphone doit contenir 8 chiffres.";
        }
        if (strlen($reference) > 20) $errors[] = "La référence ne doit pas dépasser 20 caractères.";
        if (!is_numeric($prix_total) || $prix_total < 0) $errors[] = "Le prix total doit être un nombre positif.";

        // Retourner les erreurs si elles existent
        if (!empty($errors)) {
            return $errors;
        }

        // Appeler le modèle pour créer la commande
        try {
            $sql = "INSERT INTO commandes (nom, prenom, adresse, email, telephone, livraison, reference, prix_total) 
                    VALUES (:nom, :prenom, :adresse, :email, :telephone, :livraison, :reference, :prix_total)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':livraison', $livraison);
            $stmt->bindParam(':reference', $reference);
            $stmt->bindParam(':prix_total', $prix_total, PDO::PARAM_STR);
            $stmt->execute();

            return "Commande créée avec succès!";
        } catch (PDOException $e) {
            echo "Échec de la création de la commande: " . $e->getMessage();
            return "Échec de la création de la commande.";
        }
    }

    // Méthode pour mettre à jour une commande existante
    public function updateCommande($num_c, $commandeData) {
        try {
            $sql = "UPDATE commandes SET 
                        nom = :nom, 
                        prenom = :prenom, 
                        adresse = :adresse, 
                        email = :email, 
                        telephone = :telephone, 
                        livraison = :livraison, 
                        reference = :reference,
                        prix_total = :prix_total
                    WHERE num_c = :num_c";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':num_c', $num_c, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $commandeData['nom']);
            $stmt->bindParam(':prenom', $commandeData['prenom']);
            $stmt->bindParam(':adresse', $commandeData['adresse']);
            $stmt->bindParam(':email', $commandeData['email']);
            $stmt->bindParam(':telephone', $commandeData['telephone']);
            $stmt->bindParam(':livraison', $commandeData['livraison']);
            $stmt->bindParam(':reference', $commandeData['reference']);
            $stmt->bindParam(':prix_total', $commandeData['prix_total'], PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de la commande: " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour supprimer une commande
    public function deleteCommande($num_c) {
        try {
            $sql = "DELETE FROM commandes WHERE num_c = :num_c";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':num_c', $num_c, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la commande: " . $e->getMessage();
            return false;
        }
    }
}
?>
