<?php
require_once 'C:/xampp/htdocs/BACK/controller/FarmController.php';
require_once 'C:/xampp/htdocs/BACK/model/FarmModel.php';



$error = "";
$farm = null;
$farms = [];
$deletedReference = null;

// Create an instance of the controller
$farmC = new FarmController();

if (isset($_GET['reference_f'])) {
    $farm = $farmC->showFarm($_GET['reference_f']);
    if (!$farm) {
        $error = "Aucune ferme trouvée avec cette référence.";
    } else {
        $farmC->deleteFarm($_GET['reference_f']);
        $error = "La ferme a été supprimée avec succès.";
        $deletedReference = $_GET['reference_f'];
        // Fetch the list of farms after deletion
        $farms = $farmC->listFarms()->fetchAll();
    }
} else {
    // Fetch the list of farms if no reference is provided
    $farms = $farmC->listFarms()->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une ferme</title>
    <link rel="stylesheet" href="styles.css">
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
            <form class="modify-form" action="supprimer.php" method="GET">
                <label for="reference_f">Référence de la ferme à supprimer :</label>
                <input type="text" id="reference_f" name="reference_f" required>
                <input type="submit" value="Supprimer">
            </form>
        </div>

        <?php if ($deletedReference): ?>
            <h2>Référence supprimée : <?php echo htmlspecialchars($deletedReference); ?></h2>
        <?php endif; ?>

        <?php if (!empty($farms)): ?>
            <h2>Liste des fermes</h2>
            <table class="new-farm-table" border="1">
                <tr>
                    <th>Référence</th>
                    <th>Localisation</th>
                    <th>Superficie totale</th>
                </tr>
                <?php foreach ($farms as $farm): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($farm['reference_f']); ?></td>
                        <td><?php echo htmlspecialchars($farm['localisation']); ?></td>
                        <td><?php echo htmlspecialchars($farm['superficie_totale']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>
