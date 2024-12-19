<?php
require __DIR__ . '/../config/db.php';
require __DIR__ . '/../controller/ProduitController.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ProduitController($conn);

    // Collect form data
    $reference = $_POST['reference'];
    $type_prod = $_POST['type_prod'];
    $nom_prod = $_POST['nom_prod'];
    $fabricant = $_POST['fabricant'];
    $prix = $_POST['prix'];
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_type = $_FILES['image']['type'];

    // Validation
    $errors = [];
    
    // Check if required fields are not empty
    if (empty($reference) || empty($type_prod) || empty($nom_prod) || empty($fabricant) || empty($prix) || empty($image_name)) {
        $errors[] = "All fields must be filled!";
    }

    // Validate price: Ensure it's a valid number and greater than 0
    if (!is_numeric($prix) || $prix <= 0) {
        $errors[] = "Please enter a valid price greater than 0.";
    }

    // Validate image: Check for a valid image file type (jpeg, png, gif)
    $validImageTypes = ["image/jpeg", "image/png", "image/gif"];
    if (!in_array($image_type, $validImageTypes)) {
        $errors[] = "Invalid image type. Please upload a JPG, PNG, or GIF image.";
    }

    // Check file size (e.g., max 5MB)
    if ($image_size > 5 * 1024 * 1024) {  // 5MB max
        $errors[] = "The image size exceeds the maximum limit of 5MB.";
    }

    // If there are validation errors, show them and don't process the form
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        // Define absolute and relative paths for the image
        $uploadDir = __DIR__ . '/images/';
        $image_path = $uploadDir . $image_name;
        $relativePath = 'images/' . $image_name; // Path stored in database

        // Ensure the images/ directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Handle file upload
        if (move_uploaded_file($image_tmp, $image_path)) {
            $result = $controller->createProduit($reference, $type_prod, $nom_prod, $fabricant, $prix, $image_name, $relativePath);

            // Redirect with a success message or display an error
            if ($result) {
                header('Location: listProduits.php'); // Redirect to the list of products
                exit();
            } else {
                echo "Failed to create the product.";
            }
        } else {
            echo "Failed to upload image.<br>";
            echo "Temporary file: " . $image_tmp . "<br>";
            echo "Target path: " . $image_path . "<br>";
        }
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
        <h1>Create New Product</h1>
    <form action="createProduit.php" method="post" enctype="multipart/form-data">
        <label for="reference">Reference:</label>
        <input type="text" name="reference" required><br><br>

        <label for="type_prod">Product Type:</label>
        <input type="text" name="type_prod" required><br><br>

        <label for="nom_prod">Product Name:</label>
        <input type="text" name="nom_prod" required><br><br>

        <label for="fabricant">Manufacturer:</label>
        <input type="text" name="fabricant" required><br><br>

        <label for="prix">Price:</label>
        <input type="number" step="0.01" name="prix" required><br><br>

        <label for="image">Product Image:</label>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Add Product</button>
        <a href="listProduits.php">Back to Products List</a>
    </form>
</div>
</main>
</body>
</html>
