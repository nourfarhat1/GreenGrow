<?php
require __DIR__ . '/../config/db.php';  // Include database connection
require __DIR__ . '/../controllers/CommandeController.php';  // Include CommandeController

// Instantiate the controller
$controller = new CommandeController($conn);

// Check if the num_c is provided in the URL (GET request)
if (isset($_GET['num_c'])) {
    $num_c = $_GET['num_c'];
    
    // Attempt to delete the commande
    if ($controller->deleteCommande($num_c)) {
        // Redirect to the commande list with a success message
        header('Location: listCommandes.php?message=Commande+supprimée+avec+succès');
        exit();
    } else {
        echo "Échec de la suppression de la commande.";
    }
} else {
    // Redirect if no num_c is provided
    header('Location: listCommandes.php');
    exit();
}
?>
