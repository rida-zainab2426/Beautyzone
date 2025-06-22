-- Full SQL Script for Beautyzone Database Setup and Sample Data
-- This script will drop existing tables (if they exist) and then recreate them
-- and insert all necessary sample data.
-- Run this entire script in your phpMyAdmin's SQL tab.

-- Select the database

-- 1. Drop tables in reverse order of dependency (due to foreign keys)
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS site_members;

-- 2. Create 'site_members' table (as per your exact request, with additions)
CREATE TABLE site_members (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL, -- Stores bcrypt hash of the password
    is_admin BOOLEAN DEFAULT FALSE,       -- TRUE for admin users, FALSE for regular members
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP, -- Added for dashboard/users.php
    last_login DATETIME NULL,             -- Added for dashboard/users.php
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Create 'categories' table
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Create 'products' table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT, -- Foreign key linking to the categories table
    image_url VARCHAR(255) NULL, -- Path to the main product image (e.g., 'uploads/products/image.jpg')
    stock_quantity INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

-- 5. Create 'orders' table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL, -- Foreign key linking to the site_members table
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL,
    shipping_address TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending', -- e.g., 'Pending', 'Processing', 'Completed', 'Cancelled'
    FOREIGN KEY (member_id) REFERENCES site_members(member_id) ON DELETE CASCADE
);

-- 6. Create 'order_items' table
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,     -- Foreign key linking to the orders table
    product_id INT NOT NULL,   -- Foreign key linking to the products table
    quantity INT NOT NULL,
    price_at_order DECIMAL(10, 2) NOT NULL, -- Price of the product at the time of order
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);


--
-- Sample Data Insertion
-- (Passwords are dummy bcrypt hashes for 'password123')

-- Insert sample site_members (including the 10 clients + admin)
INSERT INTO site_members (username, email, password_hash, is_admin, registration_date, last_login) VALUES
('admin', 'admin@beautyzone.com', '$2y$10$o.cT9eK8wZ6X.V9Y0b.qI.y.E0x9Yq/J5O/jX2K/jZ6D7G8H9O0v', TRUE, '2023-01-01 10:00:00', '2024-06-22 15:30:00'),
('Alice Wonderland', 'alice@example.com', '$2y$10$f.kL4mN7xP0Y2Z.W8b.rJ.k.Q1a2V3X/wY7A8B9C0D1E2F3G4H5', FALSE, '2023-01-05 10:00:00', '2024-06-20 14:30:00'),
('Bob The Builder', 'bob@example.com', '$2y$10$g.hI5jK9xV1Z3A.Y7c.sL.m.R3b4W5X/zT8U9V0W1X2Y3Z4A5B6C7', FALSE, '2023-02-10 11:30:00', '2024-06-21 09:15:00'),
('Charlie Chaplin', 'charlie@example.com', '$2y$10$h.jK6lM0yW2X4B.Z8d.tN.o.S4c5X6Y/aU9V0W1X2Y3Z4A5B6C7D', FALSE, '2023-03-15 14:00:00', '2024-06-22 10:45:00'),
('Diana Prince', 'diana@example.com', '$2y$10$i.lM7nO1zX3Y5C.A9e.uP.p.T5d6Y7Z/bV0W1X2Y3Z4A5B6C7D8E', FALSE, '2023-04-20 09:00:00', '2024-06-22 17:00:00'),
('Ethan Hunt', 'ethan@example.com', '$2y$10$j.nM8oP2aY4Z6D.B0f.vQ.q.U6e7Z8A/cV1W2X3Y4Z5A6B7C8D9F', FALSE, '2023-05-25 16:00:00', '2024-06-21 20:00:00'),
('Fiona O\'Connell', 'fiona@example.com', '$2y$10$k.oP9qQ3bZ5A7E.C1g.wR.r.V7f8Z9B/dX2Y3Z4A5B6C7D8E9G', FALSE, '2023-06-30 08:00:00', '2024-06-22 13:00:00'),
('George Clooney', 'george@example.com', '$2y$10$l.pQ0rR4cX6B8F.D2h.xS.s.W8g9A0C/eY3Z4A5B6C7D8E9G0H', FALSE, '2023-07-01 11:00:00', '2024-06-23 09:00:00'),
('Hannah Montana', 'hannah@example.com', '$2y$10$m.qR1sS5dY7C9G.E3i.yT.t.X9h0D1F/fX4Y5Z6A7B8C9D0E1I', FALSE, '2023-08-05 13:00:00', '2024-06-23 11:00:00'),
('Ivy Queen', 'ivy@example.com', '$2y$10$n.sS2tT6eZ8D0H.F4j.zU.u.Y0i1E2G/gY5Z6A7B8C9D0E1I2J', FALSE, '2023-09-10 15:00:00', '2024-06-23 10:00:00'),
('Jack Sparrow', 'jack@example.com', '$2y$10$o.uT3vU7fA9E1I.G5k.A1V.v.Z1j2F3H/hZ6A7B8C9D0E1I2J3K', FALSE, '2023-10-15 17:00:00', '2024-06-23 12:00:00');


