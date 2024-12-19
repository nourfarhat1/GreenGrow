<?php
require_once 'C:\xampp\htdocs\BACK\model\IrrigationModel.php';

class IrrigationController {
    private $model;

    public function __construct() {
        $this->model = new IrrigationModel();
    }

    public function displayIrrigation() {
        $data = $this->model->getIrrigationData();
        include 'C:\xampp\htdocs\BACK\view\IrrigationView.php';
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gestion de la suppression
            if (isset($_POST['delete_id'])) {
                $id = intval($_POST['delete_id']);
                $success = $this->model->deleteIrrigationById($id);
                if ($success) {
                    echo "<script>alert('Ligne supprimée avec succès !');</script>";
                } else {
                    echo "<script>alert('Erreur lors de la suppression.');</script>";
                }
            }
            // Gestion de la modification
            elseif (isset($_POST['update_id'], $_POST['attribute_name'], $_POST['attribute_value'])) {
                $id = intval($_POST['update_id']);
                $attribute = $_POST['attribute_name'];
                $value = $_POST['attribute_value'];
    
                // Appeler la méthode de mise à jour du modèle
                $success = $this->model->updateIrrigationAttribute($id, $attribute, $value);
                if ($success) {
                    echo "<script>alert('Valeur mise à jour avec succès !');</script>";
                } else {
                    echo "<script>alert('Erreur lors de la mise à jour.');</script>";
                }
            }
        }
        $this->displayIrrigation();
    }
    
     
}

?>
