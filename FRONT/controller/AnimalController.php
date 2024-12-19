<?php
require_once '../model/Animal.php';

class AnimalController {
    private $db;
    private $animalModel;

    public function __construct($db) {
        $this->db = $db;
        $this->animalModel = new Animal($db);
    }

    // Ajout d'un animal : ajout du paramètre 'age_type' et 'commentaire' dans cette méthode
    public function addAnimal($nom_a, $age, $age_type, $sexe, $symptomes, $quantite_n, $categorie_id, $commentaire = '') {
        // Passer 'age_type' et 'commentaire' en tant que paramètres supplémentaires
        $this->animalModel->addAnimal($nom_a, $age, $age_type, $sexe, $symptomes, $quantite_n, $categorie_id, $commentaire);
    }

    // Récupérer tous les animaux
    public function getAllAnimaux() {
        $query = "SELECT * FROM animaux";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer la catégorie d'un animal par son ID
    public function getCategorieById($id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer les animaux par nom
    public function getAnimauxByName($name) {
        $query = "SELECT * FROM animaux WHERE nom_a LIKE :name";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':name' => '%' . $name . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour le commentaire d'un animal
    public function updateCommentaire($animalId, $commentaire) {
        $query = "UPDATE animaux SET commentaire = :commentaire WHERE id = :animalId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':animalId', $animalId);
        return $stmt->execute();
    }
}
