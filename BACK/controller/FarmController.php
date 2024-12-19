<?php

require_once 'C:/xampp/htdocs/BACK/config/config.php';
require_once 'C:/xampp/htdocs/BACK/model/FarmModel.php';
require_once 'C:/xampp/htdocs/BACK/controller/ZoneController.php';



class FarmController
{
    private $db;
    private $zoneController;

    public function __construct() {
        // Obtenir une instance de la connexion à la base de données
        $database = new Database();
        $this->db = $database->getConnection();

        // Initialiser le ZoneController
        $this->zoneController = new ZoneController();
    }

    public function listFarms()
    {
        $sql = "SELECT * FROM fermes";
        try {
            $liste = $this->db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteFarm($reference_f)
    {
        // Supprimer les zones associées à la ferme
        $this->zoneController->deleteZonesByFarmReference($reference_f);

        $sql = "DELETE FROM fermes WHERE reference_f = :reference_f";
        $req = $this->db->prepare($sql);
        $req->bindValue(':reference_f', $reference_f);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function addFarm($farm)
    {
        $sql = "INSERT INTO fermes (reference_f, localisation, superficie_totale) VALUES (:reference_f, :localisation, :superficie_totale)";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([
                'reference_f' => $farm->getReferenceF(),
                'localisation' => $farm->getLocalisation(),
                'superficie_totale' => $farm->getSuperficieTotale(),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function showFarm($reference_f)
    {
        $sql = "SELECT * FROM fermes WHERE reference_f = :reference_f";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':reference_f', $reference_f);
            $query->execute();
            $farm = $query->fetch();
            return $farm;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateFarm($farm, $reference_f)
    {
        try {
            $query = $this->db->prepare(
                'UPDATE fermes SET
                    localisation = :localisation,
                    superficie_totale = :superficie_totale
                WHERE reference_f = :reference_f'
            );

            $query->execute([
                'reference_f' => $reference_f,
                'localisation' => $farm->getLocalisation(),
                'superficie_totale' => $farm->getSuperficieTotale(),
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
