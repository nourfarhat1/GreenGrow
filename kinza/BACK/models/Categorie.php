<?php

class Categorie
{
    private $db;

    // Le constructeur prend l'objet PDO comme argument
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Méthode pour ajouter une catégorie
    public function addCategorie($type, $race, $image)
    {
        $query = "INSERT INTO categories (type, race, image) VALUES (:type, :race, :image)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':race', $race);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    // Méthode pour récupérer toutes les catégories
    public function getAllCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer une catégorie par son ID
    public function getCategorieById($id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour mettre à jour une catégorie
    public function updateCategorie($id, $type, $race, $image)
    {
        $query = "UPDATE categories SET type = :type, race = :race, image = :image WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':race', $race);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Méthode pour supprimer une catégorie
    public function deleteCategorie($id)
    {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
