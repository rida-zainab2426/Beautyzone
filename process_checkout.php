<?php
session_start();

// Essential security check: redirect if not logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION['message'] = "Access denied. Please log in.";
    $_SESSION['message_type'] = "danger";
    header('Location: login.php'); // Redirect to login page
    exit();
}

// If the user is logged in, proceed with processing the checkout form data
// (e.g., validate input, save order to database, clear cart, send confirmation email)

// Example: Retrieve form data
$fullName = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
// ... retrieve other fields

// Example: Get cart items
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['message'] = "Your cart is empty. Please add items before checking out.";
    $_SESSION['message_type'] = "warning";
    header('Location: shopping_cart.php');
    exit();
}

// Process cart items (e.g., save to order_items table)
// Clear cart after successful processing
unset($_SESSION['cart']);

$_SESSION['message'] = "Your order has been placed successfully!";
$_SESSION['message_type'] = "success";
header('Location: order_confirmation.php'); // Redirect to a confirmation page
exit();
?>