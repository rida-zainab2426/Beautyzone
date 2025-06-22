<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blushes - Beautyzone</title>
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
            --primary-pink: #f8e5e5; /* A soft, light pink for headers etc. */
            --dark-text: #333; /* Dark text color */
            --light-text: #666; /* Lighter grey text */
            --accent-pink: #E7746F; /* Main pink for titles, buttons, etc. (from index.php) */
            --light-accent: #F8D7C7; /* Lighter accent for subtle elements (from index.php) */
            --button-bg: #f2a7a7; /* Button background */
            --button-hover-bg: #e08c8c; /* Button hover background */
            --review-bg-color: #FBF6F3; /* Very light peach/pink for review cards background */
            --quote-color: #FDD8D0; /* A soft peach for quotes */
            /* Adjusted variable for the very light peach/pink background, matching shop.png */
            --header-light-peach: #F8E5E5; /* This matches the color in shop.png very closely */
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
            z-index: 1000; /* Ensure header is always on top */
            min-height: 70px;
        }

        /* Logo Styling */
        .logo {
            flex-shrink: 0;
        }
        .logo a {
            display: block;
            text-decoration: none; /* Remove underline */
            color: #333; /* Dark grey color for the text */
            font-family: 'Playfair Display', serif; /* Apply the unique font */
            font-size: 2em; /* Adjust font size as needed */
            font-weight: 700; /* Make it bold */
            padding: 5px 0; /* Adjust padding if necessary */
        }
        /* Removed .logo img specific styles as image is replaced by text */

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

        /* Crucial fix for active state */
        .main-nav li a:hover,
        .main-nav li a.active { /* This makes the current page's link pink */
            color: var(--accent-pink); /* Pink on hover and for active link */
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
            z-index: 1001; /* Ensure dropdown is above header and content */
            border-radius: 0 0 8px 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .dropdown:hover .dropdown-menu,
        .dropdown.open-dropdown .dropdown-menu { /* Added .open-dropdown for JS control */
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

        .dropdown:hover .arrow,
        .dropdown.open-dropdown .arrow { /* Added .open-dropdown for JS control */
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
            z-index: 998; /* Below dropdowns, but above general content */
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
            background-color: #E44D26; /* Red for emphasis - as seen in hsfgjhgjfdgjasf.png */
            color: white;
            border-radius: 50%;
            padding: 4px 7px;
            font-size: 0.7em;
            min-width: 10px;
            text-align: center;
            line-height: 1;
        }

        /* NEW/MODIFIED Category Header to match shop.png */
        .category-header {
            background-color: var(--header-light-peach); /* Matches shop.png background */
            background-image: url('imgs/header_bg_pattern.png'); /* Keep pattern, very subtle */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 20px 0; /* Reduced padding for a shorter header, as per shop.png */
            text-align: center; /* THIS CENTERS THE TEXT */
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .category-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8em;
            color: var(--dark-text); /* Black-ish color as per shop.png */
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
            font-weight: 700; /* Playfair Display's bold equivalent */
        }

        .category-header p {
            font-size: 0.9em;
            color: var(--dark-text); /* Black-ish color as per shop.png */
            position: relative;
            z-index: 1;
        }

        .category-header p a {
            color: var(--dark-text); /* Black-ish color for breadcrumb link */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .category-header p a:hover {
            color: var(--accent-pink); /* Pink on hover for breadcrumb link */
        }

        .category-header::before {
            content: '';
            background-image: url('imgs/leaf_outline.png'); /* The leaf pattern */
            background-repeat: no-repeat;
            background-size: contain;
            position: absolute;
            top: 50%;
            left: 10%; /* Adjust position to match shop.png roughly */
            transform: translateY(-50%) rotate(15deg);
            width: 150px; /* Size of the leaf */
            height: 150px;
            opacity: 0.3; /* Adjusted opacity to be subtle but visible */
            z-index: 0;
        }

        /* Product Grid */
        .product-grid-container {
            padding: 60px 0;
            background-color: #fcfafa;
            z-index: 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Link Wrapper for Product Card */
        .product-card-link {
            text-decoration: none; /* Remove underline from the link */
            color: inherit; /* Inherit text color from children */
            display: block; /* Make the whole area clickable */
            /* Add transitions to the link wrapper instead of the card for smoother effect */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative; /* Needed for badge positioning */
        }

        .product-card-link:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        .product-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); /* Initial shadow */
            overflow: hidden;
            text-align: center;
            /* Remove transitions from .product-card itself as they are on .product-card-link */
        }

        .product-image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
        }

        .product-image-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: opacity 0.3s ease;
            padding: 15px;
        }

        .product-image-wrapper .product-hover-image {
            opacity: 0;
            visibility: hidden;
        }

        /* Apply hover effects to images when the link is hovered */
        .product-card-link:hover .product-image-wrapper .product-main-image {
            opacity: 0;
            visibility: hidden;
        }

        .product-card-link:hover .product-image-wrapper .product-hover-image {
            opacity: 1;
            visibility: visible;
        }

        .product-details {
            padding: 20px 15px;
        }

        .product-category {
            font-size: 0.9em;
            color: var(--light-text);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4em;
            color: var(--dark-text);
            margin-bottom: 10px;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-price {
            font-size: 1.1em;
            color: var(--accent-pink);
            font-weight: 600;
        }

        /* Badge for "Best" */
        .product-card-link .badge { /* Target badge within the link wrapper */
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--accent-pink);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8em;
            font-weight: 600;
            z-index: 10;
        }


        /* Responsive adjustments */
        @media (max-width: 1024px) {
            header { padding: 10px 20px; }
            .main-nav li { margin-left: 20px; }
            .user-actions { margin-left: 20px; }
            .user-actions a { margin-left: 15px; }

            .category-header { padding: 18px 0; }
            .category-header h1 { font-size: 2.5em; }
            .category-header::before {
                width: 120px; /* Adjusted size */
                height: 120px; /* Adjusted size */
                left: 5%; /* Adjusted position */
                opacity: 0.2;
            }
        }

        @media (max-width: 768px) {
            header { flex-wrap: wrap; padding: 10px 15px; justify-content: center; min-height: 60px; }
            .logo { flex-basis: 100%; text-align: center; margin-bottom: 10px; }
            .logo a { font-size: 1.8em; } /* Adjust font size for mobile logo */
            nav { width: 100%; justify-content: center; flex-direction: column; }
            .main-nav { flex-direction: column; width: 100%; background: linear-gradient(to right, #FFE4E1, #FFB6C1); padding: 10px 0; }
            .main-nav li { margin: 0; border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
            .main-nav li:last-child { border-bottom: none; }
            .main-nav li a { padding: 15px 20px; text-align: center; }
            /* Fixed dropdown for mobile */
            .main-nav li.dropdown .dropdown-menu {
                display: block; /* Always show dropdown on mobile when parent is shown via JS */
                position: static;
                width: 100%;
                border: none;
                box-shadow: none;
                padding: 0;
                border-radius: 0;
                background-color: rgba(255, 255, 255, 0.9);
                opacity: 1; /* Always visible on mobile */
                visibility: visible;
                transform: translateY(0);
                z-index: 1001; /* Ensure dropdown is still on top on mobile */
            }
            .dropdown-menu li a { padding-left: 40px; }
            .search-icon, .user-actions { margin: 10px 15px; flex-basis: 100%; justify-content: center; }
            .search-icon { order: 1; }
            .user-actions { order: 2; }
            .user-actions a { margin: 0 10px; }
            .search-bar.open { top: auto; bottom: 0; transform: translateY(0); opacity: 1; visibility: visible; }

            .category-header { padding: 15px 0; } /* Even smaller on mobile */
            .category-header h1 { font-size: 2.2em; }
            .category-header::before {
                width: 120px; /* Adjusted size */
                height: 120px; /* Adjusted size */
                left: 5%; /* Adjusted position */
                opacity: 0.2;
            }
            .product-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                padding: 0 15px;
            }
        }

        @media (max-width: 480px) {
            header { padding: 8px 10px; min-height: 50px; }
            .logo a { font-size: 1.5em; } /* Adjust font size for smaller mobile logo */
            .main-nav li a { padding: 12px 15px; font-size: 0.9em; }
            .user-actions a { font-size: 1.2em; margin-left: 10px; }
            .search-bar input { padding: 10px 15px; }
            .search-bar button { padding: 10px 15px; }

            .category-header { padding: 12px 0; }
            .category-header h1 { font-size: 1.8em; }
            .category-header p { font-size: 0.8em; }
            .category-header::before {
                width: 80px;
                height: 80px;
                left: 0%;
                opacity: 0.1;
            }
            .product-grid {
                grid-template-columns: 1fr;
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>

    <?php
    // Define categories with their corresponding file names (from index.php, ensure consistency)
    $cosmeticCategories = [
        "Lipsticks" => "lipsticks.php",
        "Foundations" => "foundations.php",
        "Eye Shadows" => "eyeshadows.php",
        "Blushes" => "blushes.php", // This page itself
        "Skincare" => "skincare.php"
    ];
    $jewelleryCategories = [
        "Necklaces" => "necklaces.php",
        "Earrings" => "earrings.php",
        "Rings" => "rings.php",
        "Bracelets" => "bracelets.php",
        "Anklets" => "anklets.php"
    ];

    // Define image paths for categories. (from index.php)
    // IMPORTANT: Ensure these paths are correct relative to where your PHP files are.
    // Assuming 'imgs' folder at the root level.
    $categoryImages = [
        "Lipsticks" => "imgs/lipstick.webp",
        "Foundations" => "imgs/Foundations.webp",
        "Eye Shadows" => "imgs/Eye Shadows.webp",
        "Blushes" => "imgs/Blushes.webp",
        "Skincare" => "imgs/skincare.webp",

        "Necklaces" => "imgs/Necklaces.webp",
        "Earrings" => "imgs/Earrings.webp",
        "Rings" => "imgs/rings.webp",
        "Bracelets" => "imgs/Bracelets.webp",
        "Anklets" => "imgs/Anklets.webp"
    ];
    ?>

    <header>
        <div class="logo">
            <a href="index.php">Beautyzone</a>
        </div>
        <nav>
            <ul class="main-nav">
                <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="about_us.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about_us.php') ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="contact_us.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact_us.php') ? 'active' : ''; ?>">Contact Us</a></li>
                <li class="dropdown">
                    <a href="#" class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), array_values($cosmeticCategories))) ? 'active' : ''; ?>">Cosmetics <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($cosmeticCategories as $name => $file) {
                            $activeClass = (basename($_SERVER['PHP_SELF']) == $file) ? 'active' : '';
                            echo '<li><a href="' . htmlspecialchars($file) . '" class="' . $activeClass . '">' . htmlspecialchars($name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), array_values($jewelleryCategories))) ? 'active' : ''; ?>">Jewellery <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($jewelleryCategories as $name => $file) {
                            $activeClass = (basename($_SERVER['PHP_SELF']) == $file) ? 'active' : '';
                            echo '<li><a href="' . htmlspecialchars($file) . '" class="' . $activeClass . '">' . htmlspecialchars($name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="search-icon">
                    <i class="fas fa-search"></i>
                </li>
            </ul>
            <div class="user-actions">
                <a href="user_profile.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'user_profile.php') ? 'active' : ''; ?>"><i class="far fa-user"></i></a>
                <a href="shopping_cart.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'shopping_cart.php') ? 'active' : ''; ?>"><i class="fas fa-shopping-bag"></i> <span class="badge">0</span></a>
            </div>
        </nav>
        <div class="search-bar">
            <input type="text" id="productSearchInput" placeholder="Search for products, categories...">
            <button type="submit" id="searchButton"><i class="fas fa-search"></i></button>
        </div>
    </header>

    <header class="category-header">
        <div class="container">
            <h1>Blushes</h1>
            <p><a href="index.php">Home</a> - Blushes</p>
        </div>
    </header>

    <main class="product-grid-container">
        <div class="container">
            <div class="product-grid" id="productGrid">
                <a href="powder_blush_detail.php" class="product-card-link">
                    <div class="product-card" data-category="Blushes" data-title="Powder Blush">
                        <div class="product-image-wrapper">
                            <img src="imgs/Powder Blush Palette.webp" alt="Powder Blush" class="product-main-image">
                            <img src="imgs/Powder Blush Palette2.webp" alt="Powder Blush Hover" class="product-hover-image">
                        </div>
                        <div class="product-details">
                            <p class="product-category">Blushes</p>
                            <h3 class="product-title">Powder Blush</h3>
                            <p class="product-price">Starts from $14.00</p>
                        </div>
                    </div>
                </a>

                <a href="cream_blush_detail.php" class="product-card-link">
                    <div class="product-card" data-category="Blushes" data-title="Cream Blush">
                        <div class="product-image-wrapper">
                            <img src="imgs/Cream Blush Stick.webp" alt="Cream Blush" class="product-main-image">
                            <img src="imgs/Cream Blush Stick2.webp" alt="Cream Blush Hover" class="product-hover-image">
                        </div>
                        <div class="product-details">
                            <p class="product-category">Blushes</p>
                            <h3 class="product-title">Cream Blush</h3>
                            <p class="product-price">Starts from $16.00</p>
                        </div>
                    </div>
                </a>

                <a href="liquid_blush_detail.php" class="product-card-link">
                    <div class="product-card" data-category="Blushes" data-title="Liquid Blush">
                        <div class="product-image-wrapper">
                            <img src="imgs/Liquid Tint Blush.webp" alt="Liquid Blush" class="product-main-image">
                            <img src="imgs/Liquid Tint Blush2.webp" alt="Liquid Blush Hover" class="product-hover-image">
                        </div>
                        <div class="product-details">
                            <p class="product-category">Blushes</p>
                            <h3 class="product-title">Liquid Blush</h3>
                            <p class="product-price">Starts from $18.00</p>
                        </div>
                    </div>
                </a>

                <a href="blush_palette_detail.php" class="product-card-link">
                    <div class="product-card" data-category="Blushes" data-title="Blush Palette">
                        <div class="product-image-wrapper">
                            <img src="imgs/blush palette.webp" alt="Blush Palette" class="product-main-image">
                            <img src="imgs/blush palette2.webp" alt="Blush Palette Hover" class="product-hover-image">
                        </div>
                        <div class="product-details">
                            <p class="product-category">Blushes</p>
                            <h3 class="product-title">Blush Palette</h3>
                            <p class="product-price">Starts from $25.00</p>
                        </div>
                    </div>
                </a>

                <a href="tinted_cheek_balm_detail.php" class="product-card-link">
                    <div class="product-card" data-category="Blushes Skincare" data-title="Tinted Cheek Balm">
                        <div class="product-image-wrapper">
                            <img src="imgs/tinted blush2.webp" alt="Tinted Cheek Balm" class="product-main-image">
                            <img src="imgs/tinted blush3.webp" alt="Tinted Cheek Balm Hover" class="product-hover-image">
                        </div>
                        <div class="product-details">
                            <p class="product-category">Cheek Care</p>
                            <h3 class="product-title">Tinted Cheek Balm</h3>
                            <p class="product-price">Starts from $12.00</p>
                        </div>
                    </div>
                </a>

                <a href="mineral_blush_detail.php" class="product-card-link">
                    <div class="product-card" data-category="Blushes" data-title="Mineral Blush">
                        <div class="product-image-wrapper">
                            <img src="imgs/mineral.webp" alt="Mineral Blush" class="product-main-image">
                            <img src="imgs/mineral2.webp" alt="Mineral Blush Hover" class="product-hover-image">
                        </div>
                        <div class="product-details">
                            <p class="product-category">Blushes</p>
                            <h3 class="product-title">Mineral Blush</h3>
                            <p class="product-price">Starts from $17.00</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>
<?php include 'footer.php'; ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            mirror: false,
        });

        // Search Bar Functionality (copied directly from index.php's JS)
        const searchIcon = document.querySelector('.search-icon');
        const searchBar = document.querySelector('.search-bar');
        const header = document.querySelector('header');
        const productSearchInput = document.getElementById('productSearchInput');
        const productGrid = document.getElementById('productGrid');
        const productCards = productGrid.querySelectorAll('.product-card-link'); // Select the link wrapper

        // Toggle search bar visibility
        searchIcon.addEventListener('click', (event) => {
            event.stopPropagation();
            searchBar.classList.toggle('open');
            if (searchBar.classList.contains('open')) {
                productSearchInput.focus();
            }
        });

        // Close search bar when clicking outside header or search bar itself
        document.addEventListener('click', (event) => {
            if (!header.contains(event.target) && !searchBar.contains(event.target)) {
                if (searchBar.classList.contains('open')) {
                    searchBar.classList.remove('open');
                    productSearchInput.value = ''; // Clear search input
                    filterProducts(''); // Show all products when search bar closes
                }
            }
        });

        // Client-side Product Search Logic
        function filterProducts(searchTerm) {
            const lowerCaseSearchTerm = searchTerm.toLowerCase();

            productCards.forEach(cardLink => { // Iterate through the link wrappers
                const card = cardLink.querySelector('.product-card'); // Get the actual card inside the link
                const title = card.dataset.title.toLowerCase();
                const category = card.dataset.category.toLowerCase();

                if (title.includes(lowerCaseSearchTerm) || category.includes(lowerCaseSearchTerm)) {
                    cardLink.style.display = 'block'; // Show the card link
                } else {
                    cardLink.style.display = 'none'; // Hide the card link
                }
            });
        }

        productSearchInput.addEventListener('input', (event) => {
            filterProducts(event.target.value);
        });

        document.getElementById('searchButton').addEventListener('click', () => {
            filterProducts(productSearchInput.value);
        });


        // Dropdown Menu Functionality (for mobile/tablet)
        document.querySelectorAll('.main-nav .dropdown > a').forEach(item => {
            item.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    let parentLi = this.closest('.dropdown');
                    if (parentLi.classList.contains('open-dropdown')) {
                        // If it's already open, let the default behavior (navigation) happen on second click
                    } else {
                        event.preventDefault(); // Prevent default navigation on first click to open dropdown
                        document.querySelectorAll('.main-nav .dropdown').forEach(dropdown => {
                            if (dropdown !== parentLi) {
                                dropdown.classList.remove('open-dropdown');
                            }
                        });
                        parentLi.classList.add('open-dropdown'); // Open the clicked dropdown
                    }
                }
            });
        });

        // Close dropdowns if clicking outside on mobile
        document.addEventListener('click', (event) => {
            if (window.innerWidth <= 768) {
                document.querySelectorAll('.main-nav .dropdown.open-dropdown').forEach(dropdown => {
                    if (!dropdown.contains(event.target) && !searchBar.contains(event.target)) {
                        dropdown.classList.remove('open-dropdown');
                    }
                });
            }
        });
    </script>

</body>
</html>