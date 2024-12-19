<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../controllers/ProduitController.php';

// Instantiate the controller
$controller = new ProduitController($conn);

// Check if a reference is provided in the URL and fetch the product details
if (isset($_GET['reference'])) {
    $product = $controller->viewProduit($_GET['reference']);
    if (!$product) {
        // Redirect to the product list if the product is not found
        header('Location: listProduits.php');
        exit();
    }
} else {
    // Redirect if no reference is provided
    header('Location: listProduits.php');
    exit();
}

// Handle form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->editProduit($_POST['reference'], $_POST['type_prod'], $_POST['nom_prod'], $_POST['fabricant'], $_POST['prix'], $_POST['image_name'], $_POST['image_path']);
    if ($result) {
        header('Location: listProduits.php');
        exit();
    } else {
        echo "Failed to update the product.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
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
        <h1>Edit Product</h1>
    <form action="editProduit.php?reference=<?php echo $product['reference']; ?>" method="post">
        <input type="hidden" name="reference" value="<?php echo $product['reference']; ?>">
        
        <label for="type_prod">Product Type:</label>
        <input type="text" name="type_prod" value="<?php echo htmlspecialchars($product['type_prod']); ?>" required><br><br>

        <label for="nom_prod">Product Name:</label>
        <input type="text" name="nom_prod" value="<?php echo htmlspecialchars($product['nom_prod']); ?>" required><br><br>

        <label for="fabricant">Manufacturer:</label>
        <input type="text" name="fabricant" value="<?php echo htmlspecialchars($product['fabricant']); ?>" required><br><br>

        <label for="prix">Price:</label>
        <input type="number" name="prix" step="0.01" value="<?php echo $product['prix']; ?>" required><br><br>

        <label for="image_name">Image Name:</label>
        <input type="text" name="image_name" value="<?php echo htmlspecialchars($product['image_name']); ?>"><br><br>

        <label for="image_path">Image Path:</label>
        <input type="text" name="image_path" value="<?php echo htmlspecialchars($product['image_path']); ?>"><br><br>

        <button type="submit">Update Product</button>
        <a href="listProduits.php">Back to Products List</a>
    </form>

        </div>
    </main>
</body>
</html>
