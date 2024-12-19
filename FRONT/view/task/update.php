<?php
require_once 'database.php'; // Connexion à la base de données


// Vérifier si 'codeF' est passé via GET ou POST
if (isset($_GET['codeF']) || isset($_POST['codeF'])) {
    $codeF = isset($_GET['codeF']) ? $_GET['codeF'] : $_POST['codeF'];

    // Récupérer la question et la photo associée de la base de données
    $stmt = $pdo->prepare("SELECT * FROM forum WHERE codeF = :codeF");
    $stmt->execute(['codeF' => $codeF]);
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($question) {
        $categorie = $question['categorie'];
        $questionText = $question['question'];
        $photoPath = isset($question['photo_path']) ? $question['photo_path'] : '';

        // Vérification des réponses associées
        $stmt_responses = $pdo->prepare("SELECT * FROM message WHERE codeF = :codeF");
        $stmt_responses->execute(['codeF' => $codeF]);
        $responses = $stmt_responses->fetchAll(PDO::FETCH_ASSOC);

        // Traitement de la mise à jour (POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['question'])) {
            $updatedQuestion = $_POST['question'];

            // Mettre à jour la question dans la base de données
            $stmt = $pdo->prepare("UPDATE forum SET question = :question WHERE codeF = :codeF");
            $stmt->execute(['question' => $updatedQuestion, 'codeF' => $codeF]);

            // Rediriger vers la page principale après la modification
            header("Location: createclient.php");
            exit; // Fin du script après modification
        }

    } else {
        echo "Question non trouvée.";
        exit; // Arrêter le script si la question n'est pas trouvée
    }
} else {
    echo "Aucun ID de question spécifié.";
    exit; // Arrêter le script si 'codeF' n'est pas passé
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de la Question</title>
</head>
<body>
    <h1>Modifier la Question</h1>

    <!-- Vérifier s'il y a des réponses associées -->
    <?php if (!empty($responses)): ?>
        <h2>Réponses existantes</h2>
        <ul>
            <?php foreach ($responses as $response): ?>
                <li>
                    <p><strong>Réponse :</strong> <?= htmlspecialchars($response['reponse']) ?></p>
                    <p><strong>Nom Expert :</strong> <?= htmlspecialchars($response['nom_expert']) ?></p>
                    <form action="delete_response.php" method="POST" style="display:inline;">
                        <input type="hidden" name="ID_rep" value="<?= htmlspecialchars($response['ID_rep']) ?>">
                        <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette réponse ?')">Supprimer la réponse</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        <p>Veuillez gérer les réponses avant de modifier la question.</p>
    <?php endif; ?>

    <form action="update.php?codeF=<?= htmlspecialchars($codeF) ?>" method="POST">
        <label for="categorie">Catégorie :</label>
        <input type="text" name="categorie" value="<?= htmlspecialchars($categorie) ?>" disabled><br><br>

        <label for="question">Question :</label>
        <textarea name="question" id="question" required><?= htmlspecialchars($questionText) ?></textarea><br><br>

        <?php if ($photoPath): ?>
            <label for="photo_path">Photo :</label>
            <img src="<?= htmlspecialchars($photoPath) ?>" alt="Photo" style="max-width: 100%; height: auto;"><br><br>
        <?php endif; ?>

        <button type="submit">Modifier la question</button>
    </form>
</body>
</html>
