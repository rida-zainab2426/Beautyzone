<?php
$host = "localhost";
$user = "root";
$password = ""; // Your database password, typically empty for XAMPP/WAMP default root
$database = "beautyzone_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>