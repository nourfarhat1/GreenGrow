<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique Météo</title>
    <style>
        /* Style global */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a8e6cf, #dcedc1); /* Dégradé doux vert */
            color: #2c3e50; /* Couleur du texte gris foncé */
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            color: #4caf50; /* Vert vif pour le titre */
            font-size: 2em;
            margin-top: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Ombre douce pour le titre */
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Ombre plus légère */
            overflow: hidden;
        }

        th, td {
            padding: 8px; /* Taille encore plus réduite */
            text-align: center;
            border: 1px solid #81c784; /* Bordure verte douce */
        }

        th {
            background-color: #388e3c; /* Vert forêt pour l'en-tête */
            color: white;
            font-size: 1em;
            text-transform: uppercase;
        }

        td {
            background-color: #f1f8e9; /* Fond vert pâle pour les cellules */
            color: #2c3e50;
            font-size: 0.9em; /* Réduction de la taille du texte */
        }

        tr:nth-child(even) td {
            background-color: #e8f5e9; /* Fond plus clair pour les lignes paires */
        }

        /* Boutons de modification et suppression */
        button {
            padding: 6px 12px; /* Taille plus petite */
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.8em; /* Réduction de la taille du texte */
        }

        button[type="submit"]:first-child {
            background-color: #ffffff; /* Rouge corail pour supprimer */
            color: white;
        }

        button[type="submit"]:first-child:hover {
            background-color: #ffffff; /* Rouge plus foncé au survol */
        }

        button[type="submit"]:last-child {
            background-color: #81c784; /* Vert doux pour modifier */
            color: white;
        }

        button[type="submit"]:last-child:hover {
            background-color: #fff; /* Vert plus vif au survol */
        }

        /* Formulaire de modification */
        select, input[type="text"] {
            padding: 6px 10px; /* Taille plus petite des champs de formulaire */
            border: 1px solid #81c784;
            border-radius: 5px;
            font-size: 0.8em; /* Réduction de la taille du texte */
            margin-top: 8px;
            width: 180px; /* Largeur encore réduite pour un design compact */
        }

        select {
            width: 200px;
        }

        input[type="text"] {
            width: 180px;
        }

        label {
            font-size: 0.9em; /* Réduction de la taille des labels */
            color: #388e3c;
            margin-right: 6px;
        }

        /* Mise en forme de l'alerte de confirmation */
        form[onsubmit="return confirm('Voulez-vous vraiment supprimer cette ligne ?');"] {
            display: inline;
            margin: 0 4px;
        }

        /* Style général des formulaires */
        .form-container {
            text-align: center;
            margin-top: 12px;
        }

        /* Style pour les messages de confirmation */
        .alert {
            background-color: #ffeb3b;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin: 8px auto;
            width: 55%;
        }

        /* Responsive design pour les petits écrans */
        @media (max-width: 768px) {
            table {
                width: 100%;
                margin: 15px 0;
            }

            h2 {
                font-size: 1.8em;
            }

            button {
                padding: 6px 10px; /* Boutons encore plus petits */
                font-size: 0.75em; /* Texte encore plus petit */
            }
        }
    </style>
</head>
<body>
    <h2>Historique Météo</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Température (°C)</th>
                <th>Vent (km/h)</th>
                <th>Humidité (%)</th>
                <th>Précipitation (mm)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_meteo']) ?></td>
                    <td><?= htmlspecialchars($row['temperature']) ?></td>
                    <td><?= htmlspecialchars($row['vent']) ?></td>
                    <td><?= htmlspecialchars($row['humidite']) ?></td>
                    <td><?= htmlspecialchars($row['precipitation']) ?></td>
                    <td><?= htmlspecialchars($row['date_meteo']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
