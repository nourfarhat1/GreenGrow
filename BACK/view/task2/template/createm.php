
<?php
session_start();
require_once 'C:\xampp\htdocs\BACK\model\user.php';

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: /BACK/view/page-signin.php");
    exit();
} else {
    if (isset($_SESSION['user'])) {
        $loggedInUser = $_SESSION['user'];
        $prenom = htmlspecialchars($loggedInUser['Prenom']);
        $username = $_SESSION['user']['Username'];
        $user_type=$_SESSION['user']['user_type'];
    }

    $userInstance = new User();
    $tasks = $userInstance->getTasks(); 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'AjoutTache') {
        $taskDate = $_POST['date'];
        $taskName = $_POST['task'];
        $taskStatus = $_POST['stat'];

        $userInstance->addTask($taskDate, $taskName, $taskStatus);

        $tasks = $userInstance->getTasks();
    }
}
?>

<?php
require 'C:\xampp\htdocs\BACK\config\config.php'; // Inclure le fichier pour la connexion

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Instantiate the Database class and get the connection
$database = new Database();
$conn = $database->getConnection();

// Vérification si le formulaire de réponse est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reponse']) && isset($_POST['codeF']) && isset($_POST['nom_expert'])) {
    $reponse = trim($_POST['reponse']);
    $nom_expert = trim($_POST['nom_expert']);
    $codeF = $_POST['codeF'];

    // Insertion de la réponse dans la base de données
    $stmt = $conn->prepare("INSERT INTO message (codeF, reponse, nom_expert, date, heure) VALUES (:codeF, :reponse, :nom_expert, NOW(), NOW())");
    $stmt->execute([
        'codeF' => $codeF,
        'reponse' => $reponse,
        'nom_expert' => $nom_expert
    ]);

    // Redirection pour éviter la soumission multiple et afficher la réponse mise à jour
    header("Location: createm.php");
    exit();
}

// Vérification si le formulaire de modification de réponse est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_reponse']) && isset($_POST['ID_rep'])) {
    $reponse = trim($_POST['edit_reponse']);
    $ID_rep = $_POST['ID_rep'];

    // Mise à jour de la réponse dans la base de données
    $stmt = $conn->prepare("UPDATE message SET reponse = :reponse WHERE ID_rep = :ID_rep");
    $stmt->execute([
        'reponse' => $reponse,
        'ID_rep' => $ID_rep
    ]);

    // Redirection pour éviter la soumission multiple et afficher la réponse mise à jour
    header("Location: createm.php");
    exit();
}

// Récupération des catégories disponibles
$stmt = $conn->prepare("SELECT DISTINCT categorie FROM forum");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Vérifier si une catégorie est sélectionnée
$categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : null;

// Récupération des questions sans réponses, filtrées par catégorie si nécessaire
$query = "SELECT * FROM forum WHERE codeF NOT IN (SELECT DISTINCT codeF FROM message)";
if ($categorie) {
    $query .= " AND categorie = :categorie";
}
$stmt = $conn->prepare($query);
if ($categorie) {
    $stmt->execute(['categorie' => $categorie]);
} else {
    $stmt->execute();
}
$questionsSansReponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des questions avec réponses, filtrées par catégorie si nécessaire
$query = "SELECT * FROM forum WHERE codeF IN (SELECT DISTINCT codeF FROM message)";
if ($categorie) {
    $query .= " AND categorie = :categorie";
}
$stmt = $conn->prepare($query);
if ($categorie) {
    $stmt->execute(['categorie' => $categorie]);
} else {
    $stmt->execute();
}
$questionsAvecReponses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des réponses
$reponses = [];
$stmt = $conn->prepare("SELECT * FROM message ORDER BY date DESC, heure DESC");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reponses[$row['codeF']][] = $row;
}

