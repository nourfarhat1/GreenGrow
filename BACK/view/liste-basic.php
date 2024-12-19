<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once 'C:\xampp\htdocs\BACK\model\user.php';


if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: page-signin.php");
    exit();
}


$prenom = $username = '';
if (isset($_SESSION['user'])) {
    $loggedInUser = $_SESSION['user'];
    $prenom = htmlspecialchars($loggedInUser['Prenom']);
    $username = htmlspecialchars($loggedInUser['Username']);
    $user_type=$_SESSION['user']['user_type'];
}


$user = new User();
$data = $user->getChartData();
$userData = $data['userData'] ?? [];


$userDataJson = json_encode($userData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-90680653-2');
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>Dashboard</title>

    <!-- Vendor CSS -->
    <link href="/BACK/view/task2/lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/typicons.font/typicons.css" rel="stylesheet">

    <!-- Azia CSS -->
    <link rel="stylesheet" href="/BACK/view/task2/css/azia.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="az-header">
        <div class="container">
          <div class="az-header-left">
            <a href="index.html" class="az-logo"><span></span> <img src="/BACK/view/task2/img/logo.png" height="100" width="100"  ></a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
          </div><!-- az-header-left -->
          <div class="az-header-menu">
            <div class="az-header-menu-header">
              <a href="index.php" class="az-logo"> <img src="/BACK/view/task2/img/logo.png" height="100" width="100" > </a>
              <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            <ul class="nav">
              <li class="nav-item ">
                <a href="/BACK/index.php" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
              </li>
              
              <li class="nav-item ">
                <a href="/BACK/view/chart-chartjs.php" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> Charts</a>
                <?php if ($username === 'fzzf'): ?>
                <li class="nav-item dropdown active">
                  <a href="#" class="nav-link dropdown-toggle" id="componentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="typcn typcn-user-outline"></i> Session
                  </a>
                  <div class="dropdown-menu" aria-labelledby="componentsDropdown">
                      <a href="/BACK/view/gestion_acc.php" class="dropdown-item">Gestion d'accès</a>
                      <a href="/BACK/index.php?action=showUsers2" class="dropdown-item">Liste des utilisateurs</a>
                  </div>
              </li>
              <?php endif; ?>
              <li class="nav-item">
                <a href="/BACK/view/task2/template/createm.php" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> forum</a>
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
                    <div class="az-img-user"><img src="/BACK/view/task2/img/faces/face2.jpg" alt=""></div>
                    <div class="media-body">
                      <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                      <span>Mar 15 12:32pm</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media new">
                    <div class="az-img-user online"><img src="/BACK/view/task2/img/faces/face3.jpg" alt=""></div>
                    <div class="media-body">
                      <p><strong>Joyce Chua</strong> just created a new blog post</p>
                      <span>Mar 13 04:16am</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media">
                    <div class="az-img-user"><img src="/BACK/view/task2/img/faces/face4.jpg" alt=""></div> 
                    <div class="media-body">
                      <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                      <span>Mar 13 02:56am</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media">
                    <div class="az-img-user"><img src="/BACK/view/task2/img/faces/face5.jpg" alt=""></div>
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
              <a href="" class="az-img-user"><img src="/BACK/view/task2/img/faces/face1.jpg" alt=""></a>
              <div class="dropdown-menu">
                <div class="az-dropdown-header d-sm-none">
                  <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                </div>
                <div class="az-header-profile">
                  <div class="az-img-user">
                    <img src="/BACK/view/task2/img/faces/face1.jpg" alt="">
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
                <a href="view/task2/template/profile_picture.php" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                <a href="" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a>
                <a href="Account_settings.html" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                <a href="/BACK/task2/template/createm.php" class="dropdown-item"><i class="typcn typcn-plus-outline"></i> forum</a>
                <a href="/BACK/view/logout.php" class="dropdown-item"><i class="typcn typcn-power-outline" onclick="return confirmLogout('<?php echo addslashes($username); ?>');">Logout</a></i>
              </div><!-- dropdown-menu -->
            </div>
          </div><!-- az-header-right -->
        </div><!-- container -->
      </div><!-- az-header -->
             


    <!-- Header Content -->
</div>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        color: #444;
    }
    h2 {
        text-align: center;
        margin-top: 30px;
        color: #2b3e16;
        font-size: 2.5em;
        font-weight:bolder;
        text-transform:inherit;
        letter-spacing: 1px;
    }
    .user-table {
        width: 90%;
        margin: 30px auto;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .user-table th, .user-table td {
        padding: 15px;
        border: 1px solid #e0e0e0;
        text-align: left;
        font-size: 1em;
    }
    .user-table th {
        background-color: rgb(41, 59, 24);
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
    }
    .user-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .user-table tr:hover {
        background-color: #eaf6e6;
        cursor: pointer;
    }
    .user-table td {
        color: #333;
    }
</style>

</head>

<h2>Liste des utilisateurs</h2>
<table class="user-table">
    <thead>
        <tr>
            <th><i class="fas fa-user"></i> Username</th>
            <th>Prenom</th>
            <th>Nom</th>
            <th><i class="fas fa-envelope"></i> Email</th>
            <th>Adresse</th>
            <th><i class="fas fa-phone"></i> Num telephone</th>
            <th>type d'utilisateur</th>
            
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): 
       
             foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['Username']) ?></td>
                    <td><?= htmlspecialchars($user['Prenom']) ?></td>
                    <td><?= htmlspecialchars($user['Nom']) ?></td>
                    <td><?= htmlspecialchars($user['E_mail']) ?></td>
                    <td><?= htmlspecialchars($user['Adresse']) ?></td>
                    <td><?= htmlspecialchars($user['Tel']) ?></td>
                    <td><?= htmlspecialchars($user['user_type']) ?></td>
                    
                    
                    <td>
                    <a href="index.php?action=editUser&Username=<?= $user['Username'] ?>">Edit</a> |
                    <a href="index.php?action=deleteUser&Username=<?= $user['Username'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">No users found.</td>
            </tr>


            
        <?php endif; ?>
    </tbody>
</table>


































<script src="/BACK/view/task2/lib/jquery/jquery.min.js"></script>
    <script src="/BACK/view/task2/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/BACK/view/task2/js/azia.js"></script>
</body>
</html>