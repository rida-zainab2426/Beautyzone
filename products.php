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
    if ($_POST['action'] == 'add_product') {
        $product_name = trim($_POST['product_name']);
        $description = trim($_POST['description']);
        $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
        $image_url = trim($_POST['image_url']);
        $category_id = filter_var($_POST['category_id'] ?? null, FILTER_VALIDATE_INT); // For 'all products' form
        $category_name_from_sub = trim($_POST['category_name'] ?? null); // For sub-category forms

        // Determine category_id if coming from sub-category form
        if (empty($category_id) && !empty($category_name_from_sub)) {
            try {
                $stmt = $pdo->prepare("SELECT category_id FROM categories WHERE category_name = :category_name");
                $stmt->bindParam(':category_name', $category_name_from_sub);
                $stmt->execute();
                $fetched_category = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($fetched_category) {
                    $category_id = $fetched_category['category_id'];
                } else {
                    $error = "Category '{$category_name_from_sub}' not found. Please add it first.";
                }
            } catch (PDOException $e) {
                $error = "Database error fetching category ID: " . $e->getMessage();
            }
        }

        if (!empty($product_name) && $price !== false && $price >= 0 && $category_id) {
            try {
                $stmt = $pdo->prepare("INSERT INTO products (product_name, description, price, image_url, category_id) VALUES (:product_name, :description, :price, :image_url, :category_id)");
                $stmt->bindParam(':product_name', $product_name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':image_url', $image_url);
                $stmt->bindParam(':category_id', $category_id);
                if ($stmt->execute()) {
                    $message = "Product '{$product_name}' added successfully.";
                } else {
                    $error = "Error adding product.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Please fill all required product fields correctly (Name, Price, Category).";
        }
    } elseif ($_POST['action'] == 'update_product') {
        $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
        $product_name = trim($_POST['product_name']);
        $description = trim($_POST['description']);
        $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
        $image_url = trim($_POST['image_url']);
        $category_id = filter_var($_POST['category_id'], FILTER_VALIDATE_INT);

        if ($product_id && !empty($product_name) && $price !== false && $price >= 0 && $category_id) {
            try {
                $stmt = $pdo->prepare("UPDATE products SET product_name = :product_name, description = :description, price = :price, image_url = :image_url, category_id = :category_id, updated_at = CURRENT_TIMESTAMP WHERE product_id = :product_id");
                $stmt->bindParam(':product_name', $product_name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':image_url', $image_url);
                $stmt->bindParam(':category_id', $category_id);
                $stmt->bindParam(':product_id', $product_id);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $message = "Product updated successfully.";
                    } else {
                        $error = "Product not found or no changes made.";
                    }
                } else {
                    $error = "Error updating product.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Invalid product ID or missing fields for update.";
        }
    } elseif ($_POST['action'] == 'delete_product') {
        $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
        if ($product_id) {
            try {
                $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :product_id");
                $stmt->bindParam(':product_id', $product_id);
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $message = "Product deleted successfully.";
                    } else {
                        $error = "Product not found.";
                    }
                } else {
                    $error = "Error deleting product.";
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        } else {
            $error = "Invalid product ID.";
        }
    }
}

// Redirect back to admin_panel.php with a message
header("Location: admin_panel.php#products" . ($message ? '&msg=' . urlencode($message) : '') . ($error ? '&err=' . urlencode($error) : ''));
exit();
?>