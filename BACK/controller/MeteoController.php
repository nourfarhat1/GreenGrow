<?php
require_once 'C:\xampp\htdocs\BACK\model\MeteoModel.php';

class MeteoController {
    private $model;

    public function __construct() {
        $this->model = new MeteoModel();
    }

    public function displayMeteo() {
        $data = $this->model->getMeteoData();
        include 'C:\xampp\htdocs\BACK\view/MeteoView.php';
    }
}
?>
