<?php
require_once 'C:/xampp/htdocs/BACK/controller/FarmController.php';
require_once 'C:/xampp/htdocs/BACK/model/FarmModel.php';



$farmController = new FarmController();
$farm = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference_f = $_POST['reference_f'];
    $farm = $farmController->showFarm($reference_f);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Ferme</title>
    <link rel="stylesheet" href="styles2.css">
    <style>
        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background-color: #228B22; /* Changer la couleur de fond */
            color: white; /* Changer la couleur du texte */
            border: 1px solid #116A11;
            border-radius: 10px;
            padding: 20px;
            width: 150px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin-top: 0;
        }
        .card p {
            margin: 5px 0;
        }
        .card .icon {
            font-size: 36px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Farm Management</h2>
        <a href="indexf.php">Back to list</a>
    </div>
    <div class="content">
        <h1>Recherche de Ferme</h1>
        <form method="POST" action="recherche.php">
            <table>
                <tr>
                    <td><label for="reference_f">Référence de la ferme :</label></td>
                    <td>
                        <input type="text" id="reference_f" name="reference_f" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Rechercher">
                    </td>
                    <td>
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>

        <?php if ($farm): ?>
            <div class="card-container">
                <div class="card">
                    <h3>Référence</h3>
                    <p><?php echo htmlspecialchars($farm['reference_f']); ?></p>
                    <div class="icon">&#x1F33F;</div> <!-- Farm icon for reference -->
                </div>
                <div class="card">
                    <h3>Localisation</h3>
                    <p><?php echo htmlspecialchars($farm['localisation']); ?></p>
                    <div class="icon">&#x1F30D;</div> <!-- Map icon for location -->
                </div>
                <div class="card">
                    <h3>Superficie Totale</h3>
                    <p><?php echo htmlspecialchars($farm['superficie_totale']); ?> ha</p>
                    <div class="icon">&#x1F333;</div> <!-- Field icon for area -->
                </div>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>Aucune ferme trouvée avec cette référence.</p>
        <?php endif; ?>
    </div>
</body>
</html>
