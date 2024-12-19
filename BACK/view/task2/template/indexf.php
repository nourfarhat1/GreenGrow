<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Management</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div class="sidebar">
        <h2>Farm Management</h2>
        <a href="#" onclick="showZoneOptions()">Manage Zones</a>
        <a href="#" onclick="showFarmOptions()">Manage Farm</a>
    </div>
    <div class="content">
        <h1>Farm and Zone Management</h1>
        <div id="farmOptions" class="farm-options" style="display: none;">
            <button onclick="window.location.href='ajouter.php'">Ajouter une ferme</button>
            <button onclick="window.location.href='modifier.php'">Modifier une ferme</button>
            <button onclick="window.location.href='supprimer.php'">Supprimer une ferme</button>
            <button onclick="window.location.href='recherche.php'">recherche une ferme</button>
        </div>
        <div id="zoneOptions" class="farm-options" style="display: none;">
            <button onclick="window.location.href='ajouterzone.php'">Ajouter une zone</button>
            <button onclick="window.location.href='modifierzone.php'">Modifier une zone</button>
            <button onclick="window.location.href='supprimerzone.php'">Supprimer une zone</button>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
