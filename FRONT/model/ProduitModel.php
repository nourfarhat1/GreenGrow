<?php
class ProduitModel {
    private $db;

    public function __construct() {
        require_once 'C:\xampp\htdocs\FRONT\config\database.php'; // Chemin vers votre classe Database
        $this->db = Database::connect();
    }

    public function getProduits() {
        $stmt = $this->db->prepare("SELECT * FROM produits");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function __destruct() {
        Database::disconnect();
    }
}
?>
