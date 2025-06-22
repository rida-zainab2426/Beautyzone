<?php
session_start();
include 'db_connection.php'; // Includes the database connection ($pdo object)

// Navigation categories (for consistency across pages)
$cosmeticCategories = [
    "Lipsticks" => "lipsticks.php", "Foundations" => "foundations.php",
    "Eye Shadows" => "eyeshadows.php", "Blushes" => "blushes.php", "Skincare" => "skincare.php"
];
$jewelleryCategories = [
    "Necklaces" => "necklaces.php", "Earrings" => "earrings.php",
    "Rings" => "rings.php", "Bracelets" => "bracelets.php", "Anklets" => "anklets.php"
];

// Initialize cart for header badge
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$totalCartItems = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalCartItems += $item['quantity'];
}

$message = ''; // To display feedback (success/error)
$username_val = ''; // To retain username input on validation error
$email_val = '';    // To retain email input on validation error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Sanitize input for display (even if it's an error, it's safer)
    $username_val = htmlspecialchars($username);
    $email_val = htmlspecialchars($email);

    // --- Validation Logic ---
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = '<div class="alert error">Please fill in all fields.</div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="alert error">Invalid email format.</div>';
    } elseif (strlen($password) < 6) {
        $message = '<div class="alert error">Password must be at least 6 characters long.</div>';
    } elseif ($password !== $confirm_password) {
        $message = '<div class="alert error">Passwords do not match.</div>';
    } else {
        // --- Database Check for existing user ---
        try {
            // Check in site_members table for existing username or email
            $stmt = $pdo->prepare("SELECT member_id FROM site_members WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->rowCount() > 0) {
                $message = '<div class="alert error">Username or Email already registered.</div>';
            } else {
                // --- Insert new user into site_members table ---
                $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password

                $stmt = $pdo->prepare("INSERT INTO site_members (username, email, password_hash) VALUES (?, ?, ?)");
                if ($stmt->execute([$username, $email, $password_hash])) {
                    $message = '<div class="alert success">Registration successful! You can now <a href="login.php">log in</a>.</div>';
                    // Clear form fields on successful registration
                    $username_val = '';
                    $email_val = '';
                } else {
                    $message = '<div class="alert error">Something went wrong during registration. Please try again.</div>';
                }
            }
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            $message = '<div class="alert error">An unexpected error occurred. Please try again later.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Beautyzone</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        /* Shared Styles (from previous files - ensure these match your site's header/footer) */
        body { font-family: 'Montserrat', sans-serif; margin: 0; padding: 0; background-color: #f0f2f5; color: #333; }
        h1, h2, .section-title, .category-name { font-family: 'Playfair Display', serif; }
        :root {
            --review-bg-color: #FBF6F3; --text-dark: #333; --accent-pink: #E7746F;
            --light-accent: #F8D7C7; --quote-color: #FDD8D0; --input-bg-color: #FFFFFF;
            --input-border-color: #E0E0E0;
        }
        header { background: linear-gradient(to right, #FFE4E1, #FFB6C1); padding: 10px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); position: sticky; top: 0; z-index: 1000; min-height: 70px; }
        .logo { flex-shrink: 0; } .logo a { text-decoration: none; display: block; }
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

        /* Register Form Specific Styling */
        .register-container { max-width: 500px; margin: 80px auto; background-color: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); min-height: calc(100vh - 250px); display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .register-title { font-family: 'Playfair Display', serif; font-size: 2.5em; color: var(--accent-pink); text-align: center; margin-bottom: 30px; }
        .register-form { width: 100%; display: flex; flex-direction: column; gap: 20px; }
        .register-form label { font-weight: 600; color: #555; margin-bottom: 5px; display: block; }
        .register-form input[type="text"], .register-form input[type="email"], .register-form input[type="password"] {
            width: calc(100% - 22px); padding: 12px; border: 1px solid var(--input-border-color); border-radius: 5px; font-size: 1em; background-color: var(--input-bg-color); transition: border-color 0.3s ease; }
        .register-form input[type="text"]:focus, .register-form input[type="email"]:focus, .register-form input[type="password"]:focus {
            outline: none; border-color: var(--accent-pink); box-shadow: 0 0 0 2px rgba(231, 116, 111, 0.2); }
        .register-btn { background-color: var(--accent-pink); color: white; padding: 15px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 1.1em; font-weight: 600; transition: background-color 0.3s ease, transform 0.2s ease; width: 100%; margin-top: 10px; }
        .register-btn:hover { background-color: #D25F5C; transform: translateY(-2px); }
        .login-link-container { margin-top: 20px; font-size: 0.95em; color: #666; }
        .login-link-container a { color: var(--accent-pink); text-decoration: none; font-weight: 600; }
        .login-link-container a:hover { text-decoration: underline; }

        /* Alert Messages */
        .alert { padding: 12px 20px; border-radius: 5px; margin-bottom: 20px; font-size: 0.95em; text-align: center; }
        .alert.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        /* Responsive adjustments for forms */
        @media (max-width: 768px) {
            .register-container { margin: 40px auto; padding: 25px; }
            .register-title { font-size: 2em; }
            .register-form input { width: calc(100% - 20px); }
            .register-btn { padding: 12px 20px; font-size: 1em; }
        }
        @media (max-width: 480px) {
            .register-container { margin: 20px auto; padding: 20px; }
            .register-title { font-size: 1.8em; margin-bottom: 25px; }
            .register-form input { width: calc(100% - 16px); padding: 10px; }
            .register-btn { padding: 10px 15px; font-size: 0.9em; }
            .alert { padding: 10px 15px; font-size: 0.9em; }
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
                        <?php foreach ($cosmeticCategories as $name => $file) : ?>
                            <li><a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($name) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Jewellery <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($jewelleryCategories as $name => $file) : ?>
                            <li><a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($name) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="search-icon">
                    <i class="fas fa-search"></i>
                </li>
            </ul>
            <div class="user-actions">
                <a href="user_profile.php"><i class="far fa-user"></i></a>
                <a href="shopping_cart.php"><i class="fas fa-shopping-bag"></i> <span class="badge"><?= $totalCartItems ?></span></a>
            </div>
        </nav>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Search for products, categories...">
            <button type="submit" id="search-button"><i class="fas fa-search"></i></button>
        </div>
    </header>

    <div class="register-container">
        <h1 class="register-title">Create Your Account</h1>

        <?= $message ?>

        <form action="register.php" method="POST" class="register-form">
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required value="<?= $username_val ?>">
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?= $email_val ?>">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="register-btn">Register</button>
        </form>

        <div class="login-link-container">
            Already have an account? <a href="login.php">Log In here</a>.
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, mirror: false });

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