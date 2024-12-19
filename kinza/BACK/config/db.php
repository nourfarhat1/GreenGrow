<?php
$servername = "localhost"; // Your database server (usually 'localhost')
$username = "root";        // Default username for XAMPP is 'root'
$password = "";            // Leave blank for the default XAMPP setup
$dbname = "projet";   // Replace with your database name
try {
    // Create a PDO instance and set error mode to exception
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: Uncomment the line below for connection confirmation
    // echo "Connected successfully"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
