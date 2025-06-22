<?php
// Start the session at the very beginning of the file
session_start();

// Define product details for Pearl Drops
$product = [
    'id' => 'EPRL002', // Unique Product ID for Pearl Drops
    'name' => 'Pearl Drops',
    'price' => 95.00,
    // IMPORTANT: Ensure these paths are correct relative to where your shopping_cart.php and product_detail files are.
    'image' => 'imgs/hoops1.webp', // Main image path
    'hover_image' => 'imgs/hoops2.webp', // Hover image path
    'description' => 'Elegance personified, our Pearl Drop earrings feature lustrous freshwater pearls suspended from delicate, polished settings. These classic earrings offer a subtle shimmer and sophisticated charm, perfect for adding a touch of grace to both casual and formal attire. Lightweight and comfortable, they are designed for all-day wear, making them a timeless staple in any jewelry collection.',
    'stock' => 40, // Example stock
    'reviews' => 20, // Example reviews
];

// Define categories with their corresponding file names (copied from index.php)
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

// Define image paths for categories. (copied from index.php)
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

// Handle adding to cart, similar to test.php
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image']; // Get the image path
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            // Update quantity if product already in cart
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            // Add new product to cart
            $_SESSION['cart'][$productId] = [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity,
                'image' => $productImage // Store the image path
            ];
        }
    }
    // Redirect to shopping cart page after adding to cart
    header('Location: shopping_cart.php');
    exit();
}

