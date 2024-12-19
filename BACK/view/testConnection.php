<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Adjust the path to correctly locate db.php
require  '/../db.php';
;

// Confirm the script runs by printing a message
echo "Connection script executed successfully.";
?>
