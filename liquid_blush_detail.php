<?php
session_start(); // Start the session to manage cart

// Define categories for navigation (copied from index.php or common include)
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

// Calculate total items in cart for the badge (from shopping_cart.php)
$totalCartItems = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalCartItems += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquid Blush - Beautyzone</title>
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
            text-decoration: none;
            color: #000;
            font-family: 'Playfair Display', serif;
            font-size: 2em;
            font-weight: 700;
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

        /* Product Detail Styling */
        .product-detail-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 60px 20px;
            max-width: 1200px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            gap: 40px;
        }

        .product-images {
            flex: 1;
            min-width: 300px;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .product-detail-image-wrapper { /* Consolidated main image wrapper */
            position: relative;
            width: 100%;
            padding-top: 100%; /* 1:1 Aspect Ratio */
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-detail-image-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain; /* Keep images from being cropped */
            border-radius: 10px;
            transition: opacity 0.3s ease;
            padding: 15px; /* Inner padding for the image */
        }

        .product-detail-image-wrapper .product-hover-image {
            opacity: 0;
            visibility: hidden;
        }

        .product-detail-image-wrapper:hover .product-main-image {
            opacity: 0;
            visibility: hidden;
        }

        .product-detail-image-wrapper:hover .product-hover-image {
            opacity: 1;
            visibility: visible;
        }

        .thumbnail-images {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding-top: 10px;
        }

        .thumbnail-image {
            width: 80px;
            height: 80px;
            object-fit: contain; /* Use contain for thumbnails too */
            border-radius: 8px;
            border: 2px solid #eee;
            cursor: pointer;
            transition: border-color 0.3s ease;
            padding: 5px; /* Small padding for thumbnails */
        }

        .thumbnail-image:hover, .thumbnail-image.active {
            border-color: var(--accent-pink);
        }

        .product-info {
            flex: 1;
            min-width: 300px;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: left;
        }

        .product-title {
            font-size: 2.8em;
            color: var(--dark-text);
            margin-bottom: 10px;
            font-weight: 700;
            line-height: 1.2;
        }

        .customer-review-summary {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: #666;
            font-size: 0.95em;
        }

        .customer-review-summary .stars {
            color: var(--accent-pink);
            margin-right: 10px;
        }

        .product-price {
            font-size: 2.2em;
            color: var(--accent-pink);
            font-weight: 700;
            margin-bottom: 20px;
        }

        .product-availability {
            font-size: 1em;
            color: #5cb85c; /* Green for in stock */
            font-weight: 600;
            margin-bottom: 20px;
        }

        .product-description {
            font-size: 1.05em;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .quantity-selector button {
            background-color: var(--light-accent);
            color: var(--dark-text);
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .quantity-selector button:hover {
            background-color: var(--accent-pink);
            color: #fff;
        }

        .quantity-selector input {
            width: 60px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px 0;
            margin: 0 10px;
            font-size: 1.1em;
            color: var(--dark-text);
        }

        .add-to-cart-btn {
            background-color: var(--accent-pink);
            color: #FFFFFF;
            padding: 15px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
            border: none; /* Make it a button, not a link */
            cursor: pointer;
            display: inline-block;
            width: fit-content;
            margin-bottom: 30px;
        }

        .add-to-cart-btn:hover {
            background-color: #D25F5C;
            transform: translateY(-3px);
        }

        .share-options {
            margin-bottom: 30px;
        }

        .share-options i {
            margin-right: 15px;
            font-size: 1.8em;
            color: #555;
        }

        .share-options i {
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .share-options i:hover {
            color: var(--accent-pink);
        }

        .product-features-list {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .product-features-list li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 1.0em;
            color: #444;
        }

        .product-features-list li i {
            color: var(--accent-pink);
            margin-right: 15px;
            font-size: 1.2em;
        }

        /* Responsive Design for Product Detail Page */
        @media (max-width: 1024px) {
            .product-detail-container {
                flex-direction: column;
                align-items: center;
                padding: 40px 15px;
                margin: 20px auto;
            }

            .product-images, .product-info {
                max-width: 90%;
            }
        }

        @media (max-width: 768px) {
            .product-detail-container {
                padding: 30px 10px;
                margin: 15px auto;
            }
            .product-title {
                font-size: 2.2em;
            }
            .product-price {
                font-size: 1.8em;
            }
            .product-availability {
                font-size: 0.9em;
            }
            .product-description {
                font-size: 0.95em;
            }
            .add-to-cart-btn {
                padding: 12px 25px;
                font-size: 1em;
            }
            .share-options i {
                margin-right: 10px;
                font-size: 1.5em;
            }
        }

        @media (max-width: 480px) {
            .product-detail-container {
                padding: 20px 10px;
            }
            .product-title {
                font-size: 1.8em;
                text-align: center;
            }
            .customer-review-summary {
                justify-content: center;
            }
            .product-price {
                font-size: 1.5em;
                text-align: center;
            }
            .product-availability {
                text-align: center;
            }
            .product-info {
                align-items: center;
                text-align: center;
            }
            .quantity-selector {
                justify-content: center;
            }
            .product-description, .product-features-list {
                text-align: left; /* Keep description left-aligned for readability */
            }
            .share-options {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                margin-bottom: 20px;
            }
            .share-options i {
                margin: 5px;
            }
            .product-features-list li {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <a href="index.php">Beautyzone</a>
        </div>
        <nav>
            <ul class="main-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li class="dropdown">
                    <a href="#" class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), array_values($cosmeticCategories)) || basename($_SERVER['PHP_SELF']) == 'liquid_blush_detail.php') ? 'active' : ''; ?>">Cosmetics <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($cosmeticCategories as $name => $file) {
                            $activeClass = (basename($_SERVER['PHP_SELF']) == $file || (strpos(basename($_SERVER['PHP_SELF']), 'blush') !== false && $name == 'Blushes')) ? 'active' : '';
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
                <a href="shopping_cart.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'shopping_cart.php') ? 'active' : ''; ?>"><i class="fas fa-shopping-bag"></i> <span class="badge" id="cartBadge"><?php echo $totalCartItems; ?></span></a>
            </div>
        </nav>
        <div class="search-bar">
            <input type="text" id="productSearchInput" placeholder="Search for products, categories...">
            <button type="submit" id="searchButton"><i class="fas fa-search"></i></button>
        </div>
    </header>

    <header class="category-header">
        <div class="container">
            <h1>Liquid Blush</h1>
            <p><a href="index.php">Home</a> - <a href="blushes.php">Blushes</a> - Liquid Blush</p>
        </div>
    </header>

    <div class="product-detail-container">
        <div class="product-images">
            <div class="product-detail-image-wrapper">
                <img src="imgs/Liquid Tint Blush.webp" alt="Liquid Blush Main" class="product-main-image" id="mainProductImage">
                <img src="imgs/Liquid Tint Blush2.webp" alt="Liquid Blush Hover" class="product-hover-image">
            </div>
            <div class="thumbnail-images">
                <img src="imgs/Liquid Tint Blush.webp" alt="Liquid Blush Thumbnail 1" class="thumbnail-image active" onclick="changeMainImage(this)">
                <img src="imgs/Liquid Tint Blush2.webp" alt="Liquid Blush Thumbnail 2" class="thumbnail-image" onclick="changeMainImage(this)">
            </div>
        </div>

        <div class="product-info">
            <h1 class="product-title" data-product-id="liquid_blush">Liquid Blush</h1>
            <div class="customer-review-summary">
                <span class="stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </span>
                (15 Customer Reviews)
            </div>
            <p class="product-price" data-price="28.00">$28.00</p>
            <p class="product-availability">In Stock: <span id="itemsInStock">80</span> Items</p>
            <p class="product-description">
                Experience a weightless, long-lasting flush with our Liquid Blush. Its innovative formula provides a natural, dewy finish that blends seamlessly, enhancing your complexion with a vibrant pop of color. Buildable and easy to apply.
            </p>

            <form action="shopping_cart.php" method="get">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="liquid_blush">
                <input type="hidden" name="name" value="Liquid Blush">
                <input type="hidden" name="price" value="28.00">
                <input type="hidden" name="image" id="productHiddenImage" value="imgs/Liquid Blush.webp">

                <div class="quantity-selector">
                    <button type="button" id="subtractQuantity">-</button>
                    <input type="text" value="1" id="productQuantity" name="qty" readonly>
                    <button type="button" id="addQuantity">+</button>
                </div>

                <button type="submit" class="add-to-cart-btn"><i class="fas fa-shopping-bag"></i> Add to Cart</button>
            </form>
            <div class="share-options">
                <p>Share:</p>
                <i class="fab fa-facebook"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-linkedin"></i>
                <i class="fas fa-envelope"></i>
            </div>

            <ul class="product-features-list">
                <li><i class="fas fa-weight-less"></i> Weightless & Long-Lasting</li>
                <li><i class="fas fa-glass-water"></i> Natural, Dewy Finish</li>
                <li><i class="fas fa-palette"></i> Vibrant Pop of Color</li>
                <li><i class="fas fa-layer-group"></i> Buildable & Seamless</li>
                <li><i class="fas fa-spray-can"></i> Easy to Apply</li>
            </ul>
        </div>
    </div>
<?php include 'footer.php'; ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            mirror: false,
        });

        // Navbar and Search Bar functionality
        const searchIcon = document.querySelector('.search-icon');
        const searchBar = document.querySelector('.search-bar');
        const header = document.querySelector('header');
        const productSearchInput = document.getElementById('productSearchInput');

        searchIcon.addEventListener('click', (event) => {
            event.stopPropagation();
            searchBar.classList.toggle('open');
            if (searchBar.classList.contains('open')) {
                productSearchInput.focus();
            }
        });

        document.addEventListener('click', (event) => {
            if (!header.contains(event.target) && !searchBar.contains(event.target)) {
                if (searchBar.classList.contains('open')) {
                    searchBar.classList.remove('open');
                    productSearchInput.value = ''; // Clear search input when closing
                }
            }
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
                    // Check if the click is outside the dropdown itself and not on the search bar
                    if (!dropdown.contains(event.target) && !searchBar.contains(event.target)) {
                        dropdown.classList.remove('open-dropdown');
                    }
                });
            }
        });

        // This ensures the dropdowns are hidden when resizing from mobile to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                document.querySelectorAll('.main-nav .dropdown.open-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('open-dropdown');
                });
            }
        });

        // Product Quantity Selector
        const subtractBtn = document.getElementById('subtractQuantity');
        const addBtn = document.getElementById('addQuantity');
        const quantityInput = document.getElementById('productQuantity');
        const itemsInStockSpan = document.getElementById('itemsInStock');
        const productHiddenImageInput = document.getElementById('productHiddenImage'); // Get the hidden input for image

        let currentQuantity = parseInt(quantityInput.value);
        let itemsInStock = parseInt(itemsInStockSpan.textContent);

        subtractBtn.addEventListener('click', () => {
            if (currentQuantity > 1) {
                currentQuantity--;
                quantityInput.value = currentQuantity;
            }
        });

        addBtn.addEventListener('click', () => {
            if (currentQuantity < itemsInStock) { // Prevent adding more than available stock
                currentQuantity++;
                quantityInput.value = currentQuantity;
            } else {
                alert('Maximum stock reached!');
            }
        });

        // Image Gallery Functionality (for thumbnails to change main image)
        function changeMainImage(thumbnail) {
            const mainProductImage = document.getElementById('mainProductImage');
            const productHoverImage = document.querySelector('.product-hover-image');

            mainProductImage.src = thumbnail.src;
            if (productHoverImage) {
                productHoverImage.src = thumbnail.src;
            }

            // IMPORTANT: Update the hidden input field for the image so it's sent with the form
            // This ensures the *currently displayed* image is what gets added to the cart
            productHiddenImageInput.value = thumbnail.src;

            const thumbnails = document.querySelectorAll('.thumbnail-image');
            thumbnails.forEach(thumb => thumb.classList.remove('active'));

            thumbnail.classList.add('active');
        }

        // Initial update of the hidden image input when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            productHiddenImageInput.value = document.getElementById('mainProductImage').src;
        });

    </script>

</body>
</html>