<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .header {
            margin-bottom: 20px;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .group {
            display: flex;
            line-height: 28px;
            align-items: center;
            position: relative;
            max-width: 100%;
            margin-bottom: 15px; /* Add spacing between inputs */
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

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        echo "User data not available.";
        exit;
    }

    $user = $_SESSION['user']['Username'];
    ?>
    <img src="/BACK/view/task2/img/logo.png" height="120" width="120" alt="GreenGrow Logo">
    <div class="container">
        <div class="header">
            <h2>Reset Password</h2>
            <p>Welcome, <?php echo htmlspecialchars($user); ?>! You can now reset your password.</p>
        </div>

        <!-- Display messages -->
        <?php if (isset($errorMessage)) : ?>
            <div class="message error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        
        <?php if (isset($successMessage)) : ?>
            <div class="message success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        <script>
    function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
    }
    </script>

        <!-- Form for password reset -->
        <form method="POST" action="/BACK/index.php?action=ModifierMdp">
            <div class="form-group">
            <div class="group">
            <input type="password" id="new_password" name="new_password" class="input" placeholder="New Password" required>
             <span class="icon" onclick="togglePassword('new_password', 'show_password_icon_1')">
            <i id="show_password_icon_1" class="fas fa-eye"></i>
             </span>
                </div>
            </div>
            <div class="form-group">
            <div class="group">
            <input type="password" id="confirm_password" name="confirm_password" class="input" placeholder="Confirm Password" required>
            <span class="icon" onclick="togglePassword('confirm_password', 'show_password_icon_2')">
            <i id="show_password_icon_2" class="fas fa-eye"></i>
         </span>
        </div>
        </div>

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
