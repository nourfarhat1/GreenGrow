<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Irrigation</title>
</head>
<body>
    <h2>Historique d'Irrigation</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Lieu</th>
                <th>Type de sol</th>
                <th>Type de culture</th>
                <th>Superficie (ha)</th>
                <th>Quantité d'eau (m³)</th>
                <th>ID Météo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_irrigation']) ?></td>
                    <td><?= htmlspecialchars($row['lieu']) ?></td>
                    <td><?= htmlspecialchars($row['type_de_sol']) ?></td>
                    <td><?= htmlspecialchars($row['type_de_culture']) ?></td>
                    <td><?= htmlspecialchars($row['superficie']) ?></td>
                    <td><?= htmlspecialchars($row['quantite_eau']) ?></td>
                    <td><?= htmlspecialchars($row['id_meteo']) ?></td>
                    <td>
    <!-- Formulaire pour le bouton Supprimer -->
    <form action="gerer.php" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cette ligne ?');">
        <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['id_irrigation']) ?>">
        <button type="submit" style="color: red;">Supprimer</button>
    </form>
    <br>
    <!-- Formulaire pour le bouton Modifier -->
    <form action="gerer.php" method="post">
        <input type="hidden" name="update_id" value="<?= htmlspecialchars($row['id_irrigation']) ?>">
        
        <label for="attribute_name">Choisissez l'attribut à modifier :</label>
        <select name="attribute_name" id="attribute_name" required>
            <option value="lieu">Lieu</option>
            <option value="type_de_sol">Type de sol</option>
            <option value="type_de_culture">Type de culture</option>
            <option value="superficie">Superficie</option>
            <option value="quantite_eau">Quantité d'eau</option>
            <option value="id_meteo">ID Météo</option>
        </select>
        
        <label for="attribute_value">Nouvelle valeur :</label>
        <input type="text" name="attribute_value" id="attribute_value" required>
        
        <button type="submit" style="color: blue;">Mettre à jour</button>
    </form>
</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
