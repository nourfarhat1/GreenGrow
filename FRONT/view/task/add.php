<?php
require_once 'C:/xampp/htdocs/FRONT/controller/ZoneController.php';
require_once 'C:/xampp/htdocs/FRONT/model/ZoneModel.php';
require_once 'C:/xampp/htdocs/FRONT/controller/FarmController.php';
require_once 'C:/xampp/htdocs/FRONT/config/database.php'; // Assurez-vous d'inclure le fichier de configuration de la base de données

$db = Database::connect();
$error = "";
$newZone = null;

// Create an instance of the controllers
$zoneC = new ZoneController($db);
$farmC = new FarmController($db);

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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background-color: #004d00;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .sidebar h2 {
            margin: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin-top: 10px;
        }

        .content {
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        #error {
            color: red;
            margin-bottom: 20px;
            font-weight: bold;
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form table {
            width: 100%;
            border-collapse: collapse;
        }

        form table td {
            padding: 15px;
            border: 1px solid #ddd;
        }

        form table td:first-child {
            width: 30%;
            font-weight: bold;
        }

        form table td:last-child {
            width: 70%;
        }

        form table td label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        form table td input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            background-color: #fff;
            color: #000;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        form table td input[type="text"]:focus {
            border-color: #004d00;
        }

        form table td input[type="submit"],
        form table td input[type="reset"] {
            background-color: #66bb66;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        form table td input[type="submit"]:hover,
        form table td input[type="reset"]:hover {
            background-color: #57a957;
        }

        .new-zone-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .new-zone-table th, .new-zone-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .new-zone-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

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
            transition: background-color 0.3s;
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
            border-radius: 10px;
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
            border-radius: 10px;
        }

        .route-button, .edit-button, .add-media-button, .manage-products-button, .plan-events-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
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
            border-radius: 10px;
        }

        .zone-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .zone-table th, .zone-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .zone-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .metric-section {
            margin-bottom: 20px;
        }

        .metric-section h2 {
            margin-bottom: 10px;
        }

        .metric-section p {
            margin: 0;
        }

        .zone-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .zone-list-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            flex: 1;
            min-width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .zone-list-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .zone-list-item .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #333;
        }

        .zone-list-item .info-item i {
            margin-right: 10px;
            font-size: 24px;
            color: #66bb66;
        }

        .zone-list-item .info-item span {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Gestion</h2>
        <a href="zonef.php">Retour à la liste</a>
    </div>
    <div class="content">
        <div id="error">
            <?php echo $error; ?>
        </div>

        <form id="zoneForm" action="" method="POST">
            <table>
                <tr>
                    <td><label for="reference_zone">Référence de la zone :</label></td>
                    <td>
                        <input type="text" id="reference_zone" name="reference_zone" class="form-field required" />
                        <span id="erreurReferenceZone" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="nom">Nom de la zone :</label></td>
                    <td>
                        <input type="text" id="nom" name="nom" class="form-field required" />
                        <span id="erreurNom" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="type_zone">Type de la zone :</label></td>
                    <td>
                        <input type="text" id="type_zone" name="type_zone" class="form-field required" />
                        <span id="erreurTypeZone" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="superficie_zone">Superficie de la zone :</label></td>
                    <td>
                        <input type="text" id="superficie_zone" name="superficie_zone" class="form-field required" />
                        <span id="erreurSuperficieZone" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="culture">Culture :</label></td>
                    <td>
                        <input type="text" id="culture" name="culture" class="form-field required" />
                        <span id="erreurCulture" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="reference_f">Référence de la ferme :</label></td>
                    <td>
                        <input type="text" id="reference_f" name="reference_f" class="form-field required" />
                        <span id="erreurReferenceF" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Save" class="btn-confirm">
                    </td>
                    <td>
                        <input type="reset" value="Reset" class="btn-confirm">
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

    <script>
        document.getElementById('zoneForm').addEventListener('submit', function(event) {
            var requiredFields = document.querySelectorAll('.required');
            var isValid = true;

            requiredFields.forEach(function(field) {
                if (field.value.trim() === '') {
                    isValid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '';
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires.');
            }
        });
    </script>
</body>
</html>
