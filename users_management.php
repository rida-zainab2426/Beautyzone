<?php
session_start();
// Check if admin is logged in (uncomment in production)
// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header('Location: login.php');
//     exit();
// }

require_once 'config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add_user') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Always hash passwords!

        if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :password_hash)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password_hash', $hashed_password);
                if ($stmt->execute()) {
                    $message = "User '{$name}' added successfully.";
                } else {
                    $error = "Error adding user.";
                }
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') { // Duplicate entry error code
                    $error = "User with email '{$email}' already exists.";
                } else {
                    $error = "Database error: " . $e->getMessage();
                }
            }
        } else {
            $error = "Please fill all required user fields correctly.";
        }
    } elseif ($_POST['action'] == 'delete_user') {
        $user_id = filter_var($_POST['user_id'], FILTER_VALIDATE_INT);
        if ($user_id) {
            try {
                // Delete associated orders/order_items first, or set ON DELETE CASCADE in DB schema
                $pdo->beginTransaction(); // Start transaction for atomicity
                $stmt_orders = $pdo->prepare("DELETE FROM orders WHERE user_id = :user_id");
                $stmt_orders->bindParam(':user_id', $user_id);
                $stmt_orders->execute();

                $stmt_user = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
                $stmt_user->bindParam(':user_id', $user_id);
                if ($stmt_user->execute()) {
                    if ($stmt_user->rowCount() > 0) {
                        $pdo->commit(); // Commit transaction
                        $message = "User and associated data deleted successfully.";
                    } else {
                        $pdo->rollBack(); // Rollback if user not found
                        $error = "User not found.";
                    }
                } else {
                    $pdo->rollBack(); // Rollback on user delete error
                    $error = "Error deleting user.";
                }
            } catch (PDOException $e) {
                $pdo->rollBack(); // Rollback on any error
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Invalid user ID.";
        }
    }
}

// Redirect back to admin_panel.php with a message
header("Location: admin_panel.php#users" . ($message ? '&msg=' . urlencode($message) : '') . ($error ? '&err=' . urlencode($error) : ''));
exit();
?>