// Calculate total items in cart for the badge
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
    <title><?php echo htmlspecialchars($product['name']); ?> - Beautyzone</title>
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
        }
        .logo img {
            height: 60px;
            width: auto;
            display: block;
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
            border: none;
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
                text-align: center; /* Centered heading for small screens */
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
                text-align: center; /* Ensures content within product-info is centered */
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
            <a href="index.php"><img src="imgs/logo.png" alt="Beautyzone Logo"></a>
        </div>
        <nav>
            <ul class="main-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="contact_us.php">Contact Us</a></li>
                <li class="dropdown">
                    <a href="#" class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), array_values($cosmeticCategories)) || basename($_SERVER['PHP_SELF']) == 'liquid_matte_lipstick_detail.php' || basename($_SERVER['PHP_SELF']) == 'velvet_matte_lipstick_detail.php' || basename($_SERVER['PHP_SELF']) == 'hydrating_lip_gloss_detail.php' || basename($_SERVER['PHP_SELF']) == 'long_lasting_lip_liner_detail.php' || basename($_SERVER['PHP_SELF']) == 'sheer_tinted_lip_balm_detail.php' || basename($_SERVER['PHP_SELF']) == 'creamy_satin_lipstick_detail.php' || basename($_SERVER['PHP_SELF']) == 'hydrating_liquid_foundation_detail.php' || basename($_SERVER['PHP_SELF']) == 'matte_finish_foundation_detail.php' || basename($_SERVER['PHP_SELF']) == 'full_coverage_cream_foundation_detail.php' || basename($_SERVER['PHP_SELF']) == 'powder_blush_detail.php' || basename($_SERVER['PHP_SELF']) == 'cream_blush_detail.php' || basename($_SERVER['PHP_SELF']) == 'liquid_blush_detail.php' || basename($_SERVER['PHP_SELF']) == 'blush_palette_detail.php' || basename($_SERVER['PHP_SELF']) == 'tinted_cheek_balm_detail.php' || basename($_SERVER['PHP_SELF']) == 'mineral_blush_detail.php' || basename($_SERVER['PHP_SELF']) == 'hydrating_face_cleanser.php' || basename($_SERVER['PHP_SELF']) == 'anti_aging_serum.php' || basename($_SERVER['PHP_SELF']) == 'daily_moisturizer_spf.php' || basename($_SERVER['PHP_SELF']) == 'detoxifying_clay_mask.php' || basename($_SERVER['PHP_SELF']) == 'brightening_vitamin_c_eye_cream.php' || basename($_SERVER['PHP_SELF']) == 'acne_treatment_spot_gel.php') ? 'active' : ''; ?>">Cosmetics <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        // Also make the specific category active if on a detail page
                        foreach ($cosmeticCategories as $name => $file) {
                            $activeClass = (basename($_SERVER['PHP_SELF']) == $file || (basename($_SERVER['PHP_SELF']) == 'hydrating_liquid_foundation_detail.php' && $name == 'Foundations') || (basename($_SERVER['PHP_SELF']) == 'matte_finish_foundation_detail.php' && $name == 'Foundations') || (basename($_SERVER['PHP_SELF']) == 'full_coverage_cream_foundation_detail.php' && $name == 'Foundations') || (basename($_SERVER['PHP_SELF']) == 'powder_blush_detail.php' && $name == 'Blushes') || (basename($_SERVER['PHP_SELF']) == 'cream_blush_detail.php' && $name == 'Blushes') || (basename($_SERVER['PHP_SELF']) == 'liquid_blush_detail.php' && $name == 'Blushes') || (basename($_SERVER['PHP_SELF']) == 'blush_palette_detail.php' && $name == 'Blushes') || (basename($_SERVER['PHP_SELF']) == 'tinted_cheek_balm_detail.php' && $name == 'Blushes') || (basename($_SERVER['PHP_SELF']) == 'mineral_blush_detail.php' && $name == 'Blushes') || (basename($_SERVER['PHP_SELF']) == 'hydrating_face_cleanser.php' && $name == 'Skincare') || (basename($_SERVER['PHP_SELF']) == 'anti_aging_serum.php' && $name == 'Skincare') || (basename($_SERVER['PHP_SELF']) == 'daily_moisturizer_spf.php' && $name == 'Skincare') || (basename($_SERVER['PHP_SELF']) == 'detoxifying_clay_mask.php' && $name == 'Skincare') || (basename($_SERVER['PHP_SELF']) == 'brightening_vitamin_c_eye_cream.php' && $name == 'Skincare') || (basename($_SERVER['PHP_SELF']) == 'acne_treatment_spot_gel.php' && $name == 'Skincare')) ? 'active' : '';
                            echo '<li><a href="' . htmlspecialchars($file) . '" class="' . $activeClass . '">' . htmlspecialchars($name) . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="<?php echo (in_array(basename($_SERVER['PHP_SELF']), array_values($jewelleryCategories)) || basename($_SERVER['PHP_SELF']) == 'product_detail_delicate_gold_chain.php' || basename($_SERVER['PHP_SELF']) == 'product_detail_pearl_pendant_necklace.php' || basename($_SERVER['PHP_SELF']) == 'product_detail_sterling_silver_choker.php' || basename($_SERVER['PHP_SELF']) == 'product_detail_crystal_necklace.php' || basename($_SERVER['PHP_SELF']) == 'product_detail_zodiac_necklace.php' || basename($_SERVER['PHP_SELF']) == 'product_detail_multi_layered_necklace.php' || basename($_SERVER['PHP_SELF']) == 'earring-detail-1.php' || basename($_SERVER['PHP_SELF']) == 'earring-detail-2.php') ? 'active' : ''; ?>">Jewellery <i class="fas fa-chevron-down arrow"></i></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($jewelleryCategories as $name => $file) {
                            $activeClass = (basename($_SERVER['PHP_SELF']) == $file || (basename($_SERVER['PHP_SELF']) == 'product_detail_delicate_gold_chain.php' && $name == 'Necklaces') || (basename($_SERVER['PHP_SELF']) == 'product_detail_pearl_pendant_necklace.php' && $name == 'Necklaces') || (basename($_SERVER['PHP_SELF']) == 'product_detail_sterling_silver_choker.php' && $name == 'Necklaces') || (basename($_SERVER['PHP_SELF']) == 'product_detail_crystal_necklace.php' && $name == 'Necklaces') || (basename($_SERVER['PHP_SELF']) == 'product_detail_zodiac_necklace.php' && $name == 'Necklaces') || (basename($_SERVER['PHP_SELF']) == 'product_detail_multi_layered_necklace.php' && $name == 'Necklaces') || (basename($_SERVER['PHP_SELF']) == 'earring-detail-1.php' && $name == 'Earrings') || (basename($_SERVER['PHP_SELF']) == 'earring-detail-2.php' && $name == 'Earrings')) ? 'active' : '';
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
                <a href="shopping_cart.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'shopping_cart.php') ? 'active' : ''; ?>"><i class="fas fa-shopping-bag"></i> <span class="badge"><?php echo $totalCartItems; ?></span></a>
            </div>
        </nav>
        <div class="search-bar">
            <input type="text" id="productSearchInput" placeholder="Search for products, categories...">
            <button type="submit" id="searchButton"><i class="fas fa-search"></i></button>
        </div>
    </header>

    <header class="category-header">
        <div class="container">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p><a href="index.php">Home</a> - <a href="earrings.php">Jewellery</a> - <?php echo htmlspecialchars($product['name']); ?></p>
        </div>
    </header>

    <div class="product-detail-container">
        <div class="product-images">
            <div class="product-detail-image-wrapper">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Main" class="product-main-image" id="mainProductImage">
                <?php if (isset($product['hover_image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['hover_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Hover" class="product-hover-image">
                <?php endif; ?>
            </div>
            <div class="thumbnail-images">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Thumbnail 1" class="thumbnail-image active" onclick="changeMainImage(this)">
                <?php if (isset($product['hover_image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['hover_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Thumbnail 2" class="thumbnail-image" onclick="changeMainImage(this)">
                <?php endif; ?>
            </div>
        </div>

        <div class="product-info">
            <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="customer-review-summary">
                <span class="stars">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fas fa-star" style="<?php echo ($i < $product['reviews']) ? 'color: var(--accent-pink);' : ''; ?>"></i>
                    <?php endfor; ?>
                </span>
                (<?php echo htmlspecialchars($product['reviews']); ?> Customer Reviews)
            </div>
            <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
            <p class="product-availability">In Stock: <span id="itemsInStock"><?php echo htmlspecialchars($product['stock']); ?></span> Items</p>
            <p class="product-description">
                <?php echo htmlspecialchars($product['description']); ?>
            </p>

            <form action="earring-detail-2.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">
                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">

                <div class="quantity-selector">
                    <button type="button" id="subtractQuantity">-</button>
                    <input type="text" name="quantity" value="1" id="productQuantity" readonly min="1">
                    <button type="button" id="addQuantity">+</button>
                </div>

                <button type="submit" name="add_to_cart" class="add-to-cart-btn"><i class="fas fa-shopping-bag"></i> Add to Cart</button>
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
                <li><i class="fas fa-truck"></i> Free Shipping Over $49</li>
                <li><i class="fas fa-tag"></i> 10% Off On First Purchase</li>
                <li><i class="fas fa-undo-alt"></i> Easy Return & Refunds</li>
                <li><i class="fas fa-lock"></i> Secure Online Payment</li>
                <li><i class="fas fa-box"></i> Free Sample On Every Product</li>
            </ul>
        </div>
    </div>
<?php include 'footer.php';   ?>
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

        searchIcon.addEventListener('click', () => {
            searchBar.classList.toggle('open');
            document.querySelectorAll('.main-nav .dropdown.open-dropdown').forEach(dropdown => {
                dropdown.classList.remove('open-dropdown');
            });
        });

        document.addEventListener('click', (event) => {
            if (!searchBar.contains(event.target) && !searchIcon.contains(event.target) && searchBar.classList.contains('open')) {
                searchBar.classList.remove('open');
            }
        });

        document.querySelectorAll('.main-nav .dropdown > a').forEach(dropdownToggle => {
            dropdownToggle.addEventListener('click', function(event) {
                const parentLi = this.parentElement;
                if (window.innerWidth <= 768) {
                    event.preventDefault();
                    document.querySelectorAll('.main-nav .dropdown').forEach(dropdown => {
                        if (dropdown !== parentLi) {
                            dropdown.classList.remove('open-dropdown');
                        }
                    });
                    parentLi.classList.add('open-dropdown');
                }
            });
        });

        document.addEventListener('click', (event) => {
            if (window.innerWidth <= 768) {
                document.querySelectorAll('.main-nav .dropdown.open-dropdown').forEach(dropdown => {
                    if (!dropdown.contains(event.target) && !searchBar.contains(event.target)) {
                        dropdown.classList.remove('open-dropdown');
                    }
                });
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                document.querySelectorAll('.main-nav .dropdown.open-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('open-dropdown');
                });
            }
        });

        // Product Detail Page Quantity Selector
        const subtractQuantityBtn = document.getElementById('subtractQuantity');
        const addQuantityBtn = document.getElementById('addQuantity');
        const productQuantityInput = document.getElementById('productQuantity');
        const itemsInStockSpan = document.getElementById('itemsInStock');

        let currentQuantity = parseInt(productQuantityInput.value);
        let itemsInStock = parseInt(itemsInStockSpan.textContent);

        subtractQuantityBtn.addEventListener('click', () => {
            if (currentQuantity > 1) {
                currentQuantity--;
                productQuantityInput.value = currentQuantity;
            }
        });

        addQuantityBtn.addEventListener('click', () => {
            if (currentQuantity < itemsInStock) {
                currentQuantity++;
                productQuantityInput.value = currentQuantity;
            }
        });

        // Product Detail Page Image Switching
        function changeMainImage(thumbnail) {
            document.getElementById('mainProductImage').src = thumbnail.src;
            document.querySelectorAll('.thumbnail-image').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
    </script>
</body>
</html>