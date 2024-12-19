<?php
require_once 'C:/xampp/htdocs/FRONT/config/database.php';
require_once 'C:/xampp/htdocs/FRONT/model/FarmModel.php';
require_once 'C:/xampp/htdocs/FRONT/controller/FarmController.php';
require_once 'C:/xampp/htdocs/FRONT/controller/ZoneController.php';

$db = Database::connect();
$error = "";
$newFarm = null;

// Create an instance of the controllers
$farmC = new FarmController($db);
$zoneC = new ZoneController($db);

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
    <title>Ajouter Ferme</title>
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

        .new-farm-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .new-farm-table th, .new-farm-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .new-farm-table th {
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
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Gestion</h2>
        <a href="farm.php">Retour à la liste</a>
    </div>
    <div class="content">
        <div id="error">
            <?php echo $error; ?>
        </div>

        <form id="farmForm" action="" method="POST">
            <table>
                <tr>
                    <td><label for="reference_f">Référence de la ferme :</label></td>
                    <td>
                        <input type="text" id="reference_f" name="reference_f" class="form-field required" />
                        <span id="erreurReferenceF" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="localisation">Localisation :</label></td>
                    <td>
                        <input type="text" id="localisation" name="localisation" class="form-field required" />
                        <span id="erreurLocalisation" style="color: red"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="superficie_totale">Superficie totale :</label></td>
                    <td>
                        <input type="text" id="superficie_totale" name="superficie_totale" class="form-field required" />
                        <span id="erreurSuperficieTotale" style="color: red"></span>
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

        <?php if ($newFarm): ?>
            <h2>Ferme nouvellement ajoutée</h2>
            <table class="new-farm-table" border="1">
                <tr>
                    <th>Référence de la ferme</th>
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

    <script>
        document.getElementById('farmForm').addEventListener('submit', function(event) {
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
