<?php
// admin/categories.php

// Start the session at the very beginning of the file
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not truly logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php'); // Redirect to admin login (or simulated login page)
    exit();
}

// Include your config and functions files
require_once __DIR__ . '/../config.php'; // Adjust path to your config.php
require_once 'includes/functions.php'; // Assuming functions.php is in admin/includes/

$message = $_SESSION['message'] ?? '';
$message_type = $_SESSION['message_type'] ?? '';
unset($_SESSION['message']); // Clear message after displaying
unset($_SESSION['message_type']);

// Define your cosmetic and jewellery categories
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


// Define your menu items and their corresponding files
$menuItems = [
    'dashboard' => ['label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'link' => 'dashboard.php'],
    'products' => ['label' => 'Products', 'icon' => 'fas fa-box-open', 'link' => '../anklets.php'], // Link to your front-end products
    'add_product' => ['label' => 'Add New Product', 'icon' => 'fas fa-plus-circle', 'link' => 'add_product.php'],
    'orders' => ['label' => 'Orders', 'icon' => 'fas fa-shopping-cart', 'link' => 'orders.php'],
    'users' => ['label' => 'Users', 'icon' => 'fas fa-users', 'link' => 'users.php'],
    'categories' => ['label' => 'Categories', 'icon' => 'fas fa-tags', 'link' => 'categories.php'], // Current page
    'reports' => ['label' => 'Reports', 'icon' => 'fas fa-chart-line', 'link' => 'reports.php'], // Added Reports
];

// Get the current page to highlight active menu item
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - <?php echo SITE_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reusing common admin panel CSS (from dashboard/users etc.) */
        :root {
            --primary-pink: #ffe0e6;
            --secondary-pink: #ffafbd;
            --accent-pink: #e76f87;
            --dark-pink: #d9536d;
            --text-dark: #333;
            --text-light: #fff;
            --sidebar-bg: #f8d7da;
            --sidebar-link: #495057;
            --sidebar-hover: #ffe0e6;
            --card-bg: #fff;
            --border-color: #f0c3cb;
            --shadow-light: rgba(225, 175, 189, 0.2);
            --success-color: #28a745;
            --error-color: #dc3545;
            --info-color: #17a2b8;
        }

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

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

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
            flex-grow: 1;
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
            border-radius: 0 25px 25px 0;
        }

        .sidebar-menu li a i {
            margin-right: 10px;
            font-size: 1.1em;
            color: var(--accent-pink);
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li.active a {
            background-color: var(--secondary-pink);
            color: var(--text-light);
        }

        .sidebar-menu li.active a i {
            color: var(--text-light);
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: var(--primary-pink);
        }

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
            padding-right: 35px;
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

        .message.info {
            background-color: var(--info-color);
            color: var(--text-light);
        }

        /* Category specific styles */
        .category-section {
            background-color: var(--card-bg);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px var(--shadow-light);
            margin-bottom: 20px;
        }

        .category-section h3 {
            color: var(--dark-pink);
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }

        .category-list li {
            background-color: var(--primary-pink);
            border: 1px solid var(--border-color);
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .category-list li:hover {
            background-color: var(--secondary-pink);
            color: var(--text-light);
            transform: translateY(-3px);
        }

        .category-list li a {
            text-decoration: none;
            color: inherit; /* Inherit color from parent li */
            display: block;
        }

        /* Responsive Adjustments */
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
                order: -1;
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
                width: calc(100% - 100px);
            }

            .search-box input {
                width: 100%;
            }

            .user-info {
                margin-left: 15px;
            }

            .category-section {
                padding: 15px;
            }

            .category-list {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
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
                    <h2>Manage Categories</h2>
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

            <div class="category-section">
                <h3>Cosmetic Categories</h3>
                <?php if (!empty($cosmeticCategories)): ?>
                    <ul class="category-list">
                        <?php foreach ($cosmeticCategories as $name => $file): ?>
                            <li><a href="../<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No cosmetic categories defined.</p>
                <?php endif; ?>
            </div>

            <div class="category-section">
                <h3>Jewellery Categories</h3>
                <?php if (!empty($jewelleryCategories)): ?>
                    <ul class="category-list">
                        <?php foreach ($jewelleryCategories as $name => $file): ?>
                            <li><a href="../<?php echo htmlspecialchars($file); ?>"><?php echo htmlspecialchars($name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No jewellery categories defined.</p>
                <?php endif; ?>
            </div>

        </main>
    </div>
</body>
</html>