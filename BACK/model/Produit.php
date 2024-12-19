<?php
class Produit {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all products
    public function getAllProduits() {
        $stmt = $this->conn->prepare("SELECT * FROM produits ORDER BY nom_prod ASC");
        $stmt->execute();
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ajouter "DT" au moment de l'affichage
        foreach ($produits as &$produit) {
            $produit['prix'] = number_format((float)$produit['prix'], 2) . ' DT';
        }

        return $produits;
    }

    // Create a new product
    public function createProduit($reference, $type_prod, $nom_prod, $fabricant, $prix, $image_name, $image_path) {
        $prix = (float)$prix; // S'assurer que le prix est un float avant l'insertion
        $stmt = $this->conn->prepare("INSERT INTO produits (reference, type_prod, nom_prod, fabricant, prix, image_name, image_path) 
                                      VALUES (:reference, :type_prod, :nom_prod, :fabricant, :prix, :image_name, :image_path)");
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':type_prod', $type_prod);
        $stmt->bindParam(':nom_prod', $nom_prod);
        $stmt->bindParam(':fabricant', $fabricant);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':image_name', $image_name);
        $stmt->bindParam(':image_path', $image_path);
        return $stmt->execute();
    }

    // Fetch a single product by reference
    public function getProduitByReference($reference) {
        $stmt = $this->conn->prepare("SELECT * FROM produits WHERE reference = :reference");
        $stmt->bindParam(':reference', $reference);
        $stmt->execute();
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produit) {
            // Ajouter "DT" au prix
            $produit['prix'] = number_format((float)$produit['prix'], 2) . ' DT';
        }

        return $produit;
    }

    // Update an existing product
    public function updateProduit($reference, $type_prod, $nom_prod, $fabricant, $prix, $image_name, $image_path) {
        $prix = (float)$prix; // S'assurer que le prix est un float avant la mise à jour
        $stmt = $this->conn->prepare("UPDATE produits SET type_prod = :type_prod, nom_prod = :nom_prod, fabricant = :fabricant, 
                                      prix = :prix, image_name = :image_name, image_path = :image_path WHERE reference = :reference");
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':type_prod', $type_prod);
        $stmt->bindParam(':nom_prod', $nom_prod);
        $stmt->bindParam(':fabricant', $fabricant);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':image_name', $image_name);
        $stmt->bindParam(':image_path', $image_path);
        return $stmt->execute();
    }

    // Delete a product
    public function deleteProduit($reference) {
        $stmt = $this->conn->prepare("DELETE FROM produits WHERE reference = :reference");
        $stmt->bindParam(':reference', $reference);
        return $stmt->execute();
    }
}
?>
