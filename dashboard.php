<?php
// admin/dashboard.php
// Ensure session is started and admin is logged in
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if not truly logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php'); // Redirect to admin login
    exit();
}

// Include your config and functions files
require_once __DIR__ . '/../config.php'; // Adjust path as needed
require_once 'includes/functions.php'; // Contains redirectTo()

// Define some dummy data for the dashboard cards
$totalProducts = 250; // Example
$totalOrders = 120;   // Example
$totalUsers = 85;     // Example
$pendingOrders = 15;  // Example

// Example recent activities
$recentActivities = [
    ['type' => 'order', 'message' => 'New order #ORD1234 from Jane Doe.', 'time' => '2 hours ago'],
    ['type' => 'product', 'message' => 'Anklet "Delicate Chain Anklet" updated.', 'time' => '1 day ago'],
    ['type' => 'user', 'message' => 'New user registered: John Smith.', 'time' => '3 days ago'],
    ['type' => 'order', 'message' => 'Order #ORD1233 fulfilled.', 'time' => '5 days ago'],
    ['type' => 'product', 'message' => 'New product "Sparkling Crystal Anklet" added.', 'time' => '1 week ago'],
];

// Dummy data for Top 10 Best Selling Products
$topSellingProducts = [
    ['name' => 'Sparkling Crystal Anklet', 'sales' => 150, 'revenue' => 6300],
    ['name' => 'Delicate Chain Anklet', 'sales' => 120, 'revenue' => 4200],
    ['name' => 'Bohemian Beaded Anklet', 'sales' => 110, 'revenue' => 3080],
    ['name' => 'Gold Layered Anklet', 'sales' => 105, 'revenue' => 3675],
    ['name' => 'Natural Seashell Anklet', 'sales' => 95, 'revenue' => 2660],
    ['name' => 'Silver Charm Anklet', 'sales' => 88, 'revenue' => 3960],
    ['name' => 'Classic Pearl Necklace', 'sales' => 80, 'revenue' => 4000],
    ['name' => 'Diamond Stud Earrings', 'sales' => 75, 'revenue' => 7500],
    ['name' => 'Minimalist Ring Set', 'sales' => 70, 'revenue' => 2100],
    ['name' => 'Elegant Bracelet', 'sales' => 65, 'revenue' => 2925],
];

// Dummy data for Top 10 Clients/Users (doing maximum shopping)
$topClients = [
    ['name' => 'Alice Wonderland', 'email' => 'alice@example.com', 'total_spent' => 1520.50],
    ['name' => 'Bob The Builder', 'email' => 'bob@example.com', 'total_spent' => 1200.75],
    ['name' => 'Charlie Chaplin', 'email' => 'charlie@example.com', 'total_spent' => 980.00],
    ['name' => 'Diana Prince', 'email' => 'diana@example.com', 'total_spent' => 875.20],
    ['name' => 'Ethan Hunt', 'email' => 'ethan@example.com', 'total_spent' => 760.10],
    ['name' => 'Fiona O\'Connell', 'email' => 'fiona@example.com', 'total_spent' => 650.00],
    ['name' => 'George Clooney', 'email' => 'george@example.com', 'total_spent' => 540.80],
    ['name' => 'Hannah Montana', 'email' => 'hannah@example.com', 'total_spent' => 430.60],
    ['name' => 'Ivy Queen', 'email' => 'ivy@example.com', 'total_spent' => 320.40],
    ['name' => 'Jack Sparrow', 'email' => 'jack@example.com', 'total_spent' => 210.20],
];


