


<?php

include "C:\xampp\htdocs\BACK\model\config.php"; 

session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    $profile_picture = $_FILES['profile_picture'];

    if ($profile_picture['name']) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; 
        
        if (in_array($profile_picture['type'], $allowed_types) && $profile_picture['size'] <= $max_size) {
            $target_dir = "uploads/"; 
            $file_extension = pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($profile_picture['tmp_name'], $target_file)) {
                $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, profile_picture = ? WHERE id = ?");
                $stmt->execute([$username, $email, $new_filename, $_SESSION['user_id']]); 
                echo "Profile updated successfully!";
            } else {
                echo "Error uploading profile picture.";
            }
        } else {
            echo "Invalid file type or file too large.";
        }
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $_SESSION['user_id']]);
        echo "Profile updated successfully!";
    }
}




?>
<?php

$stmt = $pdo->prepare("SELECT username, email, profile_picture FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$profile_picture = $user['profile_picture'];
?>

<div>
    <h2>Profile</h2>
    <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <img src="uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" width="150">
</div>

