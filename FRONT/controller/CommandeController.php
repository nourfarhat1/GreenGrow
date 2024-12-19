<?php
// Include necessary files for PDO connection and other dependencies
require_once 'C:\xampp\htdocs\FRONT\model\CommandeModel.php';

class CommandeController {
    private $conn;

    // Constructor accepts the database connection as an argument
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method to get all commandes
    public function getAllCommandes() {
        try {
            $sql = "SELECT * FROM commandes";  // Fetch all commandes
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch results as associative array
            return $commandes;  // Return commandes found
        } catch (PDOException $e) {
            // Error handling: Return explicit error message
            return ['error' => 'Error retrieving commandes: ' . $e->getMessage()];
        }
    }

    // Method to get a commande by its ID
    public function getCommandeById($num_c) {
        try {
            $sql = "SELECT * FROM commandes WHERE num_c = :num_c"; // Select commande by ID
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':num_c', $num_c, PDO::PARAM_INT);
            $stmt->execute();
            $commande = $stmt->fetch(PDO::FETCH_ASSOC);
            return $commande ? $commande : ['error' => 'Commande not found'];  // Return commande or error
        } catch (PDOException $e) {
            return ['error' => 'Error retrieving commande: ' . $e->getMessage()];
        }
    }

    // Method to add a new commande
    public function ajouterCommande($nom, $prenom, $adresse, $email, $telephone, $reference, $livraison ,$prix_total) {
        try {
            $query = "INSERT INTO commandes (nom, prenom, adresse, email, telephone, reference, livraison,prix_total) 
                      VALUES (?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$nom, $prenom, $adresse, $email, $telephone, $reference, $livraison,$prix_total]);
            return $result; // Returns true if insertion is successful
        } catch (PDOException $e) {
            // Return error if insertion fails
            return ['error' => 'Error adding commande: ' . $e->getMessage()];
        }
    }

    // Method to create a new commande (another version of adding a commande)
    public function createCommande($data) {
        try {
            $sql = "INSERT INTO commandes (nom, prenom, adresse, email, telephone, livraison, reference,prix_total) 
                    VALUES (:nom, :prenom, :adresse, :email, :telephone, :livraison, :reference,:prix_total)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nom', $data['nom']);
            $stmt->bindParam(':prenom', $data['prenom']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':telephone', $data['telephone']);
            $stmt->bindParam(':livraison', $data['livraison']);
            $stmt->bindParam(':reference', $data['reference']);
            $stmt->bindParam(':prix_total', $data['prix_total']);
            $stmt->execute();
            return ['success' => 'Commande successfully created']; // Success message
        } catch (PDOException $e) {
            return ['error' => 'Error creating commande: ' . $e->getMessage()];
        }
    }

    // Method to update an existing commande
    public function updateCommande($num_c, $data) {
        try {
            $sql = "UPDATE commandes SET 
                        nom = :nom, 
                        prenom = :prenom, 
                        adresse = :adresse, 
                        email = :email, 
                        telephone = :telephone, 
                        livraison = :livraison, 
                        reference = :reference ,
                        prix_total = :prix_total
                        
                    WHERE num_c = :num_c";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':num_c', $num_c, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $data['nom']);
            $stmt->bindParam(':prenom', $data['prenom']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':telephone', $data['telephone']);
            $stmt->bindParam(':livraison', $data['livraison']);
            $stmt->bindParam(':reference', $data['reference']);
            $stmt->bindParam(':prix_total', $data['prix_total']);
            $stmt->execute();
            return ['success' => 'Commande updated successfully']; // Success message
        } catch (PDOException $e) {
            return ['error' => 'Error updating commande: ' . $e->getMessage()];
        }
    }

    // Method to delete a commande
    public function deleteCommande($num_c) {
        try {
            $sql = "DELETE FROM commandes WHERE num_c = :num_c";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':num_c', $num_c, PDO::PARAM_INT);
            $stmt->execute();
            return ['success' => 'Commande deleted successfully']; // Success message
        } catch (PDOException $e) {
            return ['error' => 'Error deleting commande: ' . $e->getMessage()];
        }
    }
}
?>