// Récupération des statistiques des catégories
$stmt = $conn->prepare("SELECT categorie, COUNT(*) AS total FROM forum GROUP BY categorie");
$stmt->execute();
$categoriesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Extraire les catégories et leurs totaux pour le graphique
$categoriesLabels = [];
$categoriesCounts = [];
foreach ($categoriesData as $data) {
    $categoriesLabels[] = $data['categorie'];
    $categoriesCounts[] = $data['total'];
}

// Calcul des statistiques pour les questions
$totalQuestionsSansReponses = count($questionsSansReponses);
$totalQuestionsAvecReponses = count($questionsAvecReponses);

// Récupération des dates uniques des questions posées
$stmt = $conn->prepare("SELECT DISTINCT DATE(date_f) AS date FROM forum");
$stmt->execute();
$dates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Compter le nombre total de questions posées pour chaque date
$questionsParDate = [];
foreach ($dates as $date) {
    // Check if the date is null
    if ($date['date'] !== null) {
        $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM forum WHERE DATE(date_f) = :date");
        $stmt->execute(['date' => $date['date']]);
        $questionsParDate[$date['date']] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    } else {
        // Handle the null case, for example, by skipping this iteration
        continue;
    }
}

// Préparer les données pour FullCalendar
$events = [];
foreach ($questionsParDate as $date => $total) {
    $events[] = [
        'title' => "Nombre de questions posées : $total",
        'start' => $date,
        'allDay' => true
    ];
}

// Calcul du nombre total de questions posées dans le forum
$totalQuestions = $totalQuestionsSansReponses + $totalQuestionsAvecReponses;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Agricole - Questions et Réponses</title>
    <link rel="stylesheet" href="forum.css">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-90680653-2');
    </script>
    <link href="../lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="../lib/typicons.font/typicons.css" rel="stylesheet">
    <link href="../lib/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/azia.css">
    <link rel="stylesheet" href="forum.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <style>
        /* Styles simplifiés pour une meilleure lisibilité */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 3px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .response {
            margin-top: 10px;
            padding: 10px;
            border: 3px solid #ddd;
        }
        .action-buttons {
            margin-top: 10px;
        }
        .chart-container {
            width: 50%;
            margin: 20px auto;
        }
        #calendar {
            max-width: 1100px;
            margin: 40px auto;

        }
        h2 {
    display: block;
    font-size: 1.5em;
    margin-block-start: 0.83em;
    margin-block-end: 0.83em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
    unicode-bidi: isolate;
    color:rgb(20, 38, 21);
    }
