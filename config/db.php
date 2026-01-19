<?php
$config = require_once 'env.php';

$host = $config['DB_HOST'];
$db_name = $config['DB_NAME'];
$username = $config['DB_USER'];
$password = $config['DB_PASS'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Disable exception echoing for production security
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    // In strict production, you might use PDO::ERRMODE_SILENT and check errors manually 
    // or keep EXCEPTION but catch them comfortably in main scripts.
} catch(PDOException $e) {
    // Log error instead of showing it
    error_log("Database Connection Error: " . $e->getMessage()); 
    // Show generic message
    die("System Maintenance. Please try again later."); 
}
?>