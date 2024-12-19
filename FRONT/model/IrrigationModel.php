<?php
require_once 'C:\xampp\htdocs\FRONT\config\database.php';

class IrrigationModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function saveIrrigation($lieu, $typeDeSol, $typeDeCulture, $superficie, $quantiteEau, $idMeteo) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO irrigation (lieu, type_de_sol, type_de_culture, superficie, quantite_eau, id_meteo)
                 VALUES (:lieu, :type_de_sol, :type_de_culture, :superficie, :quantite_eau, :id_meteo)"
            );
            $stmt->execute([
                ':lieu' => $lieu,
                ':type_de_sol' => $typeDeSol,
                ':type_de_culture' => $typeDeCulture,
                ':superficie' => $superficie,
                ':quantite_eau' => $quantiteEau,
                ':id_meteo' => $idMeteo,
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    

    public function saveMeteo($temperature, $vent, $humidite, $precipitation) {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO meteo (temperature, vent, humidite, precipitation, date_meteo)
                 VALUES (:temperature, :vent, :humidite, :precipitation, NOW())"
            );
            $stmt->execute([
                ':temperature' => $temperature,
                ':vent' => $vent,
                ':humidite' => $humidite,
                ':precipitation' => $precipitation,
            ]);
            return $this->db->lastInsertId(); // Retourne l'ID inséré
        } catch (PDOException $e) {
            return false;
        }
    }
    
}
?>
