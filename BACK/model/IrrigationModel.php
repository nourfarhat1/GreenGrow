<?php
require_once 'C:\xampp\htdocs\BACK\config\config.php';

class IrrigationModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getIrrigationData() {
        $query = "SELECT * FROM irrigation";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteIrrigationById($id) {
        try {
            $this->conn->beginTransaction();
    
            // Obtenir l'id_meteo correspondant
            $querySelect = "SELECT id_meteo FROM irrigation WHERE id_irrigation = :id";
            $stmtSelect = $this->conn->prepare($querySelect);
            $stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtSelect->execute();
            $id_meteo = $stmtSelect->fetchColumn();
    
            if ($id_meteo) {
                // Supprimer l'irrigation
                $queryDeleteIrrigation = "DELETE FROM irrigation WHERE id_irrigation = :id";
                $stmtDeleteIrrigation = $this->conn->prepare($queryDeleteIrrigation);
                $stmtDeleteIrrigation->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtDeleteIrrigation->execute();
    
                // Supprimer la météo
                $queryDeleteMeteo = "DELETE FROM meteo WHERE id_meteo = :id_meteo";
                $stmtDeleteMeteo = $this->conn->prepare($queryDeleteMeteo);
                $stmtDeleteMeteo->bindParam(':id_meteo', $id_meteo, PDO::PARAM_INT);
                $stmtDeleteMeteo->execute();
            }
    
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    
    public function updateIrrigationAttribute($id, $attribute, $value) {
        // Liste des colonnes autorisées pour la mise à jour
        $allowedColumns = ['lieu', 'type_de_sol', 'type_de_culture', 'superficie', 'quantite_eau', 'id_meteo'];
        
        if (!in_array($attribute, $allowedColumns)) {
            return false; // Si l'attribut n'est pas valide, arrêtez
        }
    
        // Construire dynamiquement la requête SQL
        $query = "UPDATE irrigation SET $attribute = :value WHERE id_irrigation = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        return $stmt->execute();
    }
    
    
}
?>


