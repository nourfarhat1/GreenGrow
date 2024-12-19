<?php
require_once 'C:/xampp/htdocs/FRONT/config/database.php';
require_once 'C:/xampp/htdocs/FRONT/controller/cont1.php';

// Connexion à la base de données
$db = Database::connect();

// Passer la connexion à la base de données au contrôleur
$farmController = new FarmController($db);
$zones = [];
$farm = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference_f = $_POST['reference_f'];
    $zones = $farmController->showFarmZones($reference_f);
    $farm = $farmController->showFarm($reference_f);
}

// Fonction pour regrouper les données par nom et sommer les superficies
function groupZonesByName($zones) {
    $groupedData = [];
    foreach ($zones as $zone) {
        $name = $zone['nom'];
        if (!isset($groupedData[$name])) {
            $groupedData[$name] = [
                'nom' => $name,
                'superficie_zone' => 0
            ];
        }
        $groupedData[$name]['superficie_zone'] += $zone['superficie_zone'];
    }
    return array_values($groupedData);
}

$groupedZones = groupZonesByName($zones);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Green Grow</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <style>
        .form-field { background-color: #004d00; padding: 10px; border-radius: 5px; margin-bottom: 15px; color: white; }
        .form-field label { color: white; }
        .btn-confirm { background-color: #66bb66; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .btn-confirm:hover { background-color: #57a957; }
        .farm-details { max-width: 800px; margin: 20px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .farm-header { border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 20px; }
        .farm-header h1 { margin: 0; display: flex; align-items: center; }
        .farm-icon { font-size: 24px; margin-right: 10px; }
        .farm-name { font-size: 24px; margin-right: 10px; }
        .farm-reference { font-size: 16px; color: #666; }
        .farm-location, .farm-surface, .farm-description, .farm-media, .farm-products, .farm-certifications, .farm-events, .farm-contact, .farm-management, .farm-statistics, .farm-notifications { margin-bottom: 20px; }
        .farm-location #map, .farm-surface .surface-graph, .farm-media .media-gallery { height: 200px; background-color: #e0e0e0; margin-bottom: 10px; }
        .route-button, .edit-button, .add-media-button, .manage-products-button, .plan-events-button { background-color: #007BFF; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; }
        .route-button:hover, .edit-button:hover, .add-media-button:hover, .manage-products-button:hover, .plan-events-button:hover { background-color: #0056b3; }
        .surface-icon { font-size: 20px; margin-right: 5px; }
        #map { height: 300px; }
        .zone-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .zone-table th, .zone-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .zone-table th { background-color: #f2f2f2; }
        .metric-section { margin-bottom: 20px; }
        .metric-section h2 { margin-bottom: 10px; }
        .metric-section p { margin: 0; }
        .zone-list { list-style-type: none; padding: 0; display: flex; flex-wrap: wrap; gap: 20px; }
        .zone-list-item { background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 10px; padding: 20px; flex: 1; min-width: 250px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.2s, box-shadow 0.2s; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .zone-list-item:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); }
        .zone-list-item .info-item { display: flex; align-items: center; margin-bottom: 15px; color: #333; }
        .zone-list-item .info-item i { margin-right: 10px; font-size: 24px; color: #66bb66; }
        .zone-list-item .info-item span { font-size: 16px; }
    </style>
</head>
<body class="main-layout">
    <main class="py-5">
        <div class="container">
            <div class="farm-details">
                <header class="farm-header">
                    <h1>
                        <span class="farm-icon">&#128102;</span>
                        <span class="farm-name" id="farm-name">Ferme Verte</span>
                        <span class="farm-reference">(Code: <span id="farm-code">FV001</span>)</span>
                    </h1>
                    <form method="POST" action="zonef.php">
                        <input type="text" id="farm-input" name="reference_f" placeholder="Entrez la référence de la ferme" required>
                        <button class="btn-confirm" type="submit">Confirmer</button>
                    </form>
                    <button class="btn-confirm" onclick="redirectToAddPage()">Ajouter une ferme</button>
                    <!-- Ajouter le bouton de retour à la liste ici -->
                    <a href="farm.php" class="btn-confirm">Retour à la liste</a>
                </header>

                <?php if (!empty($groupedZones) && $farm): ?>
                    <section class="metric-section">
                        <h2>Liste des Zones</h2>
                        <ul class="zone-list">
                            <?php foreach ($zones as $zone): ?>
                                <li class="zone-list-item">
                                    <div class="info-item">
                                        <i class="fa fa-id-card"></i>
                                        <span><?php echo htmlspecialchars($zone['reference_zone']); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa fa-leaf"></i>
                                        <span><?php echo htmlspecialchars($zone['nom']); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa fa-object-group"></i>
                                        <span><?php echo htmlspecialchars($zone['type_zone']); ?></span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa fa-square"></i>
                                        <span><?php echo htmlspecialchars($zone['superficie_zone']); ?> m²</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fa fa-seedling"></i>
                                        <span><?php echo htmlspecialchars($zone['culture']); ?></span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>

                    <section class="metric-section">
                        <h2>Répartition des Superficies par Nom de Zone</h2>
                        <canvas id="barChart"></canvas>
                    </section>
                    <section class="metric-section">
                        <h2>Répartition des Superficies par Nom de Zone</h2>
                        <canvas id="pieChart"></canvas>
                    </section>
                    <section class="metric-section">
                        <h2>Comparaison entre Surface Totale, Utilisée et Non Utilisée</h2>
                        <canvas id="totalSurfaceChart"></canvas>
                    </section>
                <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <p>Aucune zone trouvée avec cette référence.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function redirectToAddPage() {
            window.location.href = 'add.php';
        }

        <?php if (!empty($groupedZones) && $farm): ?>
            // Mettre à jour le graphique en barres
            var ctxBar = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_column($groupedZones, 'nom')); ?>,
                    datasets: [{
                        label: 'Superficie (m²)',
                        data: <?php echo json_encode(array_column($groupedZones, 'superficie_zone')); ?>,
                        backgroundColor: 'rgba(102, 187, 106, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Mettre à jour le diagramme en secteurs (camembert)
            var ctxPie = document.getElementById('pieChart').getContext('2d');
            var pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode(array_column($groupedZones, 'nom')); ?>,
                    datasets: [{
                        label: 'Superficie (m²)',
                        data: <?php echo json_encode(array_column($groupedZones, 'superficie_zone')); ?>,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ]
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Calculer la surface non utilisée
            var totalSurface = <?php echo $farm['superficie_totale']; ?>;
            var usedSurface = <?php echo array_sum(array_column($groupedZones, 'superficie_zone')); ?>;
            var unusedSurface = totalSurface - usedSurface;

            // Mettre à jour le graphique de la surface totale utilisée
            var ctxTotalSurface = document.getElementById('totalSurfaceChart').getContext('2d');
            var totalSurfaceChart = new Chart(ctxTotalSurface, {
                type: 'bar',
                data: {
                    labels: ['Surface Totale', 'Surface Utilisée', 'Surface Non Utilisée'],
                    datasets: [{
                        label: 'Surface (m²)',
                        data: [totalSurface, usedSurface, unusedSurface],
                        backgroundColor: [
                            'rgba(102, 187, 106, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>
