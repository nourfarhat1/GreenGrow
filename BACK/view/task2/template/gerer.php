<?php
require_once 'C:\xampp\htdocs\BACK\controller\IrrigationController.php';

$controller = new IrrigationController();
$controller->handleRequest();
?>

<?php
require_once 'C:\xampp\htdocs\BACK\controller\MeteoController.php';

$controller = new MeteoController();
$controller->displayMeteo();
?>

