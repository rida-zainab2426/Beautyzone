<?php
// header.php
// Ensure session is started only once and at the very beginning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure config.php is included if not already
// This check prevents re-including if it's already done by another file
if (!defined('DB_SERVER')) {
    require_once 'config.php';
}

// Define categories for navigation
$cosmeticCategories = [
    "Lipsticks" => "lipsticks.php",
    "Foundations" => "foundations.php",
    "Eye Shadows" => "eyeshadows.php",
    "Blushes" => "blushes.php",
    "Skincare" => "skincare.php"
];
$jewelleryCategories = [
    "Necklaces" => "necklaces.php",
    "Earrings" => "earrings.php",
    "Rings" => "rings.php",
    "Bracelets" => "bracelets.php",
    "Anklets" => "anklets.php"
];

// Initialize cart if not already set (for cart badge)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Calculate total items in cart for the badge
$totalCartItems = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalCartItems += $item['quantity'];
    }
}
// NO HTML IN THIS FILE ANYMORE!
// HTML structure for the header will be in each page that includes this header.php
?>