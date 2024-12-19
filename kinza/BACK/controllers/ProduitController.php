<?php
require_once 'C:\xampp\htdocs\kinza\BACK\models\Produit.php'; // Inclure le modèle Produit

class ProduitController {
    private $model;

    // Constructeur pour initialiser le contrôleur avec la connexion à la base de données
    public function __construct($db) {
        $this->model = new Produit($db); // Initialiser le modèle
    }

    // Méthode pour récupérer tous les produits (fetchProduits)
    public function fetchProduits() {
        header('Content-Type: application/json');
        $produits = $this->model->getAllProduits(); // Appel au modèle
        echo json_encode($produits);
    }

    // Créer un nouveau produit avec validation
    public function createProduit($reference, $type_prod, $nom_prod, $fabricant, $prix, $image_name = null, $image_path = null) {
        // Validation côté serveur
        if (empty($reference) || empty($type_prod) || empty($nom_prod) || empty($fabricant) || empty($prix)) {
            return "Tous les champs doivent être remplis!";
        }

        // Vérification du prix
        if (!is_numeric($prix) || $prix <= 0) {
            return "Le prix doit être un nombre positif!";
        }

        // Vérification du format de l'image (si une image est fournie)
        if ($image_name && !in_array(strtolower(pathinfo($image_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
            return "Format d'image invalide. Veuillez télécharger une image JPG, JPEG, PNG ou GIF.";
        }

        // Appeler la méthode du modèle pour ajouter le produit
        if ($this->model->createProduit($reference, $type_prod, $nom_prod, $fabricant, $prix, $image_name, $image_path)) {
            return "Produit créé avec succès!";
        } else {
            return "Échec de la création du produit.";
        }
    }

    // Lister tous les produits
    public function listProduits() {
        return $this->model->getAllProduits();
    }

    // Afficher un produit spécifique par référence
    public function viewProduit($reference) {
        if (empty($reference)) {
            return "La référence du produit est requise!";
        }
        return $this->model->getProduitByReference($reference);
    }

    // Mettre à jour un produit
    public function editProduit($reference, $type_prod, $nom_prod, $fabricant, $prix, $image_name = null, $image_path = null) {
        // Validation côté serveur pour l'édition
        if (empty($reference) || empty($type_prod) || empty($nom_prod) || empty($fabricant) || empty($prix)) {
            return "Tous les champs doivent être remplis!";
        }

        if (!is_numeric($prix) || $prix <= 0) {
            return "Le prix doit être un nombre positif!";
        }

        if ($image_name && !in_array(strtolower(pathinfo($image_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
            return "Format d'image invalide. Veuillez télécharger une image JPG, JPEG, PNG ou GIF.";
        }

        // Mettre à jour le produit
        if ($this->model->updateProduit($reference, $type_prod, $nom_prod, $fabricant, $prix, $image_name, $image_path)) {
            return "Produit mis à jour avec succès!";
        } else {
            return "Échec de la mise à jour du produit.";
        }
    }

    // Supprimer un produit
    public function deleteProduit($reference) {
        if (empty($reference)) {
            return "La référence du produit est requise!";
        }

        if ($this->model->deleteProduit($reference)) {
            return "Produit supprimé avec succès!";
        } else {
            return "Échec de la suppression du produit.";
        }
    }
}
