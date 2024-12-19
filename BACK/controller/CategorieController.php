<?php

class CategorieController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les catégories
    public function getAllCategories() {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une catégorie
    public function addCategorie($type, $race, $image) {
        $query = "INSERT INTO categories (type, race, image) VALUES (:type, :race, :image)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':race', $race);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    // Récupérer une catégorie par ID
    public function getCategorieById($id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
