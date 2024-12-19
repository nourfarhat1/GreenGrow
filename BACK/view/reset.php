<?php
session_start(); 

if (!isset($_SESSION['verification_code'])) {
    echo "Session verification code is missing.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_code = $_POST['verification_code'] ?? '';

    error_log("Session Code: " . $_SESSION['verification_code']);
    error_log("User Code: " . $user_code);

    if ($_SESSION['verification_code'] == $user_code) {
        echo "Verification successful. You can now reset your password.";
        unset($_SESSION['verification_code']);
        header("Location: /BACK/view/reset_p.php");
        exit;
    } else {
        $errorMessage = "Incorrect verification code. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password</title>
    <link href="/BACK/view/task2/lib/fontawesome-free/css2/all.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/BACK/view/task2/lib/typicons.font/typicons.css" rel="stylesheet">
    <link rel="stylesheet" href="/BACK/view/task2/css2/azia.css">

    <!-- Inline Style for Input Fields -->
    <style>
        .input {
            height: 40px;
            padding: 0 1rem;
            width: 100%;
            border: 2px solid transparent;
            border-radius: 8px;
            outline: none;
            background-color: #D9E8D8;
            box-shadow: 0 0 5px #C1D9BF, 0 0 0 10px #f5f5f5eb;
            transition: .3s ease;
        }
        .input::placeholder {
            color: #777;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body class="az-body">
    <div class="az-signin-wrapper">
        <div class="az-card-signin">
            <h1>G<span>reen</span>G<span>row</span></h1>
            <img src="/BACK/view/task2/img/logo.png" height="120" width="120" alt="GreenGrow Logo">
            <div class="az-signin-header">
                <h2>Réinitialisation</h2>
                <h4>Veuillez entrer votre code de vérification.</h4>
                <form action="reset.php" method="post">
                    <div>
                        <input type="text" name="verification_code" class="input" placeholder="Code de vérification" required>
                    </div>
                    <br>
                    <?php
    
                    if (isset($errorMessage)) {
                        echo "<p class='error'>$errorMessage</p>";
                    }
                    if (isset($successMessage)) {
                        echo "<p class='success'>$successMessage</p>";
                    }
                    ?>
                    <button type="submit" class="btn btn-az-primary btn-block">Vérifier</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="../lib/jquery/jquery.min.js"></script>
    <script src="../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/ionicons/ionicons.js"></script>
    <script src="../js/jquery.cookie.js"></script>
    <script src="../js/azia.js"></script>
</body>
</html>