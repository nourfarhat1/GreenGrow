<?php

function was_included_by($target_file) {
    $backtrace = debug_backtrace();
    foreach ($backtrace as $call) {
        if (isset($call['file']) && $call['file'] === $target_file) {
            return true;
        }
    }
    return false;
}

$target_file = __DIR__ . '/view/success_mdp.html';

if (was_included_by($target_file)) {
    if (isset($_SESSION['user']['Username']) && isset($_SESSION['user']['Mdp'])) {
        $username = htmlspecialchars($_SESSION['user']['Username']);
        echo "Vous êtes déjà connecté en tant que <strong>$username</strong>. Veux-tu te <a href='logout.php'>déconnecter</a> ? <br> ou bien retourner au <a href='/BACK/index.php'>Dashboard</a>";
    }
} else {
    if (isset($_SESSION['user']['Username']) && isset($_SESSION['user']['Mdp'])) {
        $username = htmlspecialchars($_SESSION['user']['Username']);
        echo "Vous êtes déjà connecté en tant que <strong>$username</strong>. Veux-tu te <a href='logout.php'>déconnecter</a> ? <br> ou bien retourner au <a href='/BACK/index.php'>Dashboard</a>";
    } else {
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Page Title -->
    <title>Azia Responsive Bootstrap 4 Dashboard Template</title>

    <!-- Vendor CSS -->
    <link href="/BACK/view/task2/lib/fontawesome-free/css2/all.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/typicons.font/typicons.css" rel="stylesheet">
    <link rel="stylesheet" href="/BACK/view/task2/css2/azia.css">

    <!-- Inline Style for Input Fields -->
    <style>
        /* From Uiverse.io by alexruix */
        .group {
            display: flex;
            line-height: 28px;
            align-items: center;
            position: relative;
            max-width: 160px;
        }
        .az-card-signin {
  height: 600px;
  
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  background-color: #ffffff; 
  margin-top: 50px; 
}
        .input {
            height: 40px;
            line-height: 28px;
            padding: 0 1rem;
            width: 100%;
            padding-left: 2.5rem;
            border: 2px solid transparent;
            border-radius: 8px;
            outline: none;
            background-color: #D9E8D8;
            
            color: #0d0c22;
            box-shadow: 0 0 5px #C1D9BF, 0 0 0 10px #f5f5f5eb;
            transition: .3s ease;
        }

        .input::placeholder {
            color: #777;
        }

        .icon {
            position: absolute;
            left: 1rem;
            fill: #777;
            width: 1rem;
            height: 1rem;
        }

        /* Style for the toggle checkbox */
        .toggle-password {
            margin-left: 10px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body class="az-body">

    <div class="az-signin-wrapper">
        <div class="az-card-signin">
            <h1>G<span>reen</span>G<span>row</span></h1>
            <img src="/BACK/view/task2/img/logo.png" height="120" width="120" alt="GreenGrow Logo">
            <div class="az-signin-header">
                <h2>Content de vous revoir!</h2>
                <h4>Veuillez vous connecter pour continuer</h4>

                <form action="/BACK/index.php?action=verifyUser" method="post">
                    <div class="form-group">
                        <?php if (!empty($errorMessage)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($errorMessage); ?>
                            </div>
                        <?php endif; ?>
                        <input type="text" autocomplete="off" name="Username" class="input" placeholder="Username">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="password" id="password" name="Mdp" class="input" placeholder="Enter your password">
                        <input type="checkbox" class="toggle-password" onclick="togglePassword()"> Show Password
                    </div>
                    <button type="submit" class="btn btn-az-primary btn-block">Sign In</button>
                    <div class="az-signin-footer">
                        <p><a href="/BACK/view/password_reset.php">Mot de passe oublié?</a></p>
                        <p>Pas de compte? <a href="/BACK/view/form.php">Créer un compte</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="/BACK/view/task2/lib/jquery/jquery.min.js"></script>
    <script src="/BACK/view/task2/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/BACK/view/task2/lib/ionicons/ionicons.js"></script>
    <script src="/BACK/view/task2/js/jquery.cookie.js"></script>
    <script src="/BACK/view/task2/js/azia.js"></script>

    <!-- JavaScript to toggle password visibility -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>
<?php
    }
}
?>
