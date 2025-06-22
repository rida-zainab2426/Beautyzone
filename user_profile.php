<?php
session_start();
include 'db_connection.php'; // Includes the database connection ($pdo object)

// Define categories for navigation (copied from index.php and shopping_cart.php)
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

// Check if user is logged in
$is_logged_in = isset($_SESSION['member_id']);
$username = $is_logged_in ? htmlspecialchars($_SESSION['username']) : '';
$user_email = $is_logged_in ? htmlspecialchars($_SESSION['user_email']) : '';
$is_admin = $is_logged_in && $_SESSION['is_admin'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Beautyzone</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        /* Shared Styles (from previous files) */
        body { font-family: 'Montserrat', sans-serif; margin: 0; padding: 0; background-color: #f0f2f5; color: #333; }
        h1, h2, .section-title, .category-name { font-family: 'Playfair Display', serif; }
        :root {
            --review-bg-color: #FBF6F3;
            --text-dark: #333;
            --accent-pink: #E7746F;
            --light-accent: #F8D7C7;
            --quote-color: #FDD8D0;
            --input-bg-color: #FFFFFF;
            --input-border-color: #E0E0E0;
        }

        /* Header Styling */
        header {
            background: linear-gradient(to right, #FFE4E1, #FFB6C1); /* Softer, aesthetic pink gradient */
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            min-height: 70px;
        }
        .logo { flex-shrink: 0; }
        .logo a { text-decoration: none; display: block; }
        .logo span { font-family: 'Playfair Display', serif; font-size: 2.2em; font-weight: 700; color: var(--text-dark); text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); transition: color 0.3s ease-in-out; }
        .logo span:hover { color: var(--accent-pink); }
        nav { display: flex; align-items: center; flex-grow: 1; justify-content: flex-end; }
        .main-nav { display: flex; list-style: none; margin: 0; padding: 0; }
        .main-nav li { margin-left: 30px; position: relative; }
        .main-nav li a { text-decoration: none; color: #000; font-weight: 600; padding: 10px 0; display: block; transition: color 0.3s ease-in-out; }
        .main-nav li a:hover { color: var(--accent-pink); }
        .dropdown-menu { display: none; position: absolute; top: 100%; left: 0; background-color: #FFFFFF; border: 1px solid #E0E0E0; border-top: none; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); padding: 10px 0; min-width: 180px; z-index: 999; border-radius: 0 0 8px 8px; opacity: 0; visibility: hidden; transform: translateY(10px); transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s ease-in-out; }
        .dropdown:hover .dropdown-menu { display: block; opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-menu li a { padding: 10px 20px; color: #444; white-space: nowrap; transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out; }
        .dropdown-menu li a:hover { background-color: #F0F0F0; color: var(--accent-pink); }
        .arrow { margin-left: 8px; font-size: 0.7em; vertical-align: middle; transition: transform 0.3s ease-in-out; }
        .dropdown:hover .arrow { transform: rotate(180deg); }
        .search-icon { cursor: pointer; font-size: 1.4em; color: #000; margin-left: 30px; transition: color 0.3s ease-in-out; }
        .search-icon:hover { color: var(--accent-pink); }
        .search-bar { display: none; position: absolute; top: 100%; left: 0; width: 100%; background-color: var(--light-accent); padding: 15px 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08); box-sizing: border-box; transform: translateY(-10px); opacity: 0; visibility: hidden; transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s ease-in-out; justify-content: center; }
        .search-bar.open { display: flex; transform: translateY(0); opacity: 1; visibility: visible; }
        .search-bar input { flex-grow: 1; padding: 12px 20px; border: 1px solid #E0E0E0; border-radius: 25px; outline: none; font-size: 1em; max-width: 600px; margin-right: 10px; }
        .search-bar button { background-color: var(--accent-pink); color: white; border: none; padding: 12px 20px; border-radius: 25px; cursor: pointer; font-size: 1em; transition: background-color 0.3s ease-in-out; }
        .search-bar button:hover { background-color: '#D25F5C'; }
        .user-actions { display: flex; align-items: center; margin-left: 30px; }
        .user-actions a { color: #000; font-size: 1.4em; margin-left: 20px; position: relative; transition: color 0.3s ease-in-out; }
        .user-actions a:hover { color: var(--accent-pink); }
        .badge { position: absolute; top: -8px; right: -8px; background-color: #E44D26; color: white; border-radius: 50%; padding: 4px 7px; font-size: 0.7em; min-width: 10px; text-align: center; line-height: 1; }

        /* User Profile Specific Styling */
        .profile-container {
            max-width: 600px;
            margin: 80px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 250px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .profile-message {
            font-family: 'Playfair Display', serif;
            font-size: 2.2em;
            color: var(--accent-pink);
            margin-bottom: 25px;
        }

        .profile-subtext {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 20px; /* Space between buttons */
            justify-content: center;
            flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
        }

        .action-btn {
            background-color: var(--accent-pink);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            display: inline-block;
            min-width: 150px; /* Ensure buttons have a minimum width */
        }
        .action-btn:hover {
            background-color: '#D25F5C';
            transform: translateY(-2px);
        }

        .action-btn.secondary {
            background-color: #6c757d; /* Grey for secondary action */
        }
        .action-btn.secondary:hover {
            background-color: #5a6268;
        }

        .profile-details {
            text-align: left;
            width: 100%;
            margin-top: 20px;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .profile-details p {
            font-size: 1.1em;
            margin-bottom: 10px;
            color: #444;
        }

        .profile-details p strong {
            color: var(--text-dark);
            margin-right: 5px;
        }

        .logout-btn {
            background-color: #dc3545; /* Red for logout */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-container {
                margin: 40px auto;
                padding: 25px;
            }
            .profile-message { font-size: 2em; }
            .profile-subtext { font-size: 1em; }
            .action-buttons {
                flex-direction: column; /* Stack buttons vertically */
                gap: 15px; /* Adjust gap for vertical stacking */
            }
            .action-btn {
                padding: 12px 25px;
                font-size: 1.1em;
                width: calc(100% - 20px); /* Full width with padding */
            }
        }

        @media (max-width: 480px) {
            .profile-container {
                margin: 20px auto;
                padding: 20px;
            }
            .profile-message { font-size: 1.6em; margin-bottom: 20px; }
            .profile-subtext { font-size: 0.9em; margin-bottom: 25px; }
            .action-btn { font-size: 0.9em; padding: 10px 15px; }
            .profile-details p { font-size: 1em; }
            .logout-btn { padding: 8px 15px; font-size: 0.9em; }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><span>Beautyzone</span></a>
        </div>
        <nav>
            <ul class="main-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li class="dropdown">
                    <a href="#">Cosmetics <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($cosmeticCategories as $name => $file) {
                            echo '<li><a href="' . htmlspecialchars($file) . '">' . htmlspecialchars($name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Jewellery <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($jewelleryCategories as $name => $file) {
                            echo '<li><a href="' . htmlspecialchars($file) . '">' . htmlspecialchars($name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="search-icon">
                    <i class="fas fa-search"></i>
                </li>
            </ul>
            <div class="user-actions">
                <a href="user_profile.php"><i class="far fa-user"></i></a>
                <a href="shopping_cart.php"><i class="fas fa-shopping-bag"></i> <span class="badge"><?php echo $totalCartItems; ?></span></a>
            </div>
        </nav>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Search for products, categories...">
            <button type="submit" id="search-button"><i class="fas fa-search"></i></button>
        </div>
    </header>

    <div class="profile-container">
        <?php if ($is_logged_in): ?>
            <h1 class="profile-message">Welcome, <?= $username ?>!</h1>
            <p class="profile-subtext">
                Here you can manage your account details and view your orders.
            </p>
            <div class="profile-details">
                <p><strong>Username:</strong> <?= $username ?></p>
                <p><strong>Email:</strong> <?= $user_email ?></p>
                <?php if ($is_admin): ?>
                    <p><strong>Role:</strong> Administrator</p>
                    <p><a href="admin_dashboard.php" class="action-btn">Admin Dashboard</a></p>
                <?php else: ?>
                    <p><strong>Role:</strong> Member</p>
                <?php endif; ?>
                <form action="logout.php" method="POST">
                    <button type="submit" class="logout-btn">Log Out</button>
                </form>
            </div>
        <?php else: ?>
            <h1 class="profile-message">Welcome to Your Account</h1>
            <p class="profile-subtext">
                Please choose an option below to proceed.
            </p>
            <div class="action-buttons">
                <a href="login.php" class="action-btn">Log In</a>
                <a href="register.php" class="action-btn secondary">Register Account</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; // Assuming you have a footer.php file ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            mirror: false,
        });

        const searchIcon = document.querySelector('.search-icon');
        const searchBar = document.querySelector('.search-bar');
        const header = document.querySelector('header');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');

        function performSearch() {
            const query = searchInput.value;
            if (query.trim() !== '') {
                console.log('Searching for:', query);
            }
            searchBar.classList.remove('open');
        }

        searchIcon.addEventListener('click', (event) => {
            event.stopPropagation();
            searchBar.classList.toggle('open');
            if (searchBar.classList.contains('open')) {
                searchInput.focus();
            }
        });

        document.addEventListener('click', (event) => {
            if (!header.contains(event.target) && !searchBar.contains(event.target)) {
                if (searchBar.classList.contains('open')) {
                    searchBar.classList.remove('open');
                }
            }
        });

        searchInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                performSearch();
            }
        });

        searchButton.addEventListener('click', (event) => {
            event.preventDefault();
            performSearch();
        });
    </script>
</body>
</html>