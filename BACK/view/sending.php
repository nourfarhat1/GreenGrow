<?php
session_start();

if (session_status() == PHP_SESSION_ACTIVE) {
    error_log("Session is active.");
} else {
    error_log("Session is not active.");
    echo "Session not active.";
    exit;
}

$body = rand(1000, 9999);
$_SESSION['verification_code'] = $body;

error_log("Verification Code Set: " . $_SESSION['verification_code']);

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    error_log("User data not available in session.");
    echo "User data not available.";
    exit;
}

$user_email = $_SESSION['user']['E_mail'];

if (empty($user_email)) {
    error_log("User email is empty.");
    echo "User email is not provided.";
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\BACK\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\BACK\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\BACK\vendor\phpmailer\phpmailer\src\SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->isSMTP();
    $mail->Host       = 'smtp.mail.yahoo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'chouikh_azza@yahoo.com';
    $mail->Password   = 'vzbrsskskcknpudv';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('chouikh_azza@yahoo.com', 'GreenGrow');
    $mail->addAddress($user_email);

    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = 'Entrer le code suivant pour réinitialiser votre mot de passe: ' . $body;

    $mail->send();
    echo 'Email sent successfully to ' . htmlspecialchars($user_email) . '.';
} catch (Exception $e) {
    error_log("Mailer Error: " . $mail->ErrorInfo);
    echo "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2;url=/BACK/view/reset.php">
    <title>Redirecting...</title>
</head>
<body>
    <p>Redirecting you in 2 seconds...</p>
</body>
</html>
