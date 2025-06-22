<?php
// config.php

// Define site-wide constants
define('SITE_NAME', 'Beautyzone');
define('SITE_URL', 'http://localhost/project'); // Adjust this to your project's URL

// Database connection parameters
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Your database username (often 'root' for XAMPP)
define('DB_PASSWORD', '');     // Your database password (often empty for XAMPP)
define('DB_NAME', 'beautyzone_db'); // The database name we created earlier

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Start session here if you want it globally available
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// You can add more global functions or settings here
?>
