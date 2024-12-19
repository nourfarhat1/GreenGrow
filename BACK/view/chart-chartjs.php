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
            <a href="index.html" class="az-logo"><span></span> <img src="./task2/img/logo.png" height="100" width="100"  ></a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
          </div><!-- az-header-left -->
          <div class="az-header-menu">
            <div class="az-header-menu-header">
              <a href="index.php" class="az-logo"> <img src="./task2/img/logo.png" height="100" width="100" > </a>
              <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            <ul class="nav">
              <li class="nav-item ">
                <a href="../index.php" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
              </li>
              <?php if ($user_type === 'admin'): ?>
              <li class="nav-item active show">
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
              <li class="nav-item">
                <a href="task2/template/createm.php" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> forum</a>
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
                    <div class="az-img-user"><img src="./task2/img/faces/face2.jpg" alt=""></div>
                    <div class="media-body">
                      <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                      <span>Mar 15 12:32pm</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media new">
                    <div class="az-img-user online"><img src="./task2/img/faces/face3.jpg" alt=""></div>
                    <div class="media-body">
                      <p><strong>Joyce Chua</strong> just created a new blog post</p>
                      <span>Mar 13 04:16am</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media">
                    <div class="az-img-user"><img src="./task2/img/faces/face4.jpg" alt=""></div> 
                    <div class="media-body">
                      <p><strong>Althea Cabardo</strong> just created a new blog post</p>
                      <span>Mar 13 02:56am</span>
                    </div><!-- media-body -->
                  </div><!-- media -->
                  <div class="media">
                    <div class="az-img-user"><img src="./task2/img/faces/face5.jpg" alt=""></div>
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
              <a href="" class="az-img-user"><img src="./task2/img/faces/face1.jpg" alt=""></a>
              <div class="dropdown-menu">
                <div class="az-dropdown-header d-sm-none">
                  <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                </div>
                <div class="az-header-profile">
                  <div class="az-img-user">
                    <img src="./task2/img/faces/face1.jpg" alt="">
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
                <a href="task2/template/profile_picture.php" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                <a href="" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a>
                <a href="Account_settings.html" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                <a href="/BACK/task2/template/createm.php" class="dropdown-item"><i class="typcn typcn-plus-outline"></i> forum</a>
                <a href="/BACK/view/logout.php" class="dropdown-item"><i class="typcn typcn-power-outline" onclick="return confirmLogout('<?php echo addslashes($username); ?>');">Logout</a></i>
              </div><!-- dropdown-menu -->
            </div>
          </div><!-- az-header-right -->
        </div><!-- container -->
      </div><!-- az-header -->

    <?php if ($username === 'fzzf'): ?>
        <div class="container mt-4">
            <h3>User Chart</h3>
            <canvas id="userChart" style="max-width: 600px;"></canvas>
           
            
        </div>

        <script>
            const userData = <?php echo $userDataJson; ?>;

            if (userData.length > 0) {
                const userLabels = userData.map(item => item.month);
                const userCounts = userData.map(item => item.count);

                const ctxUser = document.getElementById('userChart').getContext('2d');
                new Chart(ctxUser, {
                    type: 'line',
                    data: {
                        labels: userLabels,
                        datasets: [{
                            label: 'Number of Users',
                            data: userCounts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                    }
                });
            }
</script>
          
    <?php endif; ?>

    <script src="/BACK/view/task2/lib/jquery/jquery.min.js"></script>
        <script src="/BACK/view/task2/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/BACK/view/task2/lib/ionicons/ionicons.js"></script>
        <script src="/BACK/view/task2/lib/chart.js/Chart.bundle.min.js"></script>
        <script src="/BACK/view/task2/js/azia.js"></script>
        <script src="/BACK/view/task2/js/chart.chartjs.js"></script>
        <script src="/BACK/view/task2/js/jquery.cookie.js" type="text/javascript"></script>
</body>
</html>
