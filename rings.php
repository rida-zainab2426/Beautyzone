<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rings - Beautyzone</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your Provided CSS Starts Here */
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
            text-decoration: none; /* Remove underline from logo link */
            color: var(--dark-text); /* Set color for the text logo */
            font-family: 'Playfair Display', serif; /* Apply unique font to text logo */
            font-size: 2em; /* Adjust font size for text logo */
            font-weight: 700;
        }
        /* Removed .logo img as it's no longer an image */

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
            transition: color 0.3s ease-in-out;
        }

        .search-icon:hover {
            color: var(--accent-pink); /* Pink on hover */
        }

        /* The search bar div itself (outside the main nav) */
        .search-bar {
            display: none; /* Hidden by default */
            position: absolute;
            top: 100%; /* Position below the header */
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

        /* MODIFIED Category Header for LEFT ALIGNMENT */
        .category-header {
            background-color: var(--header-light-peach); /* Matches shop.png background */
            background-image: url('imgs/header_bg_pattern.png'); /* Keep pattern, very subtle */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 20px 0;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .category-header .container {
            max-width: 1200px; /* Constrain content width */
            margin: 0 auto; /* Center the container */
            padding: 0 20px; /* Add horizontal padding */
            text-align: left; /* ALIGN TEXT TO THE LEFT */
        }

        .category-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8em;
            color: var(--dark-text); /* Black-ish color as per shop.png */
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
            font-weight: 700; /* Playfair Display's bold equivalent */
            text-align: left; /* Ensure H1 is left-aligned */
        }

        .category-header p {
            font-size: 0.9em;
            color: var(--dark-text); /* Black-ish color as per shop.png */
            position: relative;
            z-index: 1;
            text-align: left; /* Ensure paragraph is left-aligned */
            margin: 0; /* Remove default margin to ensure it hugs the corner */
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
            object-fit: contain; /* Changed from 'cover' to 'contain' as images often have white space around them */
            transition: opacity 0.3s ease;
            padding: 15px; /* Add padding to prevent images from touching edges */
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
            min-height: 50px; /* Ensure consistent height for titles */
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
            header { flex-wrap: wrap; padding: 10px 15px; justify-content: center; min-height: 60px; position: relative; } /* Added relative positioning */
            .logo { flex-basis: 100%; text-align: center; margin-bottom: 10px; }
            .logo a { height: auto; font-size: 1.8em; } /* Adjust font size for mobile logo */
            nav { width: 100%; justify-content: center; flex-direction: column; }
            .main-nav { flex-direction: column; width: 100%; background: linear-gradient(to right, #FFE4E1, #FFB6C1); padding: 10px 0; display: none; /* Hidden by default for mobile menu */ }
            .main-nav.open { display: flex; /* Show when 'open' class is added */ }
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
            /* The search icon is now part of the main-nav, adjust its display */
            .main-nav .search-icon {
                display: block; /* Show the search icon that is within the mobile nav */
                margin: 10px auto; /* Center it */
                padding: 10px 0;
                width: fit-content;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }
            .search-bar { /* This is the search bar that appears below header */
                position: absolute; /* Re-apply absolute positioning for the main search bar toggle */
                top: 100%;
                left: 0;
                transform: translateY(-10px);
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, visibility 0.3s ease-in-out;
                z-index: 999; /* Higher than main content, lower than dropdown */
            }
            .search-bar.open { /* When opened via JS, it will appear below the header */
                display: flex;
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }
            .search-bar input { max-width: none; } /* Allow input to take full width */


            .category-header { padding: 15px 0; } /* Even smaller on mobile */
            .category-header h1 { font-size: 2.2em; }
            .category-header::before {
                width: 100px; /* Smaller */
                height: 100px; /* Smaller */
                left: 5%; /* Adjusted position */
                opacity: 0.15;
            }
            .product-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                padding: 0 15px;
            }

            /* Hamburger Menu Icon for Mobile */
            .menu-toggle {
                display: block; /* Show hamburger icon on mobile */
                font-size: 1.8em;
                color: #000;
                cursor: pointer;
                margin-left: 20px;
                order: 0; /* Position before other icons */
            }
        }

        @media (max-width: 480px) {
            header { padding: 8px 10px; min-height: 50px; }
            .logo a { height: auto; font-size: 1.5em; } /* Adjust font size for smaller mobile logo */
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
        /* Your Provided CSS Ends Here */

        /* Added Mobile Menu Hamburger Icon Styling (from the previous context) */
        .menu-toggle {
            display: none; /* Hidden by default on desktop */
        }
    </style>
</head>
<body>

    <?php
    // These would typically come from a configuration or database
    // For demonstration, we'll define them here with 5 each
      $cosmeticCategories = [
          'Lipsticks' => 'lipsticks.php',
        'Foundations' => 'foundations.php',
        'Eyeshadows' => 'eyeshadows.php',
        'Blushes' => 'blushes.php',
        'Skin Care ' => 'skincare.php' // New category
    ];

    // Define jewellery categories with the new arrangements
    $jewelleryCategories = [
        'Necklaces' => 'necklaces.php',
        'Earrings' => 'earrings.php', // This is the current page
        'Rings' => 'rings.php',
        'Bracelets' => 'bracelets.php',
        'Anklets' => 'anklets.php' // New category
    ];
    
    // Define detail pages for Cosmetics dropdown active state
    $cosmeticDetailPages = [
        'hydrating_liquid_foundation_detail.php',
        'matte_finish_foundation_detail.php',
        'full_coverage_cream_foundation_detail.php',
        'mineral_powder_foundation_detail.php',
        'bb_cream_with_spf_detail.php',
        'radiant_glow_foundation_detail.php',
        // Add other cosmetic detail pages here if they exist
    ];

    // Check if the current page is one of the cosmetic detail pages
    $isCosmeticDetailPage = in_array(basename($_SERVER['PHP_SELF']), $cosmeticDetailPages);
    ?>

    <header>
        <div class="logo">
            <a href="index.php">Beautyzone</a>
        </div>
        <nav>
            <ul class="main-nav" id="mainNav">
                <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="about_us.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about_us.php') ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="contact_us.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact_us.php') ? 'active' : ''; ?>">Contact Us</a></li>
                <li class="dropdown">
                    <a href="#" class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), array_values($cosmeticCategories)) || $isCosmeticDetailPage) ? 'active' : ''; ?>">Cosmetics <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($cosmeticCategories as $name => $file) {
                            $activeClass = '';
                            if (basename($_SERVER['PHP_SELF']) == $file) {
                                $activeClass = 'active';
                            }
                            // Special logic for "Foundations" to be active if any foundation detail page is open
                            if ($name == 'Foundations' && $isCosmeticDetailPage) {
                                $activeClass = 'active';
                            }
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
                <li class="search-icon" id="searchIconInline"> <i class="fas fa-search"></i>
                </li>
            </ul>
            <div class="user-actions">
                <a href="user_profile.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'user_profile.php') ? 'active' : ''; ?>"><i class="far fa-user"></i></a>
                <a href="shopping_cart.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'shopping_cart.php') ? 'active' : ''; ?>"><i class="fas fa-shopping-bag"></i> <span class="badge">0</span></a>
            </div>
        </nav>
        <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
        <div class="search-bar" id="searchBar">
            <input type="text" id="productSearchInput" placeholder="Search for products, categories...">
            <button type="submit" id="searchButton"><i class="fas fa-search"></i></button>
        </div>
    </header>

    <section class="category-header">
        <div class="container">
            <h1>Rings</h1>
            <p><a href="index.php">Home</a> &gt; Rings</p> </div>
    </section>

    <main class="product-grid-container">
        <div class="product-grid">
            <a href="ring-detail-1.php" class="product-card-link">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="imgs/elegant diamond ring.webp" alt="Elegant Diamond Ring Front" class="product-main-image">
                        <img src="imgs/elegant diamond ring2.webp" alt="Elegant Diamond Ring Back" class="product-hover-image">
                    </div>
                    <div class="product-details">
                        <p class="product-category">Jewellery</p>
                        <h3 class="product-title">Elegant Diamond Ring</h3>
                        <p class="product-price">$299.99</p>
                    </div>
                    <span class="badge">Best</span>
                </div>
            </a>

            <a href="ring-detail-2.php" class="product-card-link">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="imgs/classic solitaire ring.webp" alt="Classic Solitaire Ring Front" class="product-main-image">
                        <img src="imgs/classic solitaire ring2.webp" alt="Classic Solitaire Ring Back" class="product-hover-image">
                    </div>
                    <div class="product-details">
                        <p class="product-category">Jewellery</p>
                        <h3 class="product-title">Classic Solitaire Ring</h3>
                        <p class="product-price">$450.00</p>
                    </div>
                </div>
            </a>

            <a href="ring-detail-3.php" class="product-card-link">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="imgs/vintage emerald ring.webp" alt="Vintage Emerald Ring Front" class="product-main-image">
                        <img src="imgs/vintage emerald ring2.webp" alt="Vintage Emerald Ring Back" class="product-hover-image">
                    </div>
                    <div class="product-details">
                        <p class="product-category">Jewellery</p>
                        <h3 class="product-title">Vintage Emerald Ring</h3>
                        <p class="product-price">$375.50</p>
                    </div>
                </div>
            </a>

            <a href="ring-detail-4.php" class="product-card-link">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="imgs/Modern Gold Band.webp" alt="Modern Gold Band Front" class="product-main-image">
                        <img src="imgs/Modern Gold Band.webp" alt="Modern Gold Band Back" class="product-hover-image">
                    </div>
                    <div class="product-details">
                        <p class="product-category">Jewellery</p>
                        <h3 class="product-title">Modern Gold Band</h3>
                        <p class="product-price">$180.00</p>
                    </div>
                    <span class="badge">New</span>
                </div>
            </a>

            <a href="ring-detail-5.php" class="product-card-link">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="imgs/Stackable Silver Ring.webp" alt="Stackable Silver Ring Front" class="product-main-image">
                        <img src="imgs/Stackable Silver Ring2.webp" alt="Stackable Silver Ring Back" class="product-hover-image">
                    </div>
                    <div class="product-details">
                        <p class="product-category">Jewellery</p>
                        <h3 class="product-title">Stackable Silver Ring</h3>
                        <p class="product-price">$85.99</p>
                    </div>
                </div>
            </a>

            <a href="ring-detail-6.php" class="product-card-link">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="imgs/Pearl Cluster Ring.webp" alt="Pearl Cluster Ring Front" class="product-main-image">
                        <img src="imgs/Pearl Cluster Ring2.webp" alt="Pearl Cluster Ring Back" class="product-hover-image">
                    </div>
                    <div class="product-details">
                        <p class="product-category">Jewellery</p>
                        <h3 class="product-title">Pearl Cluster Ring</h3>
                        <p class="product-price">$220.00</p>
                    </div>
                </div>
            </a>
        </div>
    </main>
