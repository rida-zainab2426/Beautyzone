<?php
session_start();

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

// Calculate total items in cart for the badge (copied from shopping_cart.php)
$totalCartItems = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalCartItems += $item['quantity'];
    }
}

// You might want to pre-fill some fields if the user is logged in
// For now, we'll leave them empty.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Beautyzone</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        /* General Body Styling */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5; /* Light grey, can be considered 'off-white' */
            color: #333; /* Dark grey, close to black */
        }

        /* Unique Font for Headings */
        h1, h2, .section-title, .category-name {
            font-family: 'Playfair Display', serif;
        }

        /* Color Variables (Moved to :root for global access) */
        :root {
            --review-bg-color: #FBF6F3; /* Very light peach/pink for review cards background */
            --text-dark: #333; /* Dark text color */
            --accent-pink: #E7746F; /* Main pink for titles, buttons, etc. */
            --light-accent: #F8D7C7; /* Lighter accent for subtle elements */
            --quote-color: #FDD8D0; /* A soft peach for quotes */
            --input-bg-color: #FFFFFF; /* White background for input */
            --input-border-color: #E0E0E0; /* Light border for input */
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

        /* Logo Text Styling */
        .logo {
            flex-shrink: 0;
        }
        .logo a {
            text-decoration: none;
            display: block;
        }
        .logo span {
            font-family: 'Playfair Display', serif; /* Elegant font for text logo */
            font-size: 2.2em; /* Adjust size as needed */
            font-weight: 700;
            color: var(--text-dark); /* Dark color for contrast */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            transition: color 0.3s ease-in-out;
        }
        .logo span:hover {
            color: var(--accent-pink); /* Pink on hover */
        }

        /* Navigation Styling */
        nav {
            display: flex;
            align-items: center;
            flex-grow: 1;
            justify-content: flex-end;
        }

        .main-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main-nav li {
            margin-left: 30px;
            position: relative;
        }

        .main-nav li a {
            text-decoration: none;
            color: #000; /* Font color set to black */
            font-weight: 600;
            padding: 10px 0;
            display: block;
            transition: color 0.3s ease-in-out;
        }

        .main-nav li a:hover {
            color: var(--accent-pink); /* Pink on hover */
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #FFFFFF; /* White */
            border: 1px solid #E0E0E0;
            border-top: none;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            padding: 10px 0;
            min-width: 180px;
            z-index: 999;
            border-radius: 0 0 8px 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu li a {
            padding: 10px 20px;
            color: #444; /* Dark grey, close to black */
            white-space: nowrap;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }

        .dropdown-menu li a:hover {
            background-color: #F0F0F0; /* Light grey/off-white */
            color: var(--accent-pink); /* Pink on hover */
        }

        .arrow {
            margin-left: 8px;
            font-size: 0.7em;
            vertical-align: middle;
            transition: transform 0.3s ease-in-out;
        }

        .dropdown:hover .arrow {
            transform: rotate(180deg);
        }

        /* Search Bar & User Actions */
        .search-icon {
            cursor: pointer;
            font-size: 1.4em;
            color: #000; /* Black */
            margin-left: 30px;
            transition: color 0.3s ease-in-out;
        }

        .search-icon:hover {
            color: var(--accent-pink); /* Pink on hover */
        }

        .search-bar {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: var(--light-accent); /* Light accent pink for search bar */
            padding: 15px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s ease-in-out;
            justify-content: center;
        }
        .search-bar.open {
            display: flex;
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .search-bar input {
            flex-grow: 1;
            padding: 12px 20px;
            border: 1px solid #E0E0E0;
            border-radius: 25px;
            outline: none;
            font-size: 1em;
            max-width: 600px;
            margin-right: 10px;
        }

        .search-bar button {
            background-color: var(--accent-pink); /* Pink for search button */
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease-in-out;
        }

        .search-bar button:hover {
            background-color: #D25F5C; /* Darker pink on hover */
        }

        .user-actions {
            display: flex;
            align-items: center;
            margin-left: 30px;
        }

        .user-actions a {
            color: #000; /* Black */
            font-size: 1.4em;
            margin-left: 20px;
            position: relative;
            transition: color 0.3s ease-in-out;
        }

        .user-actions a:hover {
            color: var(--accent-pink); /* Pink on hover */
        }

        .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #E44D26; /* Red for emphasis */
            color: white;
            border-radius: 50%;
            padding: 4px 7px;
            font-size: 0.7em;
            min-width: 10px;
            text-align: center;
            line-height: 1;
        }

        /* Checkout Specific Styling */
        .checkout-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 200px); /* Adjust to push footer down */
        }

        .checkout-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5em;
            color: var(--accent-pink);
            text-align: center;
            margin-bottom: 40px;
        }

        .checkout-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .checkout-form input[type="text"],
        .checkout-form input[type="email"],
        .checkout-form input[type="tel"],
        .checkout-form input[type="date"],
        .checkout-form select,
        .checkout-form textarea {
            width: calc(100% - 22px); /* Account for padding and border */
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid var(--input-border-color);
            border-radius: 5px;
            font-size: 1em;
            background-color: var(--input-bg-color);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .checkout-form input[type="text"]:focus,
        .checkout-form input[type="email"]:focus,
        .checkout-form input[type="tel"]:focus,
        .checkout-form input[type="date"]:focus,
        .checkout-form select:focus,
        .checkout-form textarea:focus {
            border-color: var(--accent-pink);
            box-shadow: 0 0 0 3px rgba(231, 116, 111, 0.2);
            outline: none;
        }

        .checkout-form textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0; /* Remove bottom margin from inner groups */
        }

        .submit-checkout-btn {
            background-color: var(--accent-pink);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: 600;
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 30px auto 0;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .submit-checkout-btn:hover {
            background-color: #D25F5C;
            transform: translateY(-2px);
        }

        /* Responsive Design (copied and adapted from shopping_cart.php) */
        @media (max-width: 1024px) {
            .main-nav li { margin-left: 20px; }
            .user-actions { margin-left: 20px; }
            .user-actions a { margin-left: 15px; }

            .checkout-container {
                margin: 20px auto;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            header { flex-wrap: wrap; padding: 10px 15px; justify-content: center; min-height: 60px; }
            .logo { flex-basis: 100%; text-align: center; margin-bottom: 10px; }
            .logo span { font-size: 2em; }
            nav { width: 100%; justify-content: center; flex-direction: column; }
            .main-nav { flex-direction: column; width: 100%; background: linear-gradient(to right, #FFE4E1, #FFB6C1); padding: 10px 0; }
            .main-nav li { margin: 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
            .main-nav li:last-child { border-bottom: none; }
            .main-nav li a { padding: 15px 20px; text-align: center; }
            .dropdown-menu { position: static; width: 100%; border: none; box-shadow: none; padding: 0; border-radius: 0; background-color: rgba(255, 255, 255, 0.9); }
            .dropdown-menu li a { padding-left: 40px; }
            .search-icon, .user-actions { margin: 10px 15px; flex-basis: 100%; justify-content: center; }
            .search-icon { order: 1; }
            .user-actions { order: 2; }
            .user-actions a { margin: 0 10px; }
            .search-bar.open { top: auto; bottom: 0; transform: translateY(0); opacity: 1; visibility: visible; }

            .checkout-title { font-size: 2em; margin-bottom: 30px; }
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            .form-row .form-group {
                margin-bottom: 20px;
            }
            .checkout-form input[type="text"],
            .checkout-form input[type="email"],
            .checkout-form input[type="tel"],
            .checkout-form input[type="date"],
            .checkout-form select,
            .checkout-form textarea {
                width: calc(100% - 24px); /* Adjust for smaller padding/border */
            }
        }

        @media (max-width: 480px) {
            header { padding: 8px 10px; min-height: 50px; }
            .logo span { height: 40px; font-size: 1.8em;}
            .main-nav li a { padding: 12px 15px; font-size: 0.9em; }
            .user-actions a { font-size: 1.2em; margin-left: 10px; }
            .search-bar input { padding: 10px 15px; }
            .search-bar button { padding: 10px 15px; }

            .checkout-title { font-size: 1.8em; margin-bottom: 25px; }
            .checkout-form input[type="text"],
            .checkout-form input[type="email"],
            .checkout-form input[type="tel"],
            .checkout-form input[type="date"],
            .checkout-form select,
            .checkout-form textarea {
                padding: 10px;
            }
            .submit-checkout-btn { padding: 12px 25px; font-size: 1.1em; }
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

    <div class="checkout-container">
        <h1 class="checkout-title">Checkout Information</h1>

        <form action="process_checkout.php" method="POST" class="checkout-form">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="address">Shipping Address:</label>
                <textarea id="address" name="address" rows="3" required placeholder="Street Address, City, State, Zip Code"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                </div>
                <div class="form-group">
                    <label for="work_phone">Work Phone No.:</label>
                    <input type="tel" id="work_phone" name="work_phone" placeholder="e.g., +123-456-7890">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cell_no">Cell No.:</label>
                    <input type="tel" id="cell_no" name="cell_no" required placeholder="e.g., +123-456-7890">
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth:</label>
                    <input type="date" id="dob" name="dob">
                </div>
            </div>

            <div class="form-group">
                <label for="category">Preferred Product Category:</label>
                <select id="category" name="category">
                    <option value="">-- Select One --</option>
                    <optgroup label="Cosmetics">
                        <?php foreach ($cosmeticCategories as $name => $file): ?>
                            <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Jewellery">
                        <?php foreach ($jewelleryCategories as $name => $file): ?>
                            <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks (Other additional information):</label>
                <textarea id="remarks" name="remarks" rows="4" placeholder="Any special instructions or requests..."></textarea>
            </div>

            <button type="submit" class="submit-checkout-btn">Complete Order</button>
        </form>
    </div>

    <?php include 'footer.php'; // Ensure you have a footer.php file ?>

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
                // In a real application, you'd redirect or fetch search results
                // window.location.href = 'search_results.php?query=' + encodeURIComponent(query);
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