-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Lipsticks', 'A wide range of lipsticks in various shades and finishes.'),
('Foundations', 'Perfect foundations for every skin tone and type.'),
('Eye Shadows', 'Vibrant and subtle eyeshadows for every look.'),
('Blushes', 'Blushes to add a natural flush to your cheeks.'),
('Skincare', 'Essential skincare products for a healthy glow.'),
('Necklaces', 'Elegant necklaces for every occasion.'),
('Earrings', 'Stylish earrings to complement your style.'),
('Rings', 'Beautiful rings for everyday wear or special moments.'),
('Bracelets', 'Fashionable bracelets to adorn your wrist.'),
('Anklets', 'Delicate and charming anklets for subtle elegance.');


-- Insert sample products
-- Note: 'imgs/' is a placeholder. In a real application, you would manage these file paths.
INSERT INTO products (name, description, price, category_id, image_url, stock_quantity) VALUES
('Delicate Chain Anklet', 'Adorn your ankle with our exquisite Delicate Chain Anklet, designed for subtle elegance. This lightweight piece features a finely crafted chain, perfect for adding a touch of sparkle to any outfit, from casual wear to beach attire.', 35.00, (SELECT category_id FROM categories WHERE name = 'Anklets'), 'imgs/delicate chain ankle.webp', 65),
('Bohemian Beaded Anklet', 'Embrace your free spirit with our Bohemian Beaded Anklet. Handcrafted with vibrant glass beads and delicate charms, this anklet captures the essence of bohemian chic. Perfect for beach days, music festivals, or adding a pop of color to your everyday look.', 28.00, (SELECT category_id FROM categories WHERE name = 'Anklets'), 'imgs/beaded ankle.webp', 50),
('Silver Charm Anklet', 'Our Silver Charm Anklet is a timeless piece, featuring a delicate sterling silver chain adorned with an assortment of charming mini pendants. Each charm tells a subtle story, making this anklet a personal and elegant accessory. Perfect for daily wear or as a thoughtful gift.', 45.00, (SELECT category_id FROM categories WHERE name = 'Anklets'), 'imgs/Silver charm ankle.webp', 70),
('Gold Layered Anklet', 'Make a statement with our Gold Layered Anklet, featuring multiple delicate chains of varying lengths, adorned with tiny hammered discs and shimmering beads. This elegant piece adds a touch of bohemian luxury to any outfit, perfect for both casual and dressy occasions.', 35.00, (SELECT category_id FROM categories WHERE name = 'Anklets'), 'imgs/Golden Layered ankle.webp', 65),
('Sparkling Crystal Anklet', 'Shine bright with our Sparkling Crystal Anklet, featuring a delicate chain adorned with individually set, brilliant-cut crystals that catch the light with every movement. This elegant anklet is perfect for adding a touch of glamour to your evening wear or a subtle sparkle to your everyday look.', 42.00, (SELECT category_id FROM categories WHERE name = 'Anklets'), 'imgs/Sparkling Crystal ankle.webp', 50),
('Natural Seashell Anklet', 'Embrace the essence of the ocean with our Natural Seashell Anklet. Crafted with genuine small seashells strung on a durable, adjustable cord, this anklet brings a touch of beach-inspired charm to your look. Perfect for summer days, beach outings, or simply to carry a piece of the seaside with you wherever you go.', 28.00, (SELECT category_id FROM categories WHERE name = 'Anklets'), 'imgs/Natural seashell.webp', 60),
('Ruby Red Lipstick', 'A bold and beautiful ruby red lipstick for a stunning look.', 18.50, (SELECT category_id FROM categories WHERE name = 'Lipsticks'), 'imgs/ruby_lipstick.webp', 120),
('Matte Foundation Ivory', 'Long-lasting matte foundation in an ivory shade, perfect for a flawless finish.', 25.00, (SELECT category_id FROM categories WHERE name = 'Foundations'), 'imgs/matte_foundation.webp', 80),
('Smoky Eye Palette', 'A versatile eyeshadow palette with rich, blendable shades for captivating smoky eye looks.', 30.00, (SELECT category_id FROM categories WHERE name = 'Eye Shadows'), 'imgs/smoky_eye_palette.webp', 90),
('Peach Glow Blush', 'A soft peach blush for a natural, radiant glow, enhancing your complexion.', 15.00, (SELECT category_id FROM categories WHERE name = 'Blushes'), 'imgs/peach_blush.webp', 110),
('Hydrating Face Serum', 'Deeply hydrating serum for a supple and smooth skin, visibly reducing fine lines.', 38.00, (SELECT category_id FROM categories WHERE name = 'Skincare'), 'imgs/face_serum.webp', 75),
('Diamond Pendant Necklace', 'An elegant necklace with a sparkling diamond pendant, a timeless piece for special occasions.', 150.00, (SELECT category_id FROM categories WHERE name = 'Necklaces'), 'imgs/diamond_necklace.webp', 30),
('Hoop Earrings Gold', 'Classic gold hoop earrings for everyday style, lightweight and comfortable.', 22.00, (SELECT category_id FROM categories WHERE name = 'Earrings'), 'imgs/hoop_earrings.webp', 100),
('Sterling Silver Ring', 'A simple yet elegant sterling silver ring, perfect for daily wear or stacking.', 55.00, (SELECT category_id FROM categories WHERE name = 'Rings'), 'imgs/silver_ring.webp', 45),
('Charm Bracelet Silver', 'A charming silver bracelet with various delicate charms, adding a personalized touch to your wrist.', 40.00, (SELECT category_id FROM categories WHERE name = 'Bracelets'), 'imgs/charm_bracelet.webp', 80);


