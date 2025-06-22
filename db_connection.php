<?php
// db_connection.php

$host = 'localhost'; // Or your database host
$db = 'beautyzone_db'; // The name of your database
$user = 'root'; // Your database username (e.g., 'root' for XAMPP/WAMP)
$pass = ''; // Your database password (e.g., '' for XAMPP/WAMP default root)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Log the error for debugging purposes (check your web server's error logs)
    error_log("Database connection failed: " . $e->getMessage());
    // For a live site, you might show a generic error message to the user
    die("Connection to database failed. Please try again later.");
}
?>