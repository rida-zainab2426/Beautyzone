<?php
// admin/add_product.php

// Start the session at the very beginning of the file
// IMPORTANT: Make sure this check is also in config.php if session_start() is there.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not truly logged in (for security if login is re-enabled)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php'); // Redirect to admin login (or simulated login page)
    exit();
}

// Include your config and functions files
require_once __DIR__ . '/../config.php'; // Adjust path to your config.php (e.g., one level up from admin/)
require_once 'includes/functions.php'; // Assuming functions.php is in admin/includes/

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message']); // Clear message after displaying
unset($_SESSION['message_type']);

// Fetch categories for the dropdown
$categories = [];
$sql_categories = "SELECT category_id, name FROM categories ORDER BY name ASC";
$result_categories = $conn->query($sql_categories);
if ($result_categories && $result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    // Optionally set an error if no categories are found, or handle it in the form
    $_SESSION['message'] = "No categories found in the database. Please add categories first.";
    $_SESSION['message_type'] = 'error';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['name']);
    $product_price = trim($_POST['price']);
    $product_description = trim($_POST['description']);
    $product_stock_quantity = trim($_POST['stock_quantity']); // Changed name
    $product_category_id = trim($_POST['category_id']); // New field

    $errors = [];

    // Basic validation
    if (empty($product_name)) {
        $errors[] = "Product name is required.";
    }
    if (!is_numeric($product_price) || $product_price <= 0) {
        $errors[] = "Price must be a positive number.";
    }
    if (empty($product_description)) {
        $errors[] = "Product description is required.";
    }
    if (!is_numeric($product_stock_quantity) || $product_stock_quantity < 0) {
        $errors[] = "Stock quantity must be a non-negative number.";
    }
    if (empty($product_category_id) || !is_numeric($product_category_id)) {
        $errors[] = "Category is required and must be valid.";
    }

    $image_url = ''; // Changed name

    // Handle main image upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == UPLOAD_ERR_OK) { // Changed input name
        // __DIR__ is the directory of the current script (admin/)
        // '../' goes up one level to the project root
        // 'uploads/products/' is the target folder within the project root
        $upload_dir = __DIR__ . '/../uploads/products/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
        }
        $file_extension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $new_file_name = uniqid('product_') . '.' . $file_extension;
        $destination = $upload_dir . $new_file_name;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $destination)) {
            $image_url = 'uploads/products/' . $new_file_name; // Path to store in DB
        } else {
            $errors[] = "Failed to upload product image.";
        }
    } else {
        $errors[] = "Main product image is required.";
    }

    if (empty($errors)) {
        // Prepare SQL INSERT statement (Changed column names and added category_id)
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, category_id, image_url, stock_quantity) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            $errors[] = "Database prepare error: " . $conn->error;
        } else {
            // Bind parameters (Changed type string 'sdsssi' for category_id and stock_quantity)
            // 'sdsisi' assumes: string (name), string (description), decimal (double - price), integer (category_id), string (image_url), integer (stock_quantity)
            $stmt->bind_param("ssdisi", $product_name, $product_description, $product_price, $product_category_id, $image_url, $product_stock_quantity);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Product '{$product_name}' added successfully!";
                $_SESSION['message_type'] = 'success';
                redirectTo('add_product.php'); // Redirect to clear form on success
            } else {
                $_SESSION['message'] = "Error adding product: " . $stmt->error;
                $_SESSION['message_type'] = 'error';
            }
            $stmt->close();
        }
    } else {
        $_SESSION['message'] = implode('<br>', $errors);
        $_SESSION['message_type'] = 'error';
    }
    redirectTo('add_product.php'); // Redirect to show messages
}