// Define your menu items and their corresponding files
// Assuming your anklets.php is the main product listing
$menuItems = [
    'dashboard' => ['label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'link' => 'dashboard.php'],
    'products' => ['label' => 'Products', 'icon' => 'fas fa-box-open', 'link' => '../anklets.php'], // Link to your front-end products
    'add_product' => ['label' => 'Add New Product', 'icon' => 'fas fa-plus-circle', 'link' => 'add_product.php'], // Placeholder, you'll create this
    'orders' => ['label' => 'Orders', 'icon' => 'fas fa-shopping-cart', 'link' => 'orders.php'], // Placeholder
    'users' => ['label' => 'Users', 'icon' => 'fas fa-users', 'link' => 'users.php'], // Placeholder
    'categories' => ['label' => 'Categories', 'icon' => 'fas fa-tags', 'link' => 'categories.php'], // Placeholder
    'reports' => ['label' => 'Reports', 'icon' => 'fas fa-chart-line', 'link' => 'dashboard.php#reports'], // Link to a section on this page
];

// Get the current page to highlight active menu item
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
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
            --info-color: #17a2b8;
        }

        /* Base Styles */
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

        /* Sidebar Styling */
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


        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: var(--primary-pink);
        }

        /* Navbar */
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

        /* Dashboard Grid (Cards) */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: var(--card-bg);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px var(--shadow-light);
            display: flex;
            align-items: center;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            font-size: 2.5em;
            color: var(--accent-pink);
            margin-right: 20px;
            padding: 15px;
            background-color: var(--secondary-pink);
            border-radius: 50%;
            line-height: 1; /* Prevents extra space around icon */
        }

        .card-content h3 {
            margin: 0 0 5px 0;
            color: var(--text-dark);
            font-size: 1.2em;
        }

        .card-content p {
            font-size: 1.8em;
            font-weight: 700;
            color: var(--dark-pink);
            margin: 0;
        }

        /* Recent Activities & Reports Sections */
        .report-section {
            background-color: var(--card-bg);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px var(--shadow-light);
            margin-bottom: 20px;
        }

        .report-section h3 {
            margin-bottom: 20px;
            color: var(--dark-pink);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .report-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .report-section li {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .report-section li:last-child {
            border-bottom: none;
        }

        .report-section li i {
            font-size: 1.1em;
            color: var(--secondary-pink);
            margin-right: 15px;
            width: 25px; /* Fixed width for icon alignment */
            text-align: center;
        }

        .report-section li span {
            flex-grow: 1;
            color: var(--text-dark);
        }

        .report-section li .activity-time,
        .report-section li .report-value {
            font-size: 0.9em;
            color: #888;
            margin-left: 15px;
            font-weight: 600;
        }

        .report-section li .report-value.green {
            color: var(--success-color);
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

            .dashboard-grid {
                grid-template-columns: 1fr; /* Stack cards on small screens */
            }

            .card {
                flex-direction: column;
                text-align: center;
            }

            .card-icon {
                margin-right: 0;
                margin-bottom: 15px;
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
                    <li class="<?php echo ($currentPage == basename($item['link']) && strpos($_SERVER['REQUEST_URI'], $item['link']) !== false) ? 'active' : ''; ?>">
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
                    <h2>Dashboard</h2>
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

            <div class="dashboard-grid">
                <div class="card">
                    <div class="card-icon"><i class="fas fa-box-open"></i></div>
                    <div class="card-content">
                        <h3>Total Products</h3>
                        <p><?php echo $totalProducts; ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="card-content">
                        <h3>Total Orders</h3>
                        <p><?php echo $totalOrders; ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <div class="card-content">
                        <h3>Total Users</h3>
                        <p><?php echo $totalUsers; ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div class="card-content">
                        <h3>Pending Orders</h3>
                        <p><?php echo $pendingOrders; ?></p>
                    </div>
                </div>
            </div>

            <div class="report-section">
                <h3>Recent Activities</h3>
                <ul>
                    <?php foreach ($recentActivities as $activity): ?>
                        <li>
                            <i class="
                                <?php
                                if ($activity['type'] == 'order') echo 'fas fa-shopping-basket';
                                elseif ($activity['type'] == 'product') echo 'fas fa-cube';
                                elseif ($activity['type'] == 'user') echo 'fas fa-user-plus';
                                ?>
                            "></i>
                            <span><?php echo htmlspecialchars($activity['message']); ?></span>
                            <span class="activity-time"><?php echo htmlspecialchars($activity['time']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="report-section" id="reports">
                <h3>Top 10 Best Selling Products</h3>
                <ul>
                    <?php foreach ($topSellingProducts as $product): ?>
                        <li>
                            <i class="fas fa-star green"></i>
                            <span><?php echo htmlspecialchars($product['name']); ?></span>
                            <span class="report-value"><?php echo htmlspecialchars($product['sales']); ?> units sold (Revenue: $<?php echo number_format($product['revenue'], 2); ?>)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="report-section">
                <h3>Top 10 Clients/Users (Maximum Shopping)</h3>
                <ul>
                    <?php foreach ($topClients as $client): ?>
                        <li>
                            <i class="fas fa-user-tie green"></i>
                            <span><?php echo htmlspecialchars($client['name']); ?> (<?php echo htmlspecialchars($client['email']); ?>)</span>
                            <span class="report-value green">Total Spent: $<?php echo number_format($client['total_spent'], 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </main>
    </div>

    <script>
        // Basic JavaScript for sidebar active link if you have dynamic loading or SPA
        // For standard page loads, the PHP active class logic is sufficient.
    </script>
</body>
</html>