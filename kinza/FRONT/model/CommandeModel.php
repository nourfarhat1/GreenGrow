<?php
class Commande {
    private $conn;
    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer une nouvelle commande
    public function createCommande($nom, $prenom, $adresse, $email, $telephone, $livraison, $reference) {
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO commandes (nom, prenom, adresse, email, telephone, livraison, reference) 
                VALUES (:nom, :prenom, :adresse, :email, :telephone, :livraison, :reference)"
            );

            // Liaison des paramètres
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':livraison', $livraison);
            $stmt->bindParam(':reference', $reference);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la commande : " . $e->getMessage();
            return false;
        }
    }

    // Récupérer une commande spécifique par son ID
    public function getCommandeById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM commandes WHERE num_c = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la commande : " . $e->getMessage();
            return false;
        }
    }

    // Mettre à jour une commande existante
    public function updateCommande($id, $nom, $prenom, $adresse, $email, $telephone, $livraison, $reference) {
        try {
            $stmt = $this->conn->prepare(
                "UPDATE commandes 
                SET nom = :nom, prenom = :prenom, adresse = :adresse, email = :email, 
                    telephone = :telephone, livraison = :livraison, reference = :reference 
                WHERE num_c = :id"
            );

            // Liaison des paramètres
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':livraison', $livraison);
            $stmt->bindParam(':reference', $reference);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de la commande : " . $e->getMessage();
            return false;
        }
    }

    // Supprimer une commande
    public function deleteCommande($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM commandes WHERE num_c = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la commande : " . $e->getMessage();
            return false;
        }
    }
}
?>
