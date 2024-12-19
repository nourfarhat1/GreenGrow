
<?php
require_once 'C:\xampp\htdocs\kinza\BACK\controllers\ProduitController.php';
require_once 'C:\xampp\htdocs\kinza\BACK\controllers\CommandeController.php';


try {
    $db = new PDO('mysql:host=localhost;dbname=projet', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit;
}
$controller = new ProduitController($db);
$controller->fetchProduits();
$controller = new CommandeController($db);
$controller->displayCommande();
?>
