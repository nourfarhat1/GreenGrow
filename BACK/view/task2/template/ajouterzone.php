<?php
require_once 'C:/xampp/htdocs/BACK/controller/ZoneController.php';
require_once 'C:/xampp/htdocs/BACK/model/ZoneModel.php';
require_once 'C:/xampp/htdocs/BACK/controller/FarmController.php';


$error = "";
$newZone = null;

// Create an instance of the controllers
$zoneC = new ZoneController();
$farmC = new FarmController();

if (
    isset($_POST["reference_zone"]) &&
    isset($_POST["nom"]) &&
    isset($_POST["type_zone"]) &&
    isset($_POST["superficie_zone"]) &&
    isset($_POST["culture"]) &&
    isset($_POST["reference_f"])
) {
    if (
        !empty($_POST['reference_zone']) &&
        !empty($_POST["nom"]) &&
        !empty($_POST["type_zone"]) &&
        !empty($_POST["superficie_zone"]) &&
        !empty($_POST["culture"]) &&
        !empty($_POST["reference_f"])
    ) {
        // Vérifier si la référence de la ferme existe
        $reference_f = $_POST['reference_f'];
        $farm = $farmC->showFarm($reference_f);

        if ($farm) {
            $zone = new ZoneModel(
                $_POST['reference_zone'],
                $_POST['nom'],
                $_POST['type_zone'],
                $_POST['superficie_zone'],
                $_POST['culture'],
                $_POST['reference_f']
            );
            $zoneC->addZone($zone);
            // Fetch the newly added zone to display
            $newZone = $zoneC->showZone($_POST['reference_zone']);
        } else {
            $error = "La référence de la ferme n'existe pas.";
        }
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
    <title>Ajouter Zone</title>
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

        <form action="" method="POST">
            <table>
                <tr>
                    <td><label for="reference_zone">Référence de la zone :</label></td>
                    <td>
                        <input type="text" id="reference_zone" name="reference_zone" />
                        <span id="erreurReferenceZone" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="nom">Nom de la zone :</label></td>
                    <td>
                        <input type="text" id="nom" name="nom" />
                        <span id="erreurNom" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="type_zone">Type de la zone :</label></td>
                    <td>
                        <input type="text" id="type_zone" name="type_zone" />
                        <span id="erreurTypeZone" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="superficie_zone">Superficie de la zone :</label></td>
                    <td>
                        <input type="text" id="superficie_zone" name="superficie_zone" />
                        <span id="erreurSuperficieZone" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="culture">Culture :</label></td>
                    <td>
                        <input type="text" id="culture" name="culture" />
                        <span id="erreurCulture" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="reference_f">Référence de la ferme :</label></td>
                    <td>
                        <input type="text" id="reference_f" name="reference_f" />
                        <span id="erreurReferenceF" style="color: red"></span>
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

        <?php if ($newZone): ?>
            <h2>Zone nouvellement ajoutée</h2>
            <table class="new-zone-table" border="1">
                <tr>
                    <th>Référence de la zone</th>
                    <th>Nom de la zone</th>
                    <th>Type de la zone</th>
                    <th>Superficie de la zone</th>
                    <th>Culture</th>
                    <th>Référence de la ferme</th>
                </tr>
                <tr>
                    <td><?php echo $newZone['reference_zone']; ?></td>
                    <td><?php echo $newZone['nom']; ?></td>
                    <td><?php echo $newZone['type_zone']; ?></td>
                    <td><?php echo $newZone['superficie_zone']; ?></td>
                    <td><?php echo $newZone['culture']; ?></td>
                    <td><?php echo $newZone['reference_f']; ?></td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
