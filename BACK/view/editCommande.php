<?php
require 'C:\xampp\htdocs\BACK\config\db.php';
require '../controller/CommandeController.php';

// Instantiate the controller
$controller = new CommandeController($conn);

// Check if an ID is provided in the URL and fetch the commande details
if (isset($_GET['num_c'])) {
    $commande = $controller->getCommandeById($_GET['num_c']); // Use the correct method to get the commande by ID
    if (!$commande) {
        // Redirect to the commande list if the commande is not found
        header('Location: listCommandes.php');
        exit();
    }
} else {
    // Redirect if no ID is provided
    header('Location: listCommandes.php');
    exit();
}

// Handle form submission for updating the commande
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the data to update
    $commandeData = [
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'adresse' => $_POST['adresse'],
        'email' => $_POST['email'],
        'telephone' => $_POST['telephone'],
        'livraison' => $_POST['livraison'],
        'reference' => $_POST['reference'],
        'prix_total' => $_POST['prix_total']
    ];

    // Call the updateCommande method to update the commande
    $result = $controller->updateCommande($_POST['num_c'], $commandeData);
    if ($result) {
        header('Location: listCommandes.php');
        exit();
    } else {
        echo "Failed to update the commande.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Commande - GREENGROW</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif">
    <style>
        .form-field { background-color: #004d00; padding: 10px; border-radius: 5px; margin-bottom: 15px; color: white; }
        .form-field label { color: white; }
        .btn-confirm { background-color: #66bb66; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .btn-confirm:hover { background-color: #57a957; }
    </style>
</head>
<body class="main-layout">
    <header>
        <div class="header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 logo_section">
                        <div class="logo"><a href="index.html"><img src="assets/images/logo.png" alt="Logo Green Grow"></a></div>
                    </div>
                    <div class="col-md-9">
                        <ul class="location_icon_bottum_tt">
                            <li><img src="assets/icon/loc1.png" alt="location icon"> Ariana, Tunisie</li>
                            <li><img src="assets/icon/email1.png" alt="email icon"> green_grow@gmail.com</li>
                            <li><img src="assets/icon/call1.png" alt="call icon"> (+216) 30 300 300</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="py-5">
        <div class="container">
<body>
    <h1>Edit Commande</h1>
    <form action="editCommande.php?num_c=<?php echo $commande['num_c']; ?>" method="post">
        <input type="hidden" name="num_c" value="<?php echo $commande['num_c']; ?>">
        
        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($commande['nom']); ?>" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($commande['prenom']); ?>" required><br><br>

        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" value="<?php echo htmlspecialchars($commande['adresse']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($commande['email']); ?>" required><br><br>

        <label for="telephone">Téléphone:</label>
        <input type="text" name="telephone" value="<?php echo htmlspecialchars($commande['telephone']); ?>" required><br><br>

        <label for="livraison">Livraison (1 for yes, 0 for no):</label>
        <input type="number" name="livraison" value="<?php echo $commande['livraison']; ?>" min="0" max="1" required><br><br>

        <label for="reference">Reference:</label>
        <input type="text" name="reference" value="<?php echo htmlspecialchars($commande['reference']); ?>" required><br><br>

        <button type="submit">Update Commande</button>
        <a href="listCommandes.php">Back to Commande List</a>
    </form>
</body>
</html>
