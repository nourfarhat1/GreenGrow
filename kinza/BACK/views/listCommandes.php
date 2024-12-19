<?php
// Include necessary files
require_once __DIR__ . '/../config/db.php';  // Database connection
require __DIR__ . '/../controllers/CommandeController.php';  // Commande Controller

// Instantiate the controller
$controller = new CommandeController($conn);
// Récupérer le produit best-seller
$bestSeller = $controller->getBestSeller();




// Get sorting parameters from the URL, default to sorting by 'num_c' in ascending order
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'num_c';
$sortOrder = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';

// Check if a search query is provided
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Retrieve commandes with sorting based on user input
$commandes = $controller->getAllCommandes($searchQuery, $sortColumn, $sortOrder);

// Fetch command statistics
function getCommandeStats($conn) {
    try {
        $sql = "SELECT COUNT(*) AS total_commandes, SUM(prix_total) AS total_revenue FROM commandes";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des statistiques: " . $e->getMessage();
        return null;
    }
}

$stats = getCommandeStats($conn);

?>
<?php if ($bestSeller): ?>
<section class="best-seller-section">
    <h2 class="text-center">Produit Best-Seller</h2>
    <div class="stats-card">
        <h4>Référence : <?= htmlspecialchars($bestSeller['reference']) ?></h4>
        <p>Nombre de commandes : <strong><?= $bestSeller['total_commandes'] ?></strong></p>
        <p>Ventes totales : <strong><?= number_format($bestSeller['total_ventes'], 2) ?> TND</strong></p>
    </div>
</section>
<?php endif; ?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes - GREENGROW</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .stats-card {
            background-color: #388e3c;
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .stats-card h4 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .table {
            background-color: white;
            margin-top: 20px;
        }
        .table thead {
            background-color: #c8e6c9;
        }
        .table img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .table-actions .btn {
            margin: 0 5px;
        }
        .best-seller-section .stats-card {
    background: linear-gradient(135deg, #81c784, #66bb6a); /* Dégradé vert */
    color: white;
    border-radius: 15px;
    padding: 20px; /* Réduction de l'espace interne */
    margin: 0 auto;
    width: 80%; /* Augmentation de la largeur */
    max-width: 600px; /* Limite maximale de la largeur pour une meilleure adaptation */
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15); /* Réduction de l'ombre */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.best-seller-section .stats-card:hover {
    transform: scale(1.03); /* Agrandissement plus subtil */
    box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.25); /* Ombre légèrement augmentée */
}

    </style>
    <script>
        function confirmAction() {
            alert("La commande a été confirmée avec succès!");
        }
    </script>
</head>
<body>
    

    <main class="container">
        <section class="commandes-section" id="commandes">
            <h2 class="titleText">Liste des Commandes</h2>

            <!-- Search Bar -->
            <form method="GET" action="" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Rechercher par numéro de commande" value="<?= htmlspecialchars($searchQuery) ?>">
                    <button class="btn btn-primary" type="submit">Rechercher</button>
                </div>
            </form>

            <!-- Display statistics just above the table -->
            <section class="stats-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="stats-card">
                            <h4>Total des commandes</h4>
                            <p><?= $stats['total_commandes'] ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-card">
                            <h4>Revenu total</h4>
                            <p><?= number_format($stats['total_revenue'], 2) ?> TND</p>
                        </div>
                    </div>
                </div>
            </section>

            <?php if (count($commandes) > 0): ?>
                <table class="table table-bordered table-striped">
                <thead>
    <tr>
        <th><a href="?sort=num_c&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Numéro de Commande</a></th>
        <th><a href="?sort=nom&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Nom</a></th>
        <th><a href="?sort=prenom&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Prénom</a></th>
        <th><a href="?sort=adresse&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Adresse</a></th>
        <th><a href="?sort=email&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Email</a></th>
        <th><a href="?sort=telephone&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Téléphone</a></th>
        <th><a href="?sort=livraison&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Livraison</a></th>
        <th><a href="?sort=reference&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Référence</a></th>
        <th><a href="?sort=prix_total&order=<?= $sortOrder == 'asc' ? 'desc' : 'asc' ?>&search=<?= urlencode($searchQuery) ?>">Prix Total</a></th>
        <th>Actions</th>
    </tr>
</thead>


                    <tbody>
                        <?php foreach ($commandes as $commande): ?>
                            <tr>
                                <td><?= htmlspecialchars($commande['num_c']) ?></td>
                                <td><?= htmlspecialchars($commande['nom']) ?></td>
                                <td><?= htmlspecialchars($commande['prenom']) ?></td>
                                <td><?= htmlspecialchars($commande['adresse']) ?></td>
                                <td><?= htmlspecialchars($commande['email']) ?></td>
                                <td><?= htmlspecialchars($commande['telephone']) ?></td>
                                <td><?= $commande['livraison'] == 'oui' ? 'Oui' : 'Non' ?></td>
                                <td><?= htmlspecialchars($commande['reference']) ?></td>
                                <td><?= number_format($commande['prix_total'], 2, ',', ' ') ?> TND</td>
                                <td class="table-actions">
                                    <a href="editCommande.php?num_c=<?= $commande['num_c'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <a href="deleteCommande.php?num_c=<?= $commande['num_c'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="btn btn-danger btn-sm">Supprimer</a>
                                    <button class="btn btn-success btn-sm" onclick="confirmAction()">Confirmer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Aucune commande trouvée.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
