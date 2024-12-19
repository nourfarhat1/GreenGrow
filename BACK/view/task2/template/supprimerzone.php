<?php
require_once 'C:/xampp/htdocs/BACK/controller/ZoneController.php';
require_once 'C:/xampp/htdocs/BACK/model/ZoneModel.php';

$error = "";
$zone = null;
$zones = [];
$deletedReference = null;

// Create an instance of the controller
$zoneC = new ZoneController();

if (isset($_GET['reference_zone'])) {
    $zone = $zoneC->showZone($_GET['reference_zone']);
    if (!$zone) {
        $error = "Aucune zone trouvée avec cette référence.";
    } else {
        $zoneC->deleteZone($_GET['reference_zone']);
        $error = "La zone a été supprimée avec succès.";
        $deletedReference = $_GET['reference_zone'];
        // Fetch the list of zones after deletion
        $zones = $zoneC->listZones()->fetchAll();
    }
} else {
    // Fetch the list of zones if no reference is provided
    $zones = $zoneC->listZones()->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une zone</title>
    <link rel="stylesheet" href="styles2.css">
    <script src="saisir.js"></script>
</head>

<body>
    <div class="sidebar">
        <h2>Farm Management</h2>
        <a href="indexf.php">Back to list</a>
    </div>
    <div class="content">
        <div id="error">
            <?php echo $error; ?>
        </div>
        <div class="modify-form-container">
            <form class="modify-form" action="supprimerzone.php" method="GET">
                <label for="reference_zone">Référence de la zone à supprimer :</label>
                <input type="text" id="reference_zone" name="reference_zone" required>
                <input type="submit" value="Supprimer">
            </form>
        </div>

        <?php if ($deletedReference): ?>
            <h2>Référence supprimée : <?php echo htmlspecialchars($deletedReference); ?></h2>
        <?php endif; ?>

        <?php if (!empty($zones)): ?>
            <h2>Liste des zones</h2>
            <table class="new-zone-table" border="1">
                <tr>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Type de la zone</th>
                    <th>Superficie de la zone</th>
                    <th>Culture</th>
                    <th>Référence de la ferme</th>
                </tr>
                <?php foreach ($zones as $zone): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($zone['reference_zone']); ?></td>
                        <td><?php echo htmlspecialchars($zone['nom']); ?></td>
                        <td><?php echo htmlspecialchars($zone['type_zone']); ?></td>
                        <td><?php echo htmlspecialchars($zone['superficie_zone']); ?></td>
                        <td><?php echo htmlspecialchars($zone['culture']); ?></td>
                        <td><?php echo htmlspecialchars($zone['reference_f']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>
