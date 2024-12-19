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
        $user_type = $_SESSION['user']['user_type'];
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

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags, Title, and CSS Links -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Template</title>


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
    


</head>
  <div class="az-header">
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
              <li class="nav-item active show">
                <a href="index.php" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
              </li>
              <?php if ($user_type === 'admin'): ?>
              <li class="nav-item">
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
                <a href="/BACK/view/task2/template/createm.php" class="dropdown-item"><i class="typcn typcn-plus-outline"></i> forum</a>
                <a href="/BACK/view/logout.php" class="dropdown-item"><i class="typcn typcn-power-outline" onclick="return confirmLogout('<?php echo addslashes($username); ?>');">Logout</a></i>
              </div><!-- dropdown-menu -->
            </div>
          </div><!-- az-header-right -->
        </div><!-- container -->
      </div><!-- az-header -->
  
      
             


    <!-- Header Content -->
</div>

<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <div class="az-dashboard-one-title">
                <div>
                <h2 class="az-dashboard-title">Hi, welcome back!<br> <?php echo htmlspecialchars($username); ?></h2>
                    
                </div>
                <div class="az-content-header-right">
                    <!-- Date Filters and Event Category Dropdown -->
                    <div class="media">
                        <div class="media-body">
                            <label>Start Date</label>
                            <h6><input type="date" id="date" name="date"></h6>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-body">
                            <label>End Date</label>
                            <h6><input type="date" id="endDate" name="endDate"></h6>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-body">
                            <label>Event Category</label>
                            <select id="eventCategory">
                                <option value="fn">History of Purchase</option>
                                <option value="vn">New Subscribers</option>
                                <option value="rl" onclick="toggleTable()">Task History</option>
                            </select>
                            <input type="submit" id="submit" class="btn btn-purple" onclick="handleSubmit(event)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="az-dashboard-nav">
                <nav class="nav">
                    <a class="nav-link active" id="overviewLink" href="#" onclick="showOverview()">Overview</a>
                    <a class="nav-link" href="#" onclick="toggleTable()"><i class="fas fa-history"></i> Task History</a>
                    <a class="nav-link" href="#" onclick="showIrrigationSection()"><i class="typcn typcn-water"></i> Manage irrigation</a>
                    <a class="nav-link" href="#" onclick="showProducts()"><i class="typcn typcn-water"></i>  Manage products</a>
                    <a class="nav-link" href="#" onclick="showCommandes()"><i class="typcn typcn-water"></i> Manage commands</a>
                    <a class="nav-link" href="#" onclick="showanimal()"><i class="typcn typcn-water"></i> Manage animals </a>
                    <a class="nav-link" href="#" onclick="showFarmSection()"><i class="typcn typcn-water"></i>Manage Farm</a>
                    <a class="nav-link" href="#" onclick="showFarmSection()"><i class="typcn typcn-water"></i>Manage Farm</a>
                    
                    
                </nav>
            </div>

            <div id="irrigationSection" style="display: none;">
              <h3>Gérer l'historique d'irrigation</h3>
              <iframe src="gerer.php" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>

            <div id="farmOptions" style="display: none;">
              <h3>Manage Farm</h3>
              <iframe src="indexf.php" style="width: 100%; height: 600px; border: none;"></iframe>
          </div>

            <div id="animal" style="display: none;">
              <h3>Gérer les animaux</h3>
              <iframe src="/back/view/afficherAnimaux.php" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
            <div id="productsSection" style="display: none;">
              <h3>Gérer les produits</h3>
              <iframe src="../../listProduits.php" style="width: 100%; height: 600px; border: none;"></iframe>
          </div>

          <!-- Commandes Section -->
          <div id="commandesSection" style="display: none;">
              <h3>Gérer les commandes</h3>
              <iframe src="../../listCommandes.php" style="width: 100%; height: 600px; border: none;"></iframe>
          </div>
            
            

            <!-- Overview Section with Task History Table -->
            <div id="overviewSection" style="display: block;">
                <h3>Overview</h3>
                <div class="table-container" id="taskHistoryTableContainer" style="display: none;">
                        <main>
                            <section id="task-history">
                                <h2>Task History</h2>
                                <form method="POST" action="index.php">
                                    <input type="hidden" name="action" value="AjoutTache">
                                    <table id="taskHistoryTable" class="display">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Task</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tasks as $task): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($task['task_date']); ?></td>
                                                    <td><?= htmlspecialchars($task['task_name']); ?></td>
                                                    <td><?= htmlspecialchars($task['task_status']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td><input type="date" name="date" required></td>
                                                <td><input type="text" name="task" required></td>
                                                <td><input type="text" name="stat" placeholder="status" required></td>
                                                <td><button type="submit">Add Task</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </section>
                        </main>
                    </div>
            <div class="table-container" id="purchaseTableContainer" style="display: none;">
              <table id="purchaseHistoryTable">
                  
                  
              </table>
          </div>
      </div>
  </div>
</div>
</div>

<style>
  select, input[type="submit"] {
      font-size: 1rem;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #052501;
      border-radius: 8px;
      outline: none;
  }
  
  #taskHistoryTable {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
  }

  th, td {
      border: 1px solid #052501;
      padding: 8px;
      text-align: left;
  }

  th {
      background-color: #e6f2e6;
  }

  input[type="text"], input[type="date"] {
      width: 100%;
      padding: 6px;
      border: 1px solid #cccccc;
      border-radius: 4px;
  }
