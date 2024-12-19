<?php
require_once 'C:/xampp/htdocs/BACK/controller/FarmController.php';
require_once 'C:/xampp/htdocs/BACK/model/FarmModel.php';



$error = "";
$farm = null;

// Create an instance of the controller
$farmC = new FarmController();

if (isset($_GET['reference_f'])) {
    $farm = $farmC->showFarm($_GET['reference_f']);
    if (!$farm) {
        $error = "Aucune ferme trouvée avec cette référence.";
    }
}

if (isset($_POST["reference_f"]) && isset($_POST["localisation"]) && isset($_POST["superficie_totale"])) {
    if (!empty($_POST['reference_f']) && !empty($_POST["localisation"]) && !empty($_POST["superficie_totale"])) {
        $farm = new FarmModel(
            $_POST['reference_f'],
            $_POST['localisation'],
            $_POST['superficie_totale']
        );
        $farmC->updateFarm($farm, $_POST['reference_f']);
        // Fetch the updated farm to display
        $farm = $farmC->showFarm($_POST['reference_f']);
    } else {
        $error = "Missing information";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une ferme</title>
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

        <?php if (!$farm): ?>
            <form class="modify-form" action="modifier.php" method="GET">
                <label for="reference_f">Référence de la ferme à modifier :</label>
                <input type="text" id="reference_f" name="reference_f" required>
                <input type="submit" value="Modifier">
            </form>
        <?php else: ?>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td><label for="reference_f">Référence :</label></td>
                        <td>
                            <input type="text" id="reference_f" name="reference_f" value="<?php echo htmlspecialchars($farm['reference_f']); ?>" readonly />
                            <span id="erreurReference" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="localisation">Localisation :</label></td>
                        <td>
                            <input type="text" id="localisation" name="localisation" value="<?php echo htmlspecialchars($farm['localisation']); ?>" />
                            <span id="erreurLocalisation" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="superficie_totale">Superficie totale :</label></td>
                        <td>
                            <input type="text" id="superficie_totale" name="superficie_totale" value="<?php echo htmlspecialchars($farm['superficie_totale']); ?>" />
                            <span id="erreurSuperficie" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Save">
                        </td>
                        <td>
                            <input type="reset" value="Reset">
                        </td>
                    </tr>
                </table>
            </form>
            <?php if ($farm): ?>
                <h2>Ferme modifiée</h2>
                <table class="new-farm-table" border="1">
                    <tr>
                        <th>Référence</th>
                        <th>Localisation</th>
                        <th>Superficie totale</th>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($farm['reference_f']); ?></td>
                        <td><?php echo htmlspecialchars($farm['localisation']); ?></td>
                        <td><?php echo htmlspecialchars($farm['superficie_totale']); ?></td>
                    </tr>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>

</html>
