<?php
// Start session
session_start();

// Database credentials
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'Adept_Cinema_db');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: Please run install.php first.");
}

// Fetch App Name
$result = $conn->query("SELECT app_name FROM settings WHERE id = 1");
$app_settings = $result->fetch_assoc();
$APP_NAME = $app_settings['app_name'] ?? 'Adept Cinema';
?>