</style>
<script>
  function showanimal() {
  // Masquer les autres sections
  document.getElementById('overviewSection').style.display = 'none';
  document.getElementById('taskHistoryTableContainer').style.display = 'none';
  document.getElementById('purchaseTableContainer').style.display = 'none';
  
  // Afficher la section d'irrigation
  document.getElementById('animal').style.display = 'block';
}

function handleSubmit(event) {
  event.preventDefault();
  const eventCategory = document.getElementById('eventCategory').value;
  const purchaseContainer = document.getElementById('purchaseTableContainer');
  const taskHistoryContainer = document.getElementById('taskHistoryTableContainer');
  
  console.log("Selected category:", eventCategory); 

  if (eventCategory === 'fn') {
      console.log("Showing purchase table");
      purchaseContainer.style.display = 'block';
      taskHistoryContainer.style.display = 'none';
      monitorAllRows();
  } else if (eventCategory === 'rl') {
      console.log("Showing task history table");
      taskHistoryContainer.style.display = 'block';
      purchaseContainer.style.display = 'none';
      monitorAllRows();
  } else {
      purchaseContainer.style.display = 'none';
      taskHistoryContainer.style.display = 'none';
  }
}

function addNewRow(tableId) {
  const tbody = document.getElementById(tableId).querySelector('tbody');
  const newRow = document.createElement('tr');
  if (tableId === 'purchaseHistoryTable') {
      newRow.innerHTML = `
          <td><input type="date" name="date" required></td>
          <td><input type="datetime" name="date_t" required></td>
          <td><input type="text" name="productName" placeholder="Enter product ID" required></td>
          <td><input type="text" name="buyer" placeholder="Enter buyer" required></td>
          <td><select id="delivery">
              <option value="yes">Done</option>
              <option value="no">Not delivered</option>
              <option value="still">In progress</option>
          </select></td>
      `;
  } else if (tableId === 'taskHistoryTable') {
      newRow.innerHTML = `
          <td><input type="date" name="date" required></td>
          <td><input type="text" name="name" placeholder="Enter name" required></td>
          <td><input type="text" name="department" placeholder="Enter department" required></td>
          <td><input type="text" name="task" placeholder="Enter task" required></td>
      `;
  }
  tbody.appendChild(newRow);
  monitorInput(newRow);
}


function monitorInput(row) { 
  const inputs = row.querySelectorAll('input');
  inputs.forEach(input => {
      input.addEventListener('keypress', function(event) {
         
          const table = input.closest('table'); 
          if (table && table.id === 'purchaseHistoryTable' && event.key === 'Enter') {
              
              addNewRow('purchaseHistoryTable');
              event.stopImmediatePropagation();
          }
          else if(table && table.id =='taskHistoryTable'&& event.key=='Enter'){
             
              addNewRow('taskHistoryTable');
              event.stopImmediatePropagation();
          }
      });
  });
}


function monitorAllRows() {
  const rows = document.querySelectorAll('#purchaseHistoryTable tbody tr, #taskHistoryTable tbody tr');
  rows.forEach(row => monitorInput(row));
}

function showOverview() {
  document.getElementById('overviewSection').style.display = 'block';
}

function showFarmSection() {
            const farmSection = document.getElementById('farmOptions');
            farmSection.style.display = farmSection.style.display === 'none' || farmSection.style.display === ''
                ? 'block'
                : 'none';
        }

function toggleTable() {
  const tableContainer = document.getElementById('taskHistoryTableContainer');
  tableContainer.style.display = tableContainer.style.display === 'none' || tableContainer.style.display === '' 
      ? 'block' 
      : 'none';
      addNewRow('taskHistoryTable');
}
function showProducts() {
            const productsSection = document.getElementById('productsSection');
            if (productsSection.style.display === 'none' || productsSection.style.display === '') {
                productsSection.style.display = 'block';
            } else {
                productsSection.style.display = 'none';
            }
        }

        function showCommandes() {
            const commandesSection = document.getElementById('commandesSection');
            if (commandesSection.style.display === 'none' || commandesSection.style.display === '') {
                commandesSection.style.display = 'block';
            } else {
                commandesSection.style.display = 'none';
            }
        }
        document.getElementById('showTaskHistory').addEventListener('click', function () {
        document.getElementById('task-history').classList.remove('hidden');
        document.getElementById('purchase-history').classList.add('hidden');
    });


    $(document).ready(function () {
        $('#taskHistoryTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
        });

        $('#purchaseHistoryTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
        });
    });
    document.getElementById('showTaskHistory').addEventListener('click', function () {
        document.getElementById('task-history').classList.remove('hidden');
        document.getElementById('purchase-history').classList.add('hidden');
    });

    document.getElementById('showPurchaseHistory').addEventListener('click', function () {
        document.getElementById('purchase-history').classList.remove('hidden');
        document.getElementById('task-history').classList.add('hidden');
    });

</script>

        </div>
    </div>
</div>


<script src="../lib/jquery-ui/ui/widgets/datepicker.js"></script>
<script src="../lib/jquery.maskedinput/jquery.maskedinput.js"></script>
<script src="../lib/spectrum-colorpicker/spectrum.js"></script>
<script src="../lib/select2/js/select2.min.js"></script>
<script src="../lib/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="../lib/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>
<script src="../lib/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>
<script src="../lib/pickerjs/picker.min.js"></script>
<script src="../js/jquery.cookie.js" type="text/javascript"></script>







<script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/ionicons/ionicons.js"></script>
    <script src="../lib/chart.js/Chart.bundle.min.js"></script>


    <script src="../js/azia.js"></script>
    <script src="../js/chart.chartjs.js"></script>
    <script src="../js/jquery.cookie.js" type="text/javascript"></script>
</body>
</html>