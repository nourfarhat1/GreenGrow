<?php
require_once 'database.php'; // Connexion à la base de données

// Fonction pour récupérer les questions
function getQuestions($pdo, $categorie = null, $searchTerm = null) {
    if ($searchTerm) {
        $query = "SELECT * FROM forum WHERE question LIKE :searchTerm ORDER BY date_f DESC, heure_f DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':searchTerm' => '%' . $searchTerm . '%']);
    } elseif ($categorie) {
        $query = "SELECT * FROM forum WHERE categorie = :categorie ORDER BY date_f DESC, heure_f DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':categorie' => $categorie]);
    } else {
        $query = "SELECT * FROM forum ORDER BY date_f DESC, heure_f DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les questions avec réponses
function getQuestionsWithResponses($pdo, $categorie = null, $searchTerm = null) {
    if ($searchTerm) {
        $query = "SELECT f.codeF, f.categorie, f.question, f.photo_path, m.reponse, m.nom_expert, m.date, m.heure, f.likes, f.dislikes
                  FROM forum f
                  JOIN message m ON f.codeF = m.codeF
                  WHERE f.question LIKE :searchTerm
                  ORDER BY f.date_f DESC, f.heure_f DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':searchTerm' => '%' . $searchTerm . '%']);
    } elseif ($categorie) {
        $query = "SELECT f.codeF, f.categorie, f.question, f.photo_path, m.reponse, m.nom_expert, m.date, m.heure, f.likes, f.dislikes
                  FROM forum f
                  JOIN message m ON f.codeF = m.codeF
                  WHERE f.categorie = :categorie
                  ORDER BY f.date_f DESC, f.heure_f DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':categorie' => $categorie]);
    } else {
        $query = "SELECT f.codeF, f.categorie, f.question, f.photo_path, m.reponse, m.nom_expert, m.date, m.heure, f.likes, f.dislikes
                  FROM forum f
                  JOIN message m ON f.codeF = m.codeF
                  ORDER BY f.date_f DESC, f.heure_f DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération des catégories disponibles
$categories = [];
$stmt = $pdo->prepare("SELECT DISTINCT categorie FROM forum");
if ($stmt->execute()) {
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
} else {
    // Handle query execution error
    echo "<script>alert('Erreur lors de la récupération des catégories.');</script>";
}

// Récupération de la catégorie sélectionnée
$categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : null;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;

// Récupération des questions
$questions = getQuestions($pdo, $categorie, $searchTerm);
$questionsWithResponses = getQuestionsWithResponses($pdo, $categorie, $searchTerm);

// Vérification si des questions ont été trouvées
$noQuestions = empty($questions) && empty($questionsWithResponses);

// Ajouter une nouvelle question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nom_utilisateur = isset($_POST['nom_utilisateur']) ? trim($_POST['nom_utilisateur']) : null;
    $categorie = isset($_POST['categorie']) ? trim($_POST['categorie']) : null;
    $question = isset($_POST['question']) ? trim($_POST['question']) : null;

    if (!$nom_utilisateur || !$categorie || !$question) {
        echo "<script>alert('Tous les champs sont obligatoires.');</script>";
        exit;
    }

    // Gestion de la photo
    $photo_path = null;
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/";
        $photo_path = $target_dir . basename($_FILES['photo']['name']);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            echo "<script>alert('Erreur lors du téléchargement de la photo.');</script>";
            exit;
        }
    }

    // Insertion de la question
    $stmt = $pdo->prepare("
        INSERT INTO forum (nom_utilisateur, categorie, question, photo_path, date_f, heure_f)
        VALUES (:nom_utilisateur, :categorie, :question, :photo_path, CURDATE(), CURTIME())
    ");
    $stmt->execute([
        ':nom_utilisateur' => $nom_utilisateur,
        ':categorie' => $categorie,
        ':question' => $question,
        ':photo_path' => $photo_path
    ]);
    echo "<script>alert('Votre question a été envoyée avec succès.');</script>";
    header("Location: createclient.php");
    exit;
}

// Modifier une question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'update') {
    $codeF = $_POST['codeF'];
    $question = $_POST['question'];

    $stmt = $pdo->prepare("UPDATE forum SET question = :question WHERE codeF = :codeF");
    $stmt->execute([
        ':question' => $question,
        ':codeF' => $codeF
    ]);
    echo "<script>alert('La question a été mise à jour.');</script>";
    header("Location: createclient.php");
    exit;
}

// Supprimer une question
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $codeF = $_POST['codeF'];

    $stmt = $pdo->prepare("DELETE FROM forum WHERE codeF = :codeF");
    $stmt->execute([':codeF' => $codeF]);
    echo "<script>alert('La question a été supprimée.');</script>";
    header("Location: createclient.php");
    exit;
}

// Gérer l'action "J'aime"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'like') {
    $codeF = $_POST['codeF'];

    // Vérifier si la question a des réponses avant d'incrémenter le like
    $stmt = $pdo->prepare("SELECT COUNT(codeF) FROM message WHERE codeF = :codeF");
    $stmt->execute([':codeF' => $codeF]);
    $hasReplies = $stmt->fetchColumn() > 0;

    if ($hasReplies) {
        // Incrémenter le nombre de likes pour cette question
        $stmt = $pdo->prepare("UPDATE forum SET likes = likes + 1 WHERE codeF = :codeF");
        $stmt->execute([':codeF' => $codeF]);
        echo "<script>alert('Like ajouté.');</script>";
    } else {
        echo "<script>alert('La question n\'a pas de réponses.');</script>";
    }
    header("Location: createclient.php");
    exit;
}

// Gérer l'action "Je n'aime pas"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'dislike') {
    $codeF = $_POST['codeF'];

    // Vérifier si la question a des réponses avant d'incrémenter le dislike
    $stmt = $pdo->prepare("SELECT COUNT(codeF) FROM message WHERE codeF = :codeF");
    $stmt->execute([':codeF' => $codeF]);
    $hasReplies = $stmt->fetchColumn() > 0;

    if ($hasReplies) {
        // Incrémenter le nombre de dislikes pour cette question
        $stmt = $pdo->prepare("UPDATE forum SET dislikes = dislikes + 1 WHERE codeF = :codeF");
        $stmt->execute([':codeF' => $codeF]);
        echo "<script>alert('Dislike ajouté.');</script>";
    } else {
        echo "<script>alert('La question n\'a pas de réponses.');</script>";
    }
    header("Location: createclient.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Agricole </title>
    <link rel="stylesheet" href="forum.css">
    <style>
        /* Style pour la zone de recherche */
        .search-container {
            display: flex;
            justify-content: center; /* Centre la barre de recherche horizontalement */
            margin: 20px auto; /* Ajout de marge pour centrer verticalement */
            width: 100%; /* Largeur de la zone */
            max-width: 800px; /* Limite la largeur maximale */
        }

        /* Style pour l'input de recherche */
        .search-container input[type="text"] {
            width: 100%; /* Largeur de l'input */
            max-width: 600px; /* Limite la largeur maximale */
            padding: 12px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Style du bouton de recherche */
        .search-container button {
            width: 100%;
            max-width: 600px;
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-container button:hover {
            background-color: #45a049;
        }

        /* Style pour les boutons d'affichage et de masquage */
        .toggle-buttons {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .toggle-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .toggle-buttons button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Formulaire de recherche -->
    <div class="search-container <?php echo $isBlocked ? 'disabled' : ''; ?>">
        <form action="createclient.php" method="GET">
            <input type="text" name="search" id="search" placeholder="Rechercher une question..." value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <div class="forum-section <?php echo $isBlocked ? 'disabled' : ''; ?>">
        <!-- Formulaire pour ajouter une question -->
        <h2>Poser une question</h2>
        <form action="createclient.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="create">
            <label for="nom_utilisateur">Votre nom :</label>
            <input type="text" name="nom_utilisateur" id="nom_utilisateur" required><br><br>

            <label for="categorie">Choisissez une catégorie :</label>
            <select name="categorie" id="categorie" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="question">Votre question :</label>
            <textarea name="question" id="question" required></textarea><br><br>

            <label for="photo">Ajouter une photo (optionnel) :</label>
            <input type="file" name="photo" id="photo" accept="image/*"><br><br>

            <button type="submit">Envoyer la question</button>
        </form>

        <hr>

        <!-- Navigation par catégories -->
        <nav class="categories-nav">
            <a href="createclient.php">Toutes les catégories</a>
            <?php foreach ($categories as $cat): ?>
                <a href="createclient.php?categorie=<?= urlencode($cat) ?>">
                    <?= htmlspecialchars($cat) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <hr>

        <!-- Boutons pour afficher et masquer les questions -->
        <div class="toggle-buttons">
            <button id="showButton" onclick="showQuestions()">Afficher les questions</button>
            <button id="hideButton" onclick="hideQuestions()" style="display: none;">Masquer les questions</button>
        </div>

        <!-- Affichage des questions -->
        <h2>Questions</h2>
        <div id="questionsSection" style="display: none;">
            <?php if ($noQuestions && $searchTerm): ?>
                <!-- Ne rien afficher si aucune question n'est trouvée pour la recherche -->
            <?php elseif ($noQuestions): ?>
                <p>Il n'y a pas de questions pour cette catégorie...</p>
            <?php else: ?>
                <?php foreach ($questions as $question): ?>
                    <div class="post">
                        <div class="headerr">
                            <strong>ID :</strong> <?= htmlspecialchars($question['codeF']) ?> |
                            <strong>Catégorie :</strong> <?= htmlspecialchars($question['categorie']) ?> |
                            <strong>Date :</strong> <?= htmlspecialchars($question['date_f']) ?> |
                            <strong>Heure :</strong> <?= htmlspecialchars($question['heure_f']) ?>
                        </div>
                        <p><strong>Question :</strong> <?= htmlspecialchars($question['question']) ?></p>

                        <?php if (!empty($question['photo_path'])): ?>
                            <p><strong>Photo associée :</strong></p>
                            <img src="<?= htmlspecialchars($question['photo_path']) ?>" alt="Photo de la question" style="max-width: 200px; height: auto;">
                        <?php endif; ?>

                        <!-- Boutons Modifier et Supprimer -->
                        <form action="createclient.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                            <textarea name="question"><?= htmlspecialchars($question['question']) ?></textarea>
                            <button type="submit">Modifier</button>
                        </form>

                        <form action="createclient.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                            <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette question ?');">Supprimer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <hr>

        <!-- Affichage des anciennes questions avec réponses -->
        <h2>Anciennes Questions avec Réponses</h2>
        <div id="answeredQuestionsSection" style="display: none;">
            <?php if ($noQuestions && $searchTerm): ?>
                <!-- Ne rien afficher si aucune question n'est trouvée pour la recherche -->
            <?php elseif ($noQuestions): ?>
                <p>Il n'y a pas de questions pour cette catégorie...</p>
            <?php else: ?>
                <?php foreach ($questionsWithResponses as $question): ?>
                    <div class="post">
                        <div class="headerr">
                            <strong>ID :</strong> <?= htmlspecialchars($question['codeF']) ?> |
                            <strong>Catégorie :</strong> <?= htmlspecialchars($question['categorie']) ?> |
                            <strong>Date :</strong> <?= htmlspecialchars($question['date']) ?> |
                            <strong>Heure :</strong> <?= htmlspecialchars($question['heure']) ?>
                        </div>
                        <p><strong>Question :</strong> <?= htmlspecialchars($question['question']) ?></p>

                        <?php if (!empty($question['photo_path'])): ?>
                            <p><strong>Photo associée :</strong></p>
                            <img src="<?= htmlspecialchars($question['photo_path']) ?>" alt="Photo de la question" style="max-width: 200px; height: auto;">
                        <?php endif; ?>

                        <p><strong>Réponse :</strong> <?= htmlspecialchars($question['reponse']) ?></p>
                        <p><strong>Nom de l'expert :</strong> <?= htmlspecialchars($question['nom_expert']) ?></p>

                        <!-- Boutons J'aime et Je n'aime pas uniquement pour les questions avec réponses -->
                        <form action="createclient.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="like">
                            <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                            <button type="submit" style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; cursor: pointer;">like</button>
                        </form>

                        <form action="createclient.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="dislike">
                            <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                            <button type="submit" style="background-color: #f03d35; color: white; padding: 5px 10px; border: none; cursor: pointer;">dislike</button>
                        </form>

                        <!-- Affichage du nombre de J'aime et Je n'aime pas uniquement si supérieur à 0 -->
                        <?php if ($question['likes'] > 0): ?>
                            <p><strong>like :</strong> <?= htmlspecialchars($question['likes']) ?></p>
                        <?php endif; ?>
                        <?php if ($question['dislikes'] > 0): ?>
                            <p><strong>dislike :</strong> <?= htmlspecialchars($question['dislikes']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('showButton').style.display = 'inline-block';
            document.getElementById('hideButton').style.display = 'none';
        });

        function showQuestions() {
            document.getElementById('questionsSection').style.display = 'block';
            document.getElementById('answeredQuestionsSection').style.display = 'block';
            document.getElementById('hideButton').style.display = 'inline-block';
            document.getElementById('showButton').style.display = 'none';
        }

        function hideQuestions() {
            document.getElementById('questionsSection').style.display = 'none';
            document.getElementById('answeredQuestionsSection').style.display = 'none';
            document.getElementById('hideButton').style.display = 'none';
            document.getElementById('showButton').style.display = 'inline-block';
        }
    </script>
</body>
</html>
