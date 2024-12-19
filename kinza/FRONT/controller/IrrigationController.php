<?php
require_once 'C:\xampp\htdocs\FRONT\model\IrrigationModel.php';

class IrrigationController {
    private $model;

    public function __construct() {
        $this->model = new IrrigationModel();
    }

    public function handleIrrigation($data) {
        $lieu = $data['lieu'];
        $typeDeSol = $data['type_de_sol'];
        $typeDeCulture = $data['type_de_culture'];
        $superficie = $data['superficie'];
        $quantiteEau = $data['quantite_eau'];
        $temperature = $data['temperature'];
        $vent = $data['vent'];
        $humidite = $data['humidite'];
        $precipitation = $data['precipitation'];
    
        // Enregistrer les données météo et obtenir l'ID
        $idMeteo = $this->model->saveMeteo($temperature, $vent, $humidite, $precipitation);
    
        if ($idMeteo) {
            // Enregistrer les données d'irrigation avec l'ID météo
            return $this->model->saveIrrigation($lieu, $typeDeSol, $typeDeCulture, $superficie, $quantiteEau, $idMeteo);
        }
        return false;
    }
    
}
?>
