<?php
require_once 'C:/xampp/htdocs/FRONT/config/database.php';
require_once 'C:/xampp/htdocs/FRONT/model/FarmModel.php';
require_once 'C:/xampp/htdocs/FRONT/controller/ZoneController.php';

class FarmController
{
    private $db;
    private $zoneController;

    public function __construct($db) {
        $this->db = $db;
        $this->zoneController = new ZoneController($db); // Passer l'objet de connexion à ZoneController
    }

    public function listFarms()
    {
        $sql = "SELECT * FROM fermes";
        try {
            $liste = $this->db->query($sql);
            return $liste->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
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
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
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
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function showFarm($reference_f)
    {
        $sql = "SELECT * FROM fermes WHERE reference_f = :reference_f";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':reference_f', $reference_f);
            $query->execute();
            $farm = $query->fetch(PDO::FETCH_ASSOC);
            return $farm;
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
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

            return $query->rowCount();
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
?>
