<?php
require_once 'C:/xampp/htdocs/BACK/config/config.php';
require_once 'C:/xampp/htdocs/BACK/model/ZoneModel.php';

class ZoneController
{
    private $db;

    public function __construct() {
        // Obtenir une instance de la connexion à la base de données
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Exemple de méthode pour récupérer des données de la base de données
    public function getAllFarms() {
        $query = "SELECT * FROM fermes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listZones()
    {
        $sql = "SELECT * FROM zone";
        try {
            $liste = $this->db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteZone($reference_zone)
    {
        $sql = "DELETE FROM zone WHERE reference_zone = :reference_zone";
        $req = $this->db->prepare($sql);
        $req->bindValue(':reference_zone', $reference_zone);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteZonesByFarmReference($reference_f)
    {
        $sql = "DELETE FROM zone WHERE reference_f = :reference_f";
        $req = $this->db->prepare($sql);
        $req->bindValue(':reference_f', $reference_f);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function addZone($zone)
    {
        $sql = "INSERT INTO zone (reference_zone, nom, type_zone, superficie_zone, culture, reference_f) VALUES (:reference_zone, :nom, :type_zone, :superficie_zone, :culture, :reference_f)";
        try {
            $query = $this->db->prepare($sql);
            $query->execute([
                'reference_zone' => $zone->getReferenceZone(),
                'nom' => $zone->getNom(),
                'type_zone' => $zone->getTypeZone(),
                'superficie_zone' => $zone->getSuperficieZone(),
                'culture' => $zone->getCulture(),
                'reference_f' => $zone->getReferenceF(),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function showZone($reference_zone)
    {
        $sql = "SELECT * FROM zone WHERE reference_zone = :reference_zone";
        try {
            $query = $this->db->prepare($sql);
            $query->bindValue(':reference_zone', $reference_zone);
            $query->execute();
            $zone = $query->fetch();
            return $zone;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateZone($zone, $reference_zone)
    {
        try {
            $query = $this->db->prepare(
                'UPDATE zone SET
                    nom = :nom,
                    type_zone = :type_zone,
                    superficie_zone = :superficie_zone,
                    culture = :culture,
                    reference_f = :reference_f
                WHERE reference_zone = :reference_zone'
            );

            $query->execute([
                'reference_zone' => $reference_zone,
                'nom' => $zone->getNom(),
                'type_zone' => $zone->getTypeZone(),
                'superficie_zone' => $zone->getSuperficieZone(),
                'culture' => $zone->getCulture(),
                'reference_f' => $zone->getReferenceF(),
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
