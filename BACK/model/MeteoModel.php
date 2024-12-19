<?php
require_once 'C:\xampp\htdocs\BACK\config\config.php';

class MeteoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getMeteoData() {
        $query = "SELECT * FROM meteo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