-- Insert sample orders (linked to clients)
INSERT INTO orders (member_id, order_date, total_amount, shipping_address, status) VALUES
((SELECT member_id FROM site_members WHERE username = 'Alice Wonderland'), '2024-06-15 09:00:00', 80.00, '301 Pine St, Wonderland, Country', 'Completed'),
((SELECT member_id FROM site_members WHERE username = 'Bob The Builder'), '2024-06-16 11:30:00', 75.00, '404 Construction Ln, Bobsville, Country', 'Processing'),
((SELECT member_id FROM site_members WHERE username = 'Charlie Chaplin'), '2024-06-17 10:00:00', 50.00, '505 Silent Film Rd, Hollywood, Country', 'Completed'),
((SELECT member_id FROM site_members WHERE username = 'Diana Prince'), '2024-06-18 13:45:00', 120.00, '606 Themyscira Blvd, Paradise Island, Country', 'Pending'),
((SELECT member_id FROM site_members WHERE username = 'Ethan Hunt'), '2024-06-19 08:20:00', 95.00, '707 Mission Ave, Impossible City, Country', 'Processing'),
((SELECT member_id FROM site_members WHERE username = 'Fiona O\'Connell'), '2024-06-20 17:00:00', 40.00, '808 Swamp Lane, Far Far Away, Country', 'Completed'),
((SELECT member_id FROM site_members WHERE username = 'George Clooney'), '2024-06-21 12:00:00', 60.00, '909 Ocean\'s Eleven, Las Vegas, Country', 'Processing'),
((SELECT member_id FROM site_members WHERE username = 'Hannah Montana'), '2024-06-22 09:30:00', 35.00, '101 Pop Star Rd, Malibu, Country', 'Pending'),
((SELECT member_id FROM site_members WHERE username = 'Ivy Queen'), '2024-06-23 14:00:00', 70.00, '112 Reggaeton St, San Juan, Country', 'Processing'),
((SELECT member_id FROM site_members WHERE username = 'Jack Sparrow'), '2024-06-24 11:00:00', 50.00, '133 Tortuga Bay, Caribbean, Country', 'Pending');


-- Insert sample order_items (linked to the orders and products created above)
-- Ensure order_id and product_id correspond to actual IDs after insertion.
-- The subqueries for order_id use the latest order for that member, which works for sequential inserts.
INSERT INTO order_items (order_id, product_id, quantity, price_at_order) VALUES
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Alice Wonderland') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Sparkling Crystal Anklet'), 1, 42.00),
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Alice Wonderland') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Hoop Earrings Gold'), 1, 38.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Bob The Builder') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Ruby Red Lipstick'), 2, 18.50),
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Bob The Builder') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Hydrating Face Serum'), 1, 38.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Charlie Chaplin') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Gold Layered Anklet'), 1, 35.00),
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Charlie Chaplin') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Peach Glow Blush'), 1, 15.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Diana Prince') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Diamond Pendant Necklace'), 1, 120.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Ethan Hunt') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Smoky Eye Palette'), 2, 30.00),
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Ethan Hunt') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Matte Foundation Ivory'), 1, 35.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Fiona O\'Connell') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Charm Bracelet Silver'), 1, 40.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'George Clooney') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Sterling Silver Ring'), 1, 55.00),
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'George Clooney') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Peach Glow Blush'), 1, 5.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Hannah Montana') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Delicate Chain Anklet'), 1, 35.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Ivy Queen') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Natural Seashell Anklet'), 2, 28.00),
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Ivy Queen') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Ruby Red Lipstick'), 1, 14.00),

((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Jack Sparrow') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Bohemian Beaded Anklet'), 1, 28.00),
((SELECT order_id FROM orders WHERE member_id = (SELECT member_id FROM site_members WHERE username = 'Jack Sparrow') ORDER BY order_date DESC LIMIT 1), (SELECT product_id FROM products WHERE name = 'Hoop Earrings Gold'), 1, 22.00);
