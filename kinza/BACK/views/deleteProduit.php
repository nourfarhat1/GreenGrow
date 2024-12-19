<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../controllers/ProduitController.php';

// Instantiate the controller
$controller = new ProduitController($conn);

// Check if the reference is provided in the URL
if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];
    
    // Attempt to delete the product and redirect with a success or error message
    if ($controller->deleteProduit($reference)) {
        // Redirect to the product list after deletion
        header('Location: listProduits.php?message=Produit+supprimé+avec+succès');
        exit();
    } else {
        echo "Échec de la suppression du produit.";
    }
} else {
    // Redirect if no reference is provided
    header('Location: listProduits.php');
    exit();
}
?>
