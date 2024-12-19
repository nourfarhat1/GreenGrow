<?php
session_start();
require_once 'C:\xampp\htdocs\BACK\model\user.php';

$user_type = $_SESSION['user']['user_type'];

$loggedInUser = $_SESSION['user'];
$username = $_SESSION['user']['Username'];
$nom = $_SESSION['user']['Nom'];
$prenom = $_SESSION['user']['Prenom'];
$email = $_SESSION['user']['E_mail'];
$tel = $_SESSION['user']['Tel'];
$adresse = $_SESSION['user']['Adresse'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags, Title, and CSS Links -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit User</title>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-90680653-2');
    </script>
    <link href="/test/assets/lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/test/assets/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/test/assets/lib/typicons.font/typicons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="/test/assets/lib/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/test/assets/css/azia.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
        .user-table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        .user-table th, .user-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .user-table th {
            background-color: rgb(22, 57, 38);
            color: #fff;
        }
        .user-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .form-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container div {
            margin-bottom: 15px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: rgb(22, 57, 38);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #2b3e16;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="az-header">
        <div class="container">
            <div class="az-header-left">
                <a href="index.php" class="az-logo"><span></span> <img src="/test/assets/img/logo.png" height="100" width="100"></a>
                <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
            </div><!-- az-header-left -->
            <div class="az-header-menu">
                <div class="az-header-menu-header">
                    <a href="index.html" class="az-logo"><span></span> azia</a>
                    <a href="" class="close">&times;</a>
                </div><!-- az-header-menu-header -->
                <ul class="nav">
                    <li class="nav-item ">
                        <a href="index.php" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
                    </li>
                    <?php if ($user_type === 'admin'): ?>
                    <li class="nav-item">
                        <a href="/BACK/view/chart-chartjs.php" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> Charts</a>
                    </li>

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
              <li class="nav-item">
                <a href="createm.php" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> forum</a>
                <?php endif; ?>
                </ul>
            </div><!-- az-header-menu -->
            <div class="az-header-right">
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
                        <p class="az-notification-text">You have 2 unread notifications</p>
                        <div class="az-notification-list">
                            <div class="media new">
                                <div class="az-img-user"><img src="/test/assets/img/faces/face2.jpg" alt=""></div>
                                <div class="media-body">
                                    <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                                    <span>Mar 15 12:32pm</span>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media new">
                                <div class="az-img-user online"><img src="/test/assets/img/faces/face3.jpg" alt=""></div>
                                <div class="media-body">
                                    <p><strong>Joyce Chua</strong> just created a new blog post</p>
                                    <span>Mar 13 04:16am</span>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media">
                                <div class="az-img-user"><img src="/test/assets/img/faces/face4.jpg" alt=""></div>
                                <div class="media-body">
                                    <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                                    <span>Mar 13 02:56am</span>
                                </div><!-- media-body -->
                            </div><!-- media -->
                            <div class="media">
                                <div class="az-img-user"><img src="/test/assets/img/faces/face5.jpg" alt=""></div>
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
                    <a href="" class="az-img-user"><img src="/test/assets/img/faces/face1.jpg" alt=""></a>
                    <div class="dropdown-menu">
                        <div class="az-dropdown-header d-sm-none">
                            <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                        </div>
                        <div class="az-header-profile">
                            <div class="az-img-user">
                                <img src="/test/assets/img/faces/face1.jpg" alt="">
                            </div><!-- az-img-user -->
                            <h6>Azza Chouikh</h6>
                            <span>Premium Member</span>
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
                        <a href="logout.php" class="dropdown-item"><i class="typcn typcn-power-outline" onclick="return confirmLogout('<?php echo addslashes($username); ?>');">Logout</a></i>
                    </div><!-- dropdown-menu -->
                </div>
            </div><!-- az-header-right -->
        </div><!-- container -->
    </div><!-- az-header -->

    <div class="form-container">
        <h1>Edit User</h1>
        <form id="editUserForm" action="/BACK/index.php?action=updateUser2" method="post">
            <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
            <div>
                <label for="prenom">Prenom:</label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>" required>
            </div>
            <div>
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div>
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($adresse) ?>" required>
            </div>
            <div>
                <label for="tel">N° Tel:</label>
                <input type="text" id="tel" name="tel" value="<?= htmlspecialchars($tel) ?>" pattern="\d{8}" title="Phone number must be exactly 8 digits" required>
                <span id="phoneError" class="error-message"></span>
            </div>
            <div>
                <button type="submit">Update User</button>
            </div>
        </form>
    </div>

    <script src="/test/assets/lib/jquery/jquery.min.js"></script>
    <script src="/test/assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/test/assets/js/azia.js"></script>
    <script>
        document.getElementById('editUserForm').addEventListener('submit', function(event) {
            var phoneInput = document.getElementById('tel');
            var phoneError = document.getElementById('phoneError');

            phoneError.textContent = '';

            if (!phoneInput.validity.valid) {
                phoneError.textContent = 'Phone number must be exactly 8 digits.';
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
