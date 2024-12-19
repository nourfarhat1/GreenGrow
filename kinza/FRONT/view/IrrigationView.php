<?php
require_once 'C:\xampp\htdocs\FRONT\controller\IrrigationController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'lieu' => $_POST['lieu'],
        'type_de_sol' => $_POST['type_de_sol'],
        'type_de_culture' => $_POST['type_de_culture'],
        'superficie' => $_POST['superficie'],
        'quantite_eau' => $_POST['quantite_eau'],
        'temperature' => $_POST['temperature'],
        'vent' => $_POST['vent'],
        'humidite' => $_POST['humidite'],
        'precipitation' => $_POST['precipitation']
    ];

    $controller = new IrrigationController();
    $result = $controller->handleIrrigation($data);

    header('Content-Type: application/json');
    echo json_encode(['success' => $result]);
}

?>