<?php include 'footer.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.getElementById('menuToggle');
            const mainNav = document.getElementById('mainNav');
            const searchIconInline = document.getElementById('searchIconInline');
            const searchBar = document.getElementById('searchBar');
            const dropdowns = document.querySelectorAll('.main-nav .dropdown');

            // Toggle mobile navigation menu
            menuToggle.addEventListener('click', () => {
                mainNav.classList.toggle('open');
                // Close search bar if open
                if (searchBar.classList.contains('open')) {
                    searchBar.classList.remove('open');
                }
            });

            // Toggle search bar visibility (using the inline search icon now)
            searchIconInline.addEventListener('click', () => {
                searchBar.classList.toggle('open');
                // Close mobile menu if open
                if (mainNav.classList.contains('open')) {
                    mainNav.classList.remove('open');
                }
            });

            // Handle dropdowns for mobile (click to open/close)
            dropdowns.forEach(dropdown => {
                const dropdownLink = dropdown.querySelector('a');
                dropdownLink.addEventListener('click', (event) => {
                    // Prevent default link behavior if it's a dropdown toggle on mobile
                    if (window.innerWidth <= 768) {
                        event.preventDefault(); // Prevent navigating to '#'
                        // Toggle the 'open-dropdown' class on the parent li.dropdown
                        dropdown.classList.toggle('open-dropdown');
                    }
                });
            });
        });
    </script>
</body>
</html>