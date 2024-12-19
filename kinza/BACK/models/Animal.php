<?php
class Animal {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour ajouter un nouvel animal avec age_type
    public function addAnimal($nom, $age, $age_type, $sexe, $symptomes, $quantite_n, $categorie_id) {
        // Requête SQL pour insérer l'animal dans la table
        $sql = "INSERT INTO animaux (Nom_a, age, age_type, sexe, symptomes, quantite_n, categorie_id) 
                VALUES (:nom, :age, :age_type, :sexe, :symptomes, :quantite_n, :categorie_id)";

        // Préparer la requête
        $stmt = $this->db->prepare($sql);
        // Exécution de la requête avec les paramètres
        $stmt->execute([
            ':nom' => $nom,
            ':age' => $age,
            ':age_type' => $age_type,   // Ajout du type d'âge
            ':sexe' => $sexe,
            ':symptomes' => $symptomes,
            ':quantite_n' => $quantite_n,
            ':categorie_id' => $categorie_id
        ]);
    }

    // Récupérer tous les animaux
    public function getAllAnimals() {
        $sql = "SELECT * FROM animaux";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer un animal par son nom
    public function deleteAnimal($nom_a) {
        // Vérifier que le nom est valide
        if (empty($nom_a)) {
            throw new Exception("Nom de l'animal invalide");
        }

        try {
            $query = "DELETE FROM animaux WHERE nom_a = :nom_a"; 
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nom_a', $nom_a, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                throw new Exception("Aucun animal trouvé avec ce nom.");
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'animal : " . $e->getMessage());
        }
    }

    // Récupérer un animal par son nom
    public function getAnimalByName($nom_a) {
        $query = "SELECT * FROM animaux WHERE nom_a = :nom_a";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nom_a', $nom_a);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mise à jour de l'animal avec le type d'âge
    public function updateAnimal($nom_a, $age, $age_type, $sexe, $symptomes, $quantite_n, $original_nom_a) {
        // Mettre à jour l'animal avec le nom de l'animal original comme condition
        $query = "UPDATE animaux 
                  SET nom_a = :nom_a, age = :age, age_type = :age_type, sexe = :sexe, symptomes = :symptomes, quantite_n = :quantite_n 
                  WHERE nom_a = :original_nom_a";

        // Préparer la requête
        $stmt = $this->db->prepare($query);

        // Lier les paramètres
        $stmt->bindParam(':nom_a', $nom_a);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':age_type', $age_type);  // Lier le type d'âge
        $stmt->bindParam(':sexe', $sexe);
        $stmt->bindParam(':symptomes', $symptomes);
        $stmt->bindParam(':quantite_n', $quantite_n);
        $stmt->bindParam(':original_nom_a', $original_nom_a);  // Utilisation du nom original pour identifier l'animal

        // Exécuter la requête
        return $stmt->execute();
    }
}
