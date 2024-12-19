<?php
// Inclure les fichiers nécessaires
require_once 'C:\xampp\htdocs\Kinza\FRONT\controller\ProduitController.php';
require_once 'C:\xampp\htdocs\Kinza\FRONT\controller\CommandeController.php';
require_once 'C:\xampp\htdocs\Kinza\FRONT\view\ProduitView.php';

try {
    $conn = new PDO("mysql:host=localhost;dbname=projet", "root", ""); // Adjust these values as needed
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Instantiate the controllers and view
$produitController = new ProduitController($conn);
$commandeController = new CommandeController($conn);
$view = new ProduitView();

// Get the search value if it exists
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get products from the database with or without search
$produits = $produitController->afficherProduits($search);

// Initialize errors array for form validation
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim the POST data and store in variables
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $adresse = trim($_POST['adresse']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $reference = trim($_POST['reference']);
    $livraison = trim($_POST['livraison']);
    $prix_total = trim($_POST['prix_total']);

    // Perform validation
    if (empty($nom)) $errors['nom'] = "Le nom est requis.";
    if (empty($prenom)) $errors['prenom'] = "Le prénom est requis.";
    if (empty($adresse)) $errors['adresse'] = "L'adresse est requise.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Un email valide est requis.";
    if (empty($telephone) || !preg_match('/^\d{8}$/', $telephone)) $errors['telephone'] = "Un numéro de téléphone valide (8 chiffres) est requis.";
    if (!is_numeric($prix_total) || $prix_total < 0) $errors[] = "Le prix total doit être un nombre positif.";

    // If no errors, attempt to add the order
    if (empty($errors)) {
        // Call the method to add the order (commande)
        $success = $commandeController->ajouterCommande($nom, $prenom, $adresse, $email, $telephone, $reference, $livraison, $prix_total);

        if ($success) {
            echo "<script>alert('Votre commande a été ajoutée avec succès !');</script>";
        } else {
            echo "<script>alert('Une erreur s\'est produite lors de l\'ajout de la commande.');</script>";
        }
    }
}

// Handle likes and dislikes update
if (isset($_GET['productId']) && isset($_GET['type'])) {
    $productId = $_GET['productId'];
    $type = $_GET['type'];

    if ($type === 'like') {
        $produitController->incrementLike($productId);
    } else if ($type === 'dislike') {
        $produitController->incrementDislike($productId);
    }

    $sql = "SELECT likes, dislikes FROM produits WHERE reference = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $productId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'likes' => $result['likes'], 'dislikes' => $result['dislikes']]);
    exit;
}

if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue des Produits - Green Grow</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .price { font-weight: bold; color: green; }
        .cart-container { cursor: pointer; position: relative; }
        #cart-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
        .like-dislike-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .product-image {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation avec l'icône du chariot -->
    <nav class="navbar navbar-light bg-light">
        <div class="navbar-brand cart-container" data-toggle="modal" data-target="#cartModal">
            <img src="https://img.icons8.com/material-outlined/24/000000/shopping-cart.png" id="cart-icon" alt="Chariot">
            <span id="cart-count">0</span>
        </div>
    </nav>

    <!-- Formulaire de recherche (un seul bloc) -->
    <div class="container my-3">
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Rechercher un produit..." name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Rechercher</button>
                </div>
            </div>
        </form>
    </div>
    

    <!-- Section des produits -->
    <div class="container my-5">
        <div class="row">
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-4 mb-4">
                    <div class="card product-card">
                        <img src="<?= htmlspecialchars($produit['image_path']); ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($produit['image_name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produit['nom_prod']); ?></h5>
                            <p class="card-text">Type : <?= htmlspecialchars($produit['type_prod']); ?></p>
                            <p class="card-text">Fabricant : <?= htmlspecialchars($produit['fabricant']); ?></p>
                            <p class="price"><?= number_format($produit['prix'], 2); ?> TND</p>
                            <button class="btn btn-success add-to-cart"
                                    data-id="<?= $produit['reference']; ?>"
                                    data-name="<?= htmlspecialchars($produit['nom_prod']); ?>"
                                    data-price="<?= htmlspecialchars($produit['prix']); ?>">Ajouter au panier</button>
                            <div class="like-dislike-buttons">
                                <button class="btn btn-outline-success like-btn" data-id="<?= $produit['reference']; ?>">👍</button>
                                <span id="like-count-<?= $produit['reference']; ?>"><?= $produit['likes']; ?></span>
                                <button class="btn btn-outline-danger dislike-btn" data-id="<?= $produit['reference']; ?>">👎</button>
                                <span id="dislike-count-<?= $produit['reference']; ?>"><?= $produit['dislikes']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modale du panier -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Mon Panier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems"></tbody>
                    </table>
                    <p class="text-right total-row">Total : <span id="cartTotal">0</span> TND</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" data-toggle="modal" data-target="#infoModal">Confirmer la commande</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Formulaire pour soumettre les données à CommandeController.php -->
                <form id="orderForm" method="POST" action="produit.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">Vos Informations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Affichage des erreurs de validation -->
                        <div id="formErrors"></div>

                        <div class="form-group">
                            <label for="reference">Référence des Produits</label>
                            <input type="text" id="reference" name="reference" class="form-control" value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="livraison">Souhaitez-vous une livraison ?</label>
                            <select id="livraison" name="livraison" class="form-control">
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prix_total">Prix Total</label>
                            <input type="text" id="prix_total" name="prix_total" class="form-control" value="0" readonly>
                        </div>

                        <div class="form-group">
                            <label for="adresse">Adresse</label>
                            <input type="text" id="adresse" name="adresse" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="text" id="telephone" name="telephone" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let cart = [];

        function addToCart(id, name, price) {
            let product = cart.find(item => item.id === id);
            if (product) {
                product.quantity++;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }
            updateCart();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');
                    const price = button.getAttribute('data-price');
                    addToCart(id, name, price);
                });
            });

            $('#cartModal').on('show.bs.modal', () => {
                updateReferenceField();
                const total = document.getElementById('cartTotal').textContent; // Get the total price
                document.getElementById('prix_total').value = total; // Set total price in the form
            });

            updateCart();
        });

        function updateCart() {
            const cartCount = document.getElementById('cart-count');
            const cartTotal = document.getElementById('cartTotal');
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';
            let total = 0;
            cart.forEach(item => {
                total += item.price * item.quantity;
                cartItems.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price} TND</td>
                        <td>${item.price * item.quantity} TND</td>
                    </tr>
                `;
            });
            cartCount.textContent = cart.length;
            cartTotal.textContent = total.toFixed(2);
        }

        function updateReferenceField() {
            const references = cart.map(item => item.id).join(", ");
            document.getElementById('reference').value = references;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const likeButtons = document.querySelectorAll('.like-btn');
            const dislikeButtons = document.querySelectorAll('.dislike-btn');

            likeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const reference = button.getAttribute('data-id');
                    updateLikes(reference, 'like');
                });
            });

            dislikeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const reference = button.getAttribute('data-id');
                    updateLikes(reference, 'dislike');
                });
            });
        });

        function updateLikes(productId, type) {
            fetch(`produit.php?productId=${productId}&type=${type}`, {
                method: 'GET'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById(`like-count-${productId}`).textContent = data.likes;
                    document.getElementById(`dislike-count-${productId}`).textContent = data.dislikes;
                } else {
                    console.error('Erreur lors de la mise à jour des likes/dislikes:', data.error);
                }
            })
            .catch(error => console.error('Erreur:', error));
        }
    </script>
</body>
</html>
