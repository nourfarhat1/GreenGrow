<?php
require_once 'C:/xampp/htdocs/FRONT/config/database.php';
require_once 'C:/xampp/htdocs/FRONT/controller/cont1.php';

$db = Database::connect();

$farmController = new FarmController($db);
$farm = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference_f = $_POST['reference_f'];
    $farm = $farmController->showFarm($reference_f);
}
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        .form-field {
            background-color: #004d00;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: white;
        }
        .form-field label {
            color: white;
        }
        .btn-confirm {
            background-color: #66bb66;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-confirm:hover {
            background-color: #57a957;
        }
        .farm-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .farm-header {
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .farm-header h1 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        .farm-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .farm-name {
            font-size: 24px;
            margin-right: 10px;
        }
        .farm-reference {
            font-size: 16px;
            color: #666;
        }
        .farm-location, .farm-surface, .farm-description, .farm-media, .farm-products, .farm-certifications, .farm-events, .farm-contact, .farm-management, .farm-statistics, .farm-notifications {
            margin-bottom: 20px;
        }
        .farm-location #map, .farm-surface .surface-graph, .farm-media .media-gallery {
            height: 200px;
            background-color: #e0e0e0;
            margin-bottom: 10px;
        }
        .route-button, .edit-button, .add-media-button, .manage-products-button, .plan-events-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .route-button:hover, .edit-button:hover, .add-media-button:hover, .manage-products-button:hover, .plan-events-button:hover {
            background-color: #0056b3;
        }
        .surface-icon {
            font-size: 20px;
            margin-right: 5px;
        }
        #map {
            height: 300px;
        }
        .add-farm-button, .manage-zones-button {
            background-color: #66bb66;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .add-farm-button:hover, .manage-zones-button:hover {
            background-color: #57a957;
        }
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
                    <form method="POST" action="farm.php">
                        <input type="text" id="farm-input" name="reference_f" placeholder="Entrez la référence de la ferme" required>
                        <button class="btn-confirm" type="submit">Confirmer</button>
                    </form>
                    <!-- Ajouter le bouton ici -->
                    <a href="addfarm.php" class="btn-confirm add-farm-button">Ajouter une ferme</a>
                    <!-- Ajouter le bouton de gestion des zones ici -->
                    <a href="zonef.php" class="btn-confirm manage-zones-button">Gestion des zones</a>
                </header>
                <?php if ($farm): ?>
                    <section class="farm-location">
                        <h2>Localisation</h2>
                        <div id="map"></div>
                        <p id="farm-address">Adresse: <?php echo htmlspecialchars($farm['localisation']); ?></p>
                    </section>
                    <section class="farm-surface">
                        <h2>Superficie Totale</h2>
                        <p><span class="surface-icon">&#127793;</span> <span id="farm-surface"><?php echo htmlspecialchars($farm['superficie_totale']); ?></span> m²</p>
                        <div class="surface-graph">
                            <canvas id="surfaceChart"></canvas>
                        </div>
                    </section>
                <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <p>Aucune ferme trouvée avec cette référence.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        <?php if ($farm): ?>
            var map = L.map('map').setView([<?php echo $farm['latitude']; ?>, <?php echo $farm['longitude']; ?>], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([<?php echo $farm['latitude']; ?>, <?php echo $farm['longitude']; ?>])
                .addTo(map)
                .bindPopup("<b><?php echo htmlspecialchars($farm['reference_f']); ?></b><br><?php echo htmlspecialchars($farm['localisation']); ?>")
                .openPopup();

            // Mettre à jour le graphique de surface
            var ctx = document.getElementById('surfaceChart').getContext('2d');
            var surfaceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Superficie Totale'],
                    datasets: [{
                        label: 'Superficie (m²)',
                        data: [<?php echo htmlspecialchars($farm['superficie_totale']); ?>],
                        backgroundColor: ['#66bb66']
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
