<?php
require_once 'C:/xampp/htdocs/FRONT/config/database.php';
require_once 'C:/xampp/htdocs/FRONT/model/mod.php';




class FarmController
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listFarms()
    {
        $sql = "SELECT * FROM fermes";
        try {
            $liste = $this->db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteFarm($reference_f)
    {
        $sql = "DELETE FROM fermes WHERE reference_f = :reference_f";
        $req = $this->db->prepare($sql);
        $req->bindValue(':reference_f', $reference_f);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
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
            if ($farm) {
                // Diviser localisation en latitude et longitude
                $coordinates = explode(',', $farm['localisation']);
                if (count($coordinates) === 2) {
                    $farm['latitude'] = trim($coordinates[0]);
                    $farm['longitude'] = trim($coordinates[1]);
                } else {
                    $farm['latitude'] = '0';
                    $farm['longitude'] = '0';
                }
            }
            return $farm;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function showFarmZones($reference_f)
    {
        $sql = "SELECT z.* FROM zone z JOIN fermes f ON z.reference_f = f.reference_f WHERE f.reference_f = :reference_f";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':reference_f', $reference_f);
            $query->execute();
            $zones = $query->fetchAll();
            return $zones;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
