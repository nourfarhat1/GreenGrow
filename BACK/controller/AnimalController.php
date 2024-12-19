<?php
require_once '../model/Animal.php';

class AnimalController {
    private $db;
    private $animalModel;

    public function __construct($db) {
        $this->db = $db;
        $this->animalModel = new Animal($db);
    }

    // Ajout d'un animal : ajout du paramètre 'age_type' dans cette méthode
    public function addAnimal($nom_a, $age, $age_type, $sexe, $symptomes, $quantite_n, $categorie_id) {
        // Passer 'age_type' en tant que paramètre supplémentaire
        $this->animalModel->addAnimal($nom_a, $age, $age_type, $sexe, $symptomes, $quantite_n, $categorie_id);
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
    // Dans AnimalController.php
public function getAnimauxByName($name) {
    $query = "SELECT * FROM animaux WHERE nom_a LIKE :name";
    $stmt = $this->db->prepare($query);
    $stmt->execute([':name' => '%' . $name . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
?>
