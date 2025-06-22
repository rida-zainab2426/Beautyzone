<?php
// Start the session at the very beginning of the file
session_start();

// Define product details for Velvet Matte Lipstick
// In a real application, this data would come from a database based on a product ID from the URL
$product = [
    'id' => 'VML001', // Unique Product ID for Velvet Matte Lipstick
    'name' => 'Velvet Matte Lipstick',
    'price' => 15.00,
    // IMPORTANT: Ensure these paths are correct relative to where your shopping_cart.php and product_detail files are.
    // Assuming 'imgs/' is in the same directory as this PHP file.
    'image' => 'imgs/Velvet Matte Lipstick.webp',
    'hover_image' => 'imgs/Velvet Matte Lipstick2.webp', // If you have a hover image
    'description' => 'Indulge in the luxurious feel of our Velvet Matte Lipstick. This creamy, richly pigmented formula glides on effortlessly, providing a soft-focus, velvety matte finish that feels incredibly comfortable on the lips. Designed for long wear, it resists fading and smudging, ensuring your vibrant color stays impeccable throughout the day. Enriched with emollients, it keeps your lips hydrated and smooth, defying the typical dryness associated with matte lipsticks.',
    'stock' => 35, // Example stock
    'reviews' => 4, // Example reviews
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

// Handle adding to cart
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

// Calculate total items in cart for the badge (copied from index.php/shopping_cart.php)
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
    <title>Document</title>
</head>
<body>
<div class="product-detail-container">
        <div class="product-images">
            <div class="main-image-wrapper">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="main-product-image" id="mainProductImage">
                <?php if (isset($product['hover_image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['hover_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Hover" class="product-hover-image">
                <?php endif; ?>
            </div>
            <div class="thumbnail-gallery">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Thumbnail 1" class="thumbnail-image active" onclick="changeMainImage(this)">
                <?php if (isset($product['hover_image'])): ?>
                    <img src="<?php echo htmlspecialchars($product['hover_image']); ?>" alt="Thumbnail 2" class="thumbnail-image" onclick="changeMainImage(this)">
                <?php endif; ?>
                </div>
        </div>
        <div class="product-details">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
            <div class="product-meta">
                <span><i class="fas fa-star"></i> <?php echo htmlspecialchars($product['reviews']); ?> Reviews</span>
                <span>In Stock: <span id="itemsInStock"><?php echo htmlspecialchars($product['stock']); ?></span></span>
            </div>

            <form action="velvet_matte_lipstick_detail.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">
                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">

                <div class="quantity-selector">
                    <label for="quantity">Quantity:</label>
                    <div class="quantity-input-group">
                        <button type="button" class="quantity-button" id="subtract-quantity">-</button>
                        <input type="text" name="quantity" id="quantity" class="quantity-input" value="1" min="1" readonly>
                        <button type="button" class="quantity-button" id="add-quantity">+</button>
                    </div>
                </div>
                <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
            </form>
        </div>
    </div>
</body>
</html>