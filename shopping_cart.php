<?php
session_start();

// Define categories for navigation (copied from index.php)
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

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if (isset($_GET['action'])) {
    $productId = $_GET['product_id'] ?? '';
    $productName = $_GET['name'] ?? '';
    $productPrice = $_GET['price'] ?? 0;
    $productImage = $_GET['image'] ?? ''; // This is the image path passed from the product page
    $quantity = max(1, (int)($_GET['qty'] ?? 1)); // Ensure quantity is at least 1

    switch ($_GET['action']) {
        case 'add':
            if ($productId && $productName && $productPrice > 0) {
                if (isset($_SESSION['cart'][$productId])) {
                    // Item already in cart, update quantity
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    // Add new item to cart
                    $_SESSION['cart'][$productId] = [
                        'name' => $productName,
                        'price' => $productPrice,
                        'quantity' => $quantity,
                        'image' => $productImage // Store the image path received
                    ];
                }
            }
            break;

        case 'update':
            // Loop through potential quantity updates from the form
            foreach ($_GET as $key => $value) {
                if (strpos($key, 'qty_') === 0) {
                    $updatedProductId = substr($key, 4); // Extract product ID
                    $updatedQuantity = max(0, (int)$value); // Ensure quantity is not negative

                    if (isset($_SESSION['cart'][$updatedProductId])) {
                        if ($updatedQuantity === 0) {
                            unset($_SESSION['cart'][$updatedProductId]); // Remove if quantity is 0
                        } else {
                            $_SESSION['cart'][$updatedProductId]['quantity'] = $updatedQuantity;
                        }
                    }
                }
            }
            break;

        case 'remove':
            if ($productId && isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
            }
            break;

        case 'clear':
            $_SESSION['cart'] = []; // Clear all items
            break;
    }
    // Redirect to prevent re-submission on refresh and clean URL
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

$cartTotal = 0; // Initialize total for cart display
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Beautyzone</title>
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
            background-color: '#D25F5C'; /* Darker pink on hover */
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

        /* Shopping Cart Specific Styling */
        .cart-container {
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 200px); /* Adjust to push footer down */
        }

        .cart-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5em;
            color: var(--accent-pink);
            text-align: center;
            margin-bottom: 40px;
        }

        .cart-items {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }

        .cart-items th, .cart-items td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .cart-items th {
            background-color: var(--light-accent);
            color: var(--text-dark);
            font-weight: 600;
        }

        .cart-item-row {
            transition: background-color 0.2s ease-in-out;
        }

        .cart-item-row:hover {
            background-color: #f9f9f9;
        }

        .cart-item-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
            vertical-align: middle;
        }

        .cart-item-details {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .item-quantity input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
            font-size: 1em;
        }

        .item-action-btn {
            background-color: #dc3545; /* Red for remove */
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.3s ease;
        }
        .item-action-btn:hover {
            background-color: #c82333;
        }

        .cart-summary {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 20px;
            font-size: 1.2em;
            font-weight: 600;
            margin-top: 30px;
            border-top: 2px solid var(--light-accent);
            padding-top: 20px;
        }

        .cart-summary .total-price {
            color: var(--accent-pink);
            font-size: 1.5em;
        }

        .checkout-btn {
            background-color: var(--accent-pink);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none; /* Added for the anchor tag */
            display: inline-block; /* Added for the anchor tag to allow padding */
        }
        .checkout-btn:hover {
            background-color: '#D25F5C';
            transform: translateY(-2px);
        }

        .empty-cart-message {
            text-align: center;
            font-size: 1.3em;
            color: #777;
            padding: 50px 0;
        }

        .empty-cart-message a {
            color: var(--accent-pink);
            text-decoration: none;
            font-weight: 600;
        }
        .empty-cart-message a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-nav li { margin-left: 20px; }
            .user-actions { margin-left: 20px; }
            .user-actions a { margin-left: 15px; }

            .cart-container {
                margin: 20px auto;
                padding: 20px;
            }
            .cart-items th, .cart-items td {
                padding: 10px;
                font-size: 0.9em;
            }
            .cart-item-img {
                width: 60px;
                height: 60px;
                margin-right: 10px;
            }
            .item-quantity input {
                width: 50px;
                padding: 6px;
            }
            .item-action-btn {
                padding: 6px 10px;
                font-size: 0.8em;
            }
            .cart-summary {
                font-size: 1.1em;
                gap: 15px;
            }
            .cart-summary .total-price {
                font-size: 1.3em;
            }
            .checkout-btn {
                padding: 12px 25px;
                font-size: 1.1em;
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

            .cart-items {
                display: block; /* Make table behave like a block */
                border: none;
            }
            .cart-items thead {
                display: none; /* Hide header on small screens */
            }
            .cart-items tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #eee;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            .cart-items td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 15px;
                border-bottom: 1px solid #f0f0f0;
            }
            .cart-items td:last-child {
                border-bottom: none;
            }
            .cart-items td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 10px;
                color: #555;
            }
            .cart-item-details { flex-direction: column; align-items: flex-start; }
            .cart-item-img { margin-bottom: 10px; }
            .item-quantity input { width: 100px; }
            .cart-summary { flex-direction: column; justify-content: center; }
        }

        @media (max-width: 480px) {
            header { padding: 8px 10px; min-height: 50px; }
            .logo span { height: 40px; font-size: 1.8em;}
            .main-nav li a { padding: 12px 15px; font-size: 0.9em; }
            .user-actions a { font-size: 1.2em; margin-left: 10px; }
            .search-bar input { padding: 10px 15px; }
            .search-bar button { padding: 10px 15px; }

            .cart-title { font-size: 2em; margin-bottom: 30px; }
            .cart-items td { padding: 8px 10px; font-size: 0.85em; }
            .item-action-btn { padding: 5px 8px; font-size: 0.8em; }
            .checkout-btn { padding: 10px 20px; font-size: 1em; }
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

    <div class="cart-container">
        <h1 class="cart-title">Your Shopping Cart</h1>

        <?php if (empty($_SESSION['cart'])): ?>
            <p class="empty-cart-message">Your cart is empty. <a href="index.php">Continue shopping!</a></p>
        <?php else: ?>
            <form action="shopping_cart.php" method="get">
                <input type="hidden" name="action" value="update">
                <table class="cart-items">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <?php
                            $subtotal = $item['price'] * $item['quantity'];
                            $cartTotal += $subtotal;
                            ?>
                            <tr class="cart-item-row">
                                <td data-label="Product">
                                    <div class="cart-item-details">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-item-img">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </div>
                                </td>
                                <td data-label="Price">$<?php echo number_format($item['price'], 2); ?></td>
                                <td data-label="Quantity" class="item-quantity">
                                    <input type="number" name="qty_<?php echo htmlspecialchars($id); ?>" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="0" onchange="this.form.submit()">
                                </td>
                                <td data-label="Subtotal">$<?php echo number_format($subtotal, 2); ?></td>
                                <td data-label="Action">
                                    <a href="shopping_cart.php?action=remove&product_id=<?php echo htmlspecialchars($id); ?>" class="item-action-btn">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>

            <div class="cart-summary">
                <span>Total:</span>
                <span class="total-price">$<?php echo number_format($cartTotal, 2); ?></span>
                <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
            </div>
            <div style="text-align: right; margin-top: 15px;">
                <a href="shopping_cart.php?action=clear" class="item-action-btn">Clear Cart</a>
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