h1 {
    display: block;
    font-size: 3em;
    margin-block-start: 0.83em;
    margin-block-end: 0.83em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
    unicode-bidi: isolate;
    color: #0a360c;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js'></script>
</head>
<body>
      <!-- Global site tag (gtag.js) - Google Analytics -->
    
  
  
      <!-- Twitter -->
      <!-- <meta name="twitter:site" content="@bootstrapdash">
      <meta name="twitter:creator" content="@bootstrapdash">
      <meta name="twitter:card" content="summary_large_image">
      <meta name="twitter:title" content="Azia">
      <meta name="twitter:description" content="Responsive Bootstrap 4 Dashboard Template">
      <meta name="twitter:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png"> -->
  
      <!-- Facebook -->
      <!-- <meta property="og:url" content="https://www.bootstrapdash.com/azia">
      <meta property="og:title" content="Azia">
      <meta property="og:description" content="Responsive Bootstrap 4 Dashboard Template">
  
      <meta property="og:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
      <meta property="og:image:secure_url" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
      <meta property="og:image:type" content="image/png">
      <meta property="og:image:width" content="1200">
      <meta property="og:image:height" content="600"> -->
  
      <!-- Meta -->
   
   
  
  
    
    
     
      <div class="az-header">
        <div class="container">
          <div class="az-header-left">
            <a href="index.html" class="az-logo"><span></span> <img src="../img/logo.png" height="100" width="100"  ></a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
          </div><!-- az-header-left -->
          <div class="az-header-menu">
            <div class="az-header-menu-header">
              <a href="index.php" class="az-logo"> <img src="../img/logo.png" height="100" width="100" > </a>
              <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            <ul class="nav">
              <li class="nav-item ">
                <a href="index.php" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
              </li>
              <?php if ($user_type === 'admin'): ?>
              <li class="nav-item ">
                <a href="/BACK/view/chart-chartjs.php" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> Charts</a>
                
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" id="componentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="typcn typcn-user-outline"></i> Session
                  </a>
                  <div class="dropdown-menu" aria-labelledby="componentsDropdown">
                      <a href="/BACK/view/gestion_acc.php" class="dropdown-item">Gestion d'accès</a>
                      <a href="/BACK/index.php?action=showUsers2" class="dropdown-item">Liste des utilisateurs</a>
                  </div>
              </li>
              <?php endif; ?>
              <?php if ($user_type === 'Expert'||  $user_type === 'admin'): ?>
              <li class="nav-item active show">
                <a href="createm.php" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> forum</a>
                <?php endif; ?>
                <li class="nav-item dropdown">
                  
                  <div class="dropdown-forum" aria-labelledby="componentsDropdown">
                     
                  
                  </div>
              </li>         

            </ul>
          </div><!-- az-header-menu -->
          <div class="az-header-right">
            <a href="https://www.bootstrapdash.com/demo/azia-free/docs/documentation.html" target="_blank" class="az-header-search-link"><i class="far fa-file-alt"></i></a>
            <a href="" class="az-header-search-link"><i class="fas fa-search"></i></a>
            <div class="az-header-message">
              <a href="#"><i class="typcn typcn-messages"></i></a>
            </div><!-- az-header-message -->
            <div class="dropdown az-header-notification">
              <a href="" class="new"><i class="typcn typcn-bell"></i></a>
              <div class="dropdown-menu">
                <div class="az-dropdown-header mg-b-20 d-sm-none">
                  <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                </div>
                <h6 class="az-notification-title">Notifications</h6>
                <p class="az-notification-text">You have 2 unread notification</p>
                <div class="az-notification-list">
                  <div class="media new">
                    <div class="az-img-user"><img src="../img/faces/face2.jpg" alt=""></div>
                    <div class="media-body">
                      <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                      <span>Mar 15 12:32pm</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media new">
                    <div class="az-img-user online"><img src="../img/faces/face3.jpg" alt=""></div>
                    <div class="media-body">
                      <p><strong>Joyce Chua</strong> just created a new blog post</p>
                      <span>Mar 13 04:16am</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media">
                    <div class="az-img-user"><img src="../img/faces/face4.jpg" alt=""></div> 
                    <div class="media-body">
                      <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                      <span>Mar 13 02:56am</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media">
                    <div class="az-img-user"><img src="../img/faces/face5.jpg" alt=""></div>
                    <div class="media-body">
                      <p><strong>Adrian Monino</strong> added new comment on your photo</p>
                      <span>Mar 12 10:40pm</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                </div><!-- az-notification-list -->
                <div class="dropdown-footer"><a href="">View All Notifications</a></div>
              </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->
            <div class="dropdown az-profile-menu">
              <a href="" class="az-img-user"><img src="../img/faces/face1.jpg" alt=""></a>
              <div class="dropdown-menu">
                <div class="az-dropdown-header d-sm-none">
                  <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                </div>
                <div class="az-header-profile">
                  <div class="az-img-user">
                    <img src="../img/faces/face1.jpg" alt="">
                  </div><!-- az-img-user -->
                  <h6><?php echo htmlspecialchars($username); ?></h6>
                  <span><?php echo htmlspecialchars($user_type); ?></span>
                </div><!-- az-header-profile -->
                <script>
                            function confirmLogout(username) {
                                return confirm(`Are you sure you want to log out, ${username}?`);
                            }
                        </script>
                <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                <a href="profile_picture.php" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                <a href="" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a>
                <a href="Account_settings.html" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                <a href="createm.php" class="dropdown-item"><i class="typcn typcn-plus-outline"></i> forum</a>
                <a href="/BACK/view/logout.php" class="dropdown-item"><i class="typcn typcn-power-outline" onclick="return confirmLogout('<?php echo addslashes($username); ?>');">Logout</a></i>
              </div><!-- dropdown-menu -->
            </div>
          </div><!-- az-header-right -->
        </div><!-- container -->
      </div><!-- az-header -->
  

    <h1>Forum Agricole - Questions et Réponses</h1>
    <!-- Nouveau graphique pour les catégories -->
    <div class="chart-container">
        <h2 >Pourcentage des Questions par Catégorie :</h2>
        <canvas id="categoriesChart"></canvas>
    </div>

    <div class="forum-section">
        <!-- Formulaire de filtrage par catégorie -->
        <form class="filter-form" method="GET" action="createm.php">
            <label for="categorie">Filtrer par catégorie :</label>
            <select name="categorie" id="categorie">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= ($categorie === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrer</button>
        </form>

        <!-- Calendrier des questions -->
        <h2>Calendrier des Questions</h2>
        <div id='calendar'></div>

        <!-- Questions sans réponses -->
        <h2>Questions sans Réponses</h2>
        <?php if (count($questionsSansReponses) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Catégorie</th>
                        <th>Question</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questionsSansReponses as $question): ?>
                        <tr>
                            <td><?= htmlspecialchars($question['codeF']) ?></td>
                            <td><?= htmlspecialchars($question['categorie']) ?></td>
                            <td><?= htmlspecialchars($question['question']) ?></td>
                            <td>
                                <?php if (!empty($question['photo_path'])): ?>
                                    <img src="<?= htmlspecialchars($question['photo_path']) ?>" alt="Photo de la question" style="max-width: 100%; height: auto;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Affichage du formulaire de réponse -->
                                <div class="iframe-container" id="response-container-<?= htmlspecialchars($question['codeF']) ?>">
                                    <form id="response-form-<?= htmlspecialchars($question['codeF']) ?>" method="POST" action="createm.php">
                                        <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                                        <label for="reponse-<?= htmlspecialchars($question['codeF']) ?>">Votre réponse :</label>
                                        <textarea name="reponse" id="reponse-<?= htmlspecialchars($question['codeF']) ?>" required></textarea><br>
                                        <label for="nom_expert-<?= htmlspecialchars($question['codeF']) ?>">Votre nom d'expert :</label>
                                        <input type="text" name="nom_expert" id="nom_expert-<?= htmlspecialchars($question['codeF']) ?>" required><br>
                                        <button type="submit">Répondre</button>
                                    </form>
                                    <!-- Bouton de suppression de la question -->
                                    <form method="POST" action="deletem.php" style="display:inline;">
                                        <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette question ?')">Supprimer la question</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune question sans réponse pour cette catégorie.</p>
        <?php endif; ?>

        <hr>

        <!-- Questions avec réponses -->
        <h2>Questions avec Réponses</h2>
        <?php if (count($questionsAvecReponses) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Catégorie</th>
                        <th>Question</th>
                        <th>Photo</th>
                        <th>Réponses</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questionsAvecReponses as $question): ?>
                        <?php if (isset($reponses[$question['codeF']])): ?>
                            <tr>
                                <td><?= htmlspecialchars($question['codeF']) ?></td>
                                <td><?= htmlspecialchars($question['categorie']) ?></td>
                                <td><?= htmlspecialchars($question['question']) ?></td>
                                <td>
                                    <?php if (!empty($question['photo_path'])): ?>
                                        <img src="<?= htmlspecialchars($question['photo_path']) ?>" alt="Photo de la question" style="max-width: 100%; height: auto;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php foreach ($reponses[$question['codeF']] as $reponse): ?>
                                        <div class="response" id="response-<?= htmlspecialchars($reponse['ID_rep']) ?>">
                                            <p><strong>Nom Expert :</strong> <?= htmlspecialchars($reponse['nom_expert']) ?></p>
                                            <p><?= htmlspecialchars($reponse['reponse']) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </td>
                                <td class="action-buttons">
                                    <?php foreach ($reponses[$question['codeF']] as $reponse): ?>
                                        <form method="POST" action="createm.php" style="display:inline;">
                                            <input type="hidden" name="ID_rep" value="<?= htmlspecialchars($reponse['ID_rep']) ?>">
                                            <input type="hidden" name="edit_reponse" value="<?= htmlspecialchars($reponse['reponse']) ?>">
                                            <button type="button" onclick="toggleEditForm(<?= htmlspecialchars($reponse['ID_rep']) ?>, '<?= htmlspecialchars($reponse['reponse']) ?>')">Modifier la reponse </button>
                                        </form>
                                        <form method="POST" action="deletem.php" style="display:inline;">
                                            <input type="hidden" name="ID_rep" value="<?= htmlspecialchars($reponse['ID_rep']) ?>">
                                            <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                                            <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette réponse ?')">Supprimer la réponse</button>
                                        </form>
                                    <?php endforeach; ?>
                                    <!-- Bouton de suppression de la question -->
                                    <form method="POST" action="deletem.php" style="display:inline;">
                                        <input type="hidden" name="codeF" value="<?= htmlspecialchars($question['codeF']) ?>">
                                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette question ?')">Supprimer la question</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune question avec réponse pour cette catégorie.</p>
        <?php endif; ?>
    </div>

    <script>
        // Graphique des questions par catégorie
        const ctx2 = document.getElementById('categoriesChart').getContext('2d');
        const categoriesChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?= json_encode($categoriesLabels) ?>,
                datasets: [{
                    data: <?= json_encode($categoriesCounts) ?>,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 16 // Augmenter la taille des labels
                            }
                        }
                    },
                    datalabels: {
                        formatter: function(value, ctx) {
                            const total = ctx.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = Math.round((value / total) * 100);
                            return percentage + '%';
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 16 // Augmenter la taille des labels de pourcentage
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // Ajouter ce plugin pour afficher les étiquettes de pourcentage
        });

        // Fonction pour transformer la réponse en textarea
        function toggleEditForm(ID_rep, responseText) {
            const responseDiv = document.getElementById('response-' + ID_rep);

            if (responseDiv.classList.contains('editing')) {
                // Envoyer la réponse modifiée
                const textarea = responseDiv.querySelector('textarea');
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'createm.php';
                form.innerHTML = `
                    <input type="hidden" name="ID_rep" value="${ID_rep}">
                    <input type="hidden" name="edit_reponse" value="${textarea.value}">
                `;
                document.body.appendChild(form);
                form.submit();
            } else {
                // Transformer la réponse en textarea
                responseDiv.classList.add('editing');
                responseDiv.innerHTML = `
                    <p><strong>Nom Expert :</strong> ${responseDiv.querySelector('p:first-child').innerText}</p>
                    <form method="POST" action="createm.php">
                        <input type="hidden" name="ID_rep" value="${ID_rep}">
                        <textarea name="edit_reponse" required>${responseText}</textarea><br>
                        <button type="submit">Mettre à jour</button>
                    </form>
                `;
            }
        }

        // Initialiser FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                events: <?= json_encode($events) ?>,
                eventClick: function(info) {
                    alert( info.event.title);
                }
            });
            calendar.render();
        });
    </script>
    
<script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/ionicons/ionicons.js"></script>
    <script src="../lib/chart.js/Chart.bundle.min.js"></script>


    <script src="../js/azia.js"></script>
    <script src="../js/chart.chartjs.js"></script>
    <script src="../js/jquery.cookie.js" type="text/javascript"></script>
</body>
</html>
