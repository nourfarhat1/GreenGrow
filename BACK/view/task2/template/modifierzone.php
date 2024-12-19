<?php
require_once 'C:/xampp/htdocs/BACK/controller/ZoneController.php';
require_once 'C:/xampp/htdocs/BACK/model/ZoneModel.php';

$error = "";
$zone = null;

// Create an instance of the controller
$zoneC = new ZoneController();

if (isset($_GET['reference_zone'])) {
    $zone = $zoneC->showZone($_GET['reference_zone']);
    if (!$zone) {
        $error = "Aucune zone trouvée avec cette référence.";
    }
}

if (isset($_POST["reference_zone"]) && isset($_POST["nom"]) && isset($_POST["type_zone"]) && isset($_POST["superficie_zone"]) && isset($_POST["culture"]) && isset($_POST["reference_f"])) {
    if (!empty($_POST['reference_zone']) && !empty($_POST["nom"]) && !empty($_POST["type_zone"]) && !empty($_POST["superficie_zone"]) && !empty($_POST["culture"]) && !empty($_POST["reference_f"])) {
        $zone = new ZoneModel(
            $_POST['reference_zone'],
            $_POST['nom'],
            $_POST['type_zone'],
            $_POST['superficie_zone'],
            $_POST['culture'],
            $_POST['reference_f']
        );
        $zoneC->updateZone($zone, $_POST['reference_zone']);
        // Fetch the updated zone to display
        $zone = $zoneC->showZone($_POST['reference_zone']);
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
    <title>Modifier une zone</title>
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

        <?php if (!$zone): ?>
            <form class="modify-form" action="modifierzone.php" method="GET">
                <label for="reference_zone">Référence de la zone à modifier :</label>
                <input type="text" id="reference_zone" name="reference_zone" required>
                <input type="submit" value="Modifier">
            </form>
        <?php else: ?>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td><label for="reference_zone">Référence :</label></td>
                        <td>
                            <input type="text" id="reference_zone" name="reference_zone" value="<?php echo htmlspecialchars($zone['reference_zone']); ?>" readonly />
                            <span id="erreurReferenceZone" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="nom">Nom :</label></td>
                        <td>
                            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($zone['nom']); ?>" />
                            <span id="erreurNom" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="type_zone">Type de la zone :</label></td>
                        <td>
                            <input type="text" id="type_zone" name="type_zone" value="<?php echo htmlspecialchars($zone['type_zone']); ?>" />
                            <span id="erreurTypeZone" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="superficie_zone">Superficie de la zone :</label></td>
                        <td>
                            <input type="text" id="superficie_zone" name="superficie_zone" value="<?php echo htmlspecialchars($zone['superficie_zone']); ?>" />
                            <span id="erreurSuperficieZone" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="culture">Culture :</label></td>
                        <td>
                            <input type="text" id="culture" name="culture" value="<?php echo htmlspecialchars($zone['culture']); ?>" />
                            <span id="erreurCulture" style="color: red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="reference_f">Référence de la ferme :</label></td>
                        <td>
                            <input type="text" id="reference_f" name="reference_f" value="<?php echo htmlspecialchars($zone['reference_f']); ?>" />
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
            <?php if ($zone): ?>
                <h2>Zone modifiée</h2>
                <table class="new-zone-table" border="1">
                    <tr>
                        <th>Référence</th>
                        <th>Nom</th>
                        <th>Type de la zone</th>
                        <th>Superficie de la zone</th>
                        <th>Culture</th>
                        <th>Référence de la ferme</th>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($zone['reference_zone']); ?></td>
                        <td><?php echo htmlspecialchars($zone['nom']); ?></td>
                        <td><?php echo htmlspecialchars($zone['type_zone']); ?></td>
                        <td><?php echo htmlspecialchars($zone['superficie_zone']); ?></td>
                        <td><?php echo htmlspecialchars($zone['culture']); ?></td>
                        <td><?php echo htmlspecialchars($zone['reference_f']); ?></td>
                    </tr>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>

</html>