// Define your menu items and their corresponding files (same as dashboard.php)
$menuItems = [
    'dashboard' => ['label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'link' => 'dashboard.php'],
    'products' => ['label' => 'Products', 'icon' => 'fas fa-box-open', 'link' => '../anklets.php'], // Link to your front-end products
    'add_product' => ['label' => 'Add New Product', 'icon' => 'fas fa-plus-circle', 'link' => 'add_product.php'], // Current page
    'orders' => ['label' => 'Orders', 'icon' => 'fas fa-shopping-cart', 'link' => 'orders.php'], // Placeholder
    'users' => ['label' => 'Users', 'icon' => 'fas fa-users', 'link' => 'users.php'], // Placeholder
    'categories' => ['label' => 'Categories', 'icon' => 'fas fa-tags', 'link' => 'categories.php'], // Placeholder - You might want to create this
    'reports' => ['label' => 'Reports', 'icon' => 'fas fa-chart-line', 'link' => 'reports.php'], // New: Reports
];

// Get the current page to highlight active menu item
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - <?php echo SITE_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Define CSS Variables for Theming */
        :root {
            --primary-pink: #ffe0e6; /* Very light pink, almost off-white for background */
            --secondary-pink: #ffafbd; /* A slightly deeper pink for highlights */
            --accent-pink: #e76f87; /* A vibrant pink for buttons/active states */
            --dark-pink: #d9536d; /* Darker pink for hover states */
            --text-dark: #333; /* Dark gray for main text */
            --text-light: #fff; /* White for text on dark backgrounds */
            --sidebar-bg: #f8d7da; /* Light pink for sidebar background */
            --sidebar-link: #495057; /* Darker text for sidebar links */
            --sidebar-hover: #ffe0e6; /* Lighter pink for sidebar link hover */
            --card-bg: #fff; /* White for cards */
            --border-color: #f0c3cb; /* Light pink border */
            --shadow-light: rgba(225, 175, 189, 0.2); /* Light pink shadow */
            --success-color: #28a745;
            --error-color: #dc3545;
        }

        /* Base Styles (Copied from Dashboard) */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--primary-pink);
            color: var(--text-dark);
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: var(--accent-pink);
            margin-top: 0;
        }

        /* Wrapper for Layout */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling (Copied from Dashboard) */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            padding: 20px 0;
            box-shadow: 2px 0 10px var(--shadow-light);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            text-align: center;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-header h3 {
            color: var(--dark-pink);
            font-size: 1.8em;
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1; /* Allows menu to take up available space */
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--sidebar-link);
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 0 25px 25px 0; /* Rounded right edge */
        }

        .sidebar-menu li a i {
            margin-right: 10px;
            font-size: 1.1em;
            color: var(--accent-pink); /* Icon color */
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li.active a {
            background-color: var(--secondary-pink);
            color: var(--text-light);
            /* box-shadow: 0 2px 5px var(--shadow-light); */
        }

        .sidebar-menu li.active a i {
            color: var(--text-light); /* Active icon color */
        }


        /* Main Content Area (Copied from Dashboard) */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: var(--primary-pink);
        }

        /* Navbar (Copied from Dashboard) */
        .navbar {
            background-color: var(--card-bg);
            padding: 15px 30px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px var(--shadow-light);
        }

        .navbar-left h2 {
            color: var(--dark-pink);
            margin: 0;
            font-size: 1.8em;
        }

        .navbar-right {
            display: flex;
            align-items: center;
        }

        .search-box {
            position: relative;
            margin-right: 20px;
        }

        .search-box input {
            padding: 8px 12px;
            padding-right: 35px; /* Space for icon */
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 0.9em;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-box input:focus {
            border-color: var(--accent-pink);
        }

        .search-box i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-pink);
        }

        .user-info {
            display: flex;
            align-items: center;
            color: var(--text-dark);
            font-weight: 500;
        }

        .user-info i {
            font-size: 1.4em;
            margin-right: 8px;
            color: var(--accent-pink);
        }

        /* Form Specific Styles */
        .form-container {
            background-color: var(--card-bg);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px var(--shadow-light);
            max-width: 800px; /* Adjust as needed */
            margin: 20px auto; /* Center the form */
        }

        .form-container h3 {
            color: var(--dark-pink);
            margin-bottom: 25px;
            text-align: center;
            font-size: 1.8em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group textarea,
        .form-group select { /* Added select */
            width: calc(100% - 22px); /* Account for padding and border */
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="number"]:focus,
        .form-group textarea:focus,
        .form-group select:focus { /* Added select */
            border-color: var(--accent-pink);
            outline: none;
        }

        .form-group input[type="file"] {
            padding: 8px; /* Slightly less padding for file input */
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px 20px;
            background-color: var(--accent-pink);
            color: var(--text-light);
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: var(--dark-pink);
            transform: translateY(-2px);
        }

        /* Messages */
        .message {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: 500;
            text-align: center;
        }

        .message.success {
            background-color: var(--success-color);
            color: var(--text-light);
        }

        .message.error {
            background-color: var(--error-color);
            color: var(--text-light);
        }

        /* Responsive Adjustments (Copied from Dashboard) */
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                padding: 15px 0;
                box-shadow: 0 2px 10px var(--shadow-light);
                border-radius: 0 0 8px 8px;
                order: -1; /* Puts sidebar at the top on small screens */
            }

            .sidebar-header {
                border-bottom: none;
                padding-bottom: 10px;
                margin-bottom: 10px;
            }

            .sidebar-menu {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                padding: 0 10px;
            }

            .sidebar-menu li {
                width: auto;
                margin: 5px;
            }

            .sidebar-menu li a {
                padding: 8px 15px;
                border-radius: 5px;
            }

            .navbar {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px 20px;
            }

            .navbar-right {
                width: 100%;
                margin-top: 15px;
                justify-content: space-between;
            }

            .search-box {
                margin-right: 0;
                width: calc(100% - 100px); /* Adjust as needed */
            }

            .search-box input {
                width: 100%;
            }

            .user-info {
                margin-left: 15px;
            }

            .form-container {
                padding: 20px;
                margin: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-gem"></i> Beautyzone Admin</h3>
            </div>
            <ul class="sidebar-menu">
                <?php foreach ($menuItems as $key => $item): ?>
                    <li class="<?php echo ($currentPage == basename($item['link'])) ? 'active' : ''; ?>">
                        <a href="<?php echo $item['link']; ?>">
                            <i class="<?php echo $item['icon']; ?>"></i>
                            <span><?php echo $item['label']; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li>
                    <a href="index.php?logout=true">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <nav class="navbar">
                <div class="navbar-left">
                    <h2>Add New Product</h2>
                </div>
                <div class="navbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
                    </div>
                </div>
            </nav>

            <div class="form-container">
                <h3>Add New Product</h3>

                <?php if ($message): ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="add_product.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="stock_quantity">Stock Quantity:</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Select a Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image_file">Product Image:</label>
                        <input type="file" id="image_file" name="image_file" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn-submit">Add Product</button>
                </form>
            </div>

        </main>
    </div>
</body>
</html>