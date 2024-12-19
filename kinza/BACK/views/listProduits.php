<?php
require_once __DIR__ . '/../config/db.php';
require __DIR__ . '/../controllers/ProduitController.php';

// Instancier le contrôleur
$controller = new ProduitController($conn);

// Vérifier si une recherche a été soumise
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'asc';

// Fonction pour récupérer les produits avec recherche et tri
function getProduits($conn, $searchTerm, $sortOrder) {
    try {
        $sql = "SELECT * FROM produits WHERE nom_prod LIKE :searchTerm ORDER BY prix $sortOrder";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des produits: " . $e->getMessage();
        return [];
    }
}

// Fonction pour récupérer les statistiques des produits
function getProduitStats($conn) {
    try {
        // Statistiques des produits : nombre total et revenu total
        $sql = "SELECT COUNT(*) AS total_produits, SUM(prix) AS total_revenue FROM produits";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des statistiques des produits: " . $e->getMessage();
        return null;
    }
}

// Récupérer les produits filtrés et triés
$produits = getProduits($conn, $searchTerm, $sortOrder);

// Récupérer les statistiques
$stats = getProduitStats($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - GREENGROW</title>
    <!-- Inclure Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclure Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .products-section {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .titleText {
            font-size: 2rem;
            color: #388e3c;
            text-align: center;
            margin-bottom: 20px;
        }
        .table img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .table thead {
            background-color: #c8e6c9;
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
        .table-actions .btn {
            margin: 0 5px;
        }
        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<main class="container">
        <section class="products-section" id="products">
            <h2 class="titleText">Produits</h2>

            <!-- Formulaire de recherche -->
            <form action="" method="get" class="search-form">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Rechercher par nom...">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success">Rechercher</button>
                    </div>
                </div>
            </form>

            <!-- Options de tri -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="?search=<?= htmlspecialchars($searchTerm) ?>&sort=asc" class="btn btn-primary">Trier par prix (Ascendant)</a>
                    <a href="?search=<?= htmlspecialchars($searchTerm) ?>&sort=desc" class="btn btn-primary">Trier par prix (Descendant)</a>
                </div>
            </div>

            <!-- Affichage des statistiques -->
            <section class="stats-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="stats-card">
                            <h4>Total des produits</h4>
                            <p><?= $stats['total_produits'] ?></p>
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

            <?php if (count($produits) > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Prix (DT)</th>
                            <th>Fabricant</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $produit): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($produit['image_path']); ?>" alt="Image produit">
                                </td>
                                <td><?php echo htmlspecialchars($produit['nom_prod']); ?></td>
                                <td><?php echo htmlspecialchars($produit['type_prod']); ?></td>
                                <td><?php echo number_format((float)$produit['prix'], 2); ?></td>
                                <td><?php echo htmlspecialchars($produit['fabricant']); ?></td>
                                <td class="table-actions">
                                    <a href="editProduit.php?reference=<?php echo $produit['reference']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <a href="deleteProduit.php?reference=<?php echo $produit['reference']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');" class="btn btn-danger btn-sm">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Aucun produit disponible.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
