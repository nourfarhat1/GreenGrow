<?php
class ProduitController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Modification de la méthode afficherProduits pour accepter un paramètre de recherche
    public function afficherProduits($search = '') {
        // Préparation de la requête avec un filtre de recherche
        if ($search) {
            $sql = "SELECT * FROM produits WHERE nom_prod LIKE :search";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        } else {
            $sql = "SELECT * FROM produits";
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->execute();
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $produits;
    }

    public function incrementLike($reference) {
        $sql = "UPDATE produits SET likes = likes + 1 WHERE reference = :reference";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['reference' => $reference]);
    }

    public function incrementDislike($reference) {
        $sql = "UPDATE produits SET dislikes = dislikes + 1 WHERE reference = :reference";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['reference' => $reference]);
    }
}
?>
