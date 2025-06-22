<?php
// Database credentials
$host = 'localhost'; // Usually 'localhost' if your database is on the same server
$db_name = 'beautyzone_db'; // The name of the database you created
$username = 'root'; // Your MySQL username (e.g., 'root' for XAMPP/WAMP default)
$password = ''; // Your MySQL password (e.g., empty for XAMPP/WAMP default, but set one in production!)

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch rows as associative arrays by default

    // Optional: Echo a success message if you want to test the connection directly
    // echo "Connected to the database successfully!";

} catch (PDOException $e) {
    // If connection fails, output the error and stop script execution
    die("Connection failed: " . $e->getMessage());
}
?>