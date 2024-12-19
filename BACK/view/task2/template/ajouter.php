<?php
require_once 'C:/xampp/htdocs/BACK/controller/FarmController.php';
require_once 'C:/xampp/htdocs/BACK/model/FarmModel.php';


$error = "";
$newFarm = null;

// Create an instance of the controller
$farmC = new FarmController();
if (
    isset($_POST["reference_f"]) &&
    isset($_POST["localisation"]) &&
    isset($_POST["superficie_totale"])
) {
    if (
        !empty($_POST['reference_f']) &&
        !empty($_POST["localisation"]) &&
        !empty($_POST["superficie_totale"])
    ) {
        $farm = new FarmModel(
            $_POST['reference_f'],
            $_POST['localisation'],
            $_POST['superficie_totale']
        );
        $farmC->addFarm($farm);
        // Fetch the newly added farm to display
        $newFarm = $farmC->showFarm($_POST['reference_f']);
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
    <title>Ajouter une ferme</title>
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

        <form action="" method="POST">
            <table>
                <tr>
                    <td><label for="reference_f">Référence :</label></td>
                    <td>
                        <input type="text" id="reference_f" name="reference_f" />
                        <span id="erreurReference" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="localisation">Localisation :</label></td>
                    <td>
                        <input type="text" id="localisation" name="localisation" />
                        <span id="erreurLocalisation" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="superficie_totale">Superficie totale :</label></td>
                    <td>
                        <input type="text" id="superficie_totale" name="superficie_totale" />
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

        <?php if ($newFarm): ?>
            <h2>Ferme nouvellement ajoutée</h2>
            <table class="new-farm-table" border="1">
                <tr>
                    <th>Référence</th>
                    <th>Localisation</th>
                    <th>Superficie totale</th>
                </tr>
                <tr>
                    <td><?php echo $newFarm['reference_f']; ?></td>
                    <td><?php echo $newFarm['localisation']; ?></td>
                    <td><?php echo $newFarm['superficie_totale']; ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>
