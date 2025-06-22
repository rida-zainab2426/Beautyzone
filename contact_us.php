<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautyzone - Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        /* General Body Styling */
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FDF9F8; /* Very light, warm off-white */
            color: #333; /* Dark grey */
        }

        /* Unique Font for Headings */
        h1, h2, h3, .section-title, .category-name {
            font-family: 'Playfair Display', serif;
        }

        /* Color Variables (Moved to :root for global access) */
        :root {
            --accent-pink: #E7746F; /* Main pink for titles, buttons, etc. */
            --light-accent: #F8D7C7; /* Lighter accent for subtle elements */
            --text-dark: #333; /* Dark text color */
            /* Add footer specific vars for consistency */
            --footer-bg-color: #F8D7C7; /* Lighter pink for footer */
            --footer-text-color: #333; /* Darker text for lighter footer */
            --footer-link-hover-color: #E7746F; /* Accent pink for link hover */
            --social-icon-bg: rgba(0, 0, 0, 0.05); /* Slightly transparent white for social icons */
            --social-icon-hover-bg: var(--accent-pink); /* Accent pink on hover */
            --social-icon-hover-color: #FFFFFF; /* White on hover */
        }

        /* Header Styling */
        header {
            background: linear-gradient(to right, #FFE4E1, #FFB6C1);
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
            font-family: 'Playfair Display', serif;
            font-size: 2.2em;
            font-weight: 700;
            color: var(--text-dark);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            transition: color 0.3s ease-in-out;
        }
        .logo span:hover {
            color: var(--accent-pink);
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
            color: #000;
            font-weight: 600;
            padding: 10px 0;
            display: block;
            transition: color 0.3s ease-in-out;
        }

        .main-nav li a:hover {
            color: var(--accent-pink);
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #FFFFFF;
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
            color: #444;
            white-space: nowrap;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }

        .dropdown-menu li a:hover {
            background-color: #F0F0F0;
            color: var(--accent-pink);
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
            color: #000;
            margin-left: 30px;
            transition: color 0.3s ease-in-out;
        }

        .search-icon:hover {
            color: var(--accent-pink);
        }

        .search-bar {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: var(--light-accent);
            padding: 15px 30px;
            box-shadow: 0 44px 8px rgba(0, 0, 0, 0.08);
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
            background-color: var(--accent-pink);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease-in-out;
        }

        .search-bar button:hover {
            background-color: #D25F5C;
        }

        .user-actions {
            display: flex;
            align-items: center;
            margin-left: 30px;
        }

        .user-actions a {
            color: #000;
            font-size: 1.4em;
            margin-left: 20px;
            position: relative;
            transition: color 0.3s ease-in-out;
        }

        .user-actions a:hover {
            color: var(--accent-pink);
        }

        .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #E44D26;
            color: white;
            border-radius: 50%;
            padding: 4px 7px;
            font-size: 0.7em;
            min-width: 10px;
            text-align: center;
            line-height: 1;
        }

        /* Contact Hero Section - Similar to About Us Hero */
        .contact-hero {
            background-image: url('imgs/contact-hero.webp'); /* Placeholder image */
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
            position: relative;
        }
        .contact-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 182, 193, 0.4); /* Pink overlay */
            z-index: 1;
        }
        .contact-hero .hero-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            text-align: center;
        }
        .contact-hero h1 {
            font-size: 3.8em;
            margin-bottom: 15px;
            font-weight: 700;
            color: var(--text-dark); /* Black/dark as requested */
            text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.6); /* White shadow for contrast */
        }
        .contact-hero .breadcrumbs {
            font-size: 1.2em;
            color: #333; /* Dark grey/black as requested */
            margin-top: 0;
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.6); /* Adjusted shadow for dark text */
        }
        .contact-hero .breadcrumbs a {
            color: #333; /* Dark grey/black as requested */
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .contact-hero .breadcrumbs a:hover {
            color: var(--accent-pink);
        }

        /* Main Contact Content Wrapper */
        .contact-content-wrapper {
            padding: 60px 20px;
            max-width: 1200px;
            margin: -50px auto 50px auto; /* Pulls up slightly into the hero */
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-radius: 10px;
            position: relative;
            z-index: 5;
            display: flex;
            flex-direction: column; /* Default to column stacking */
            gap: 40px; /* Space between major sections */
        }

        /* Contact Details & Map Container */
        .contact-info-map-container {
            display: flex;
            flex-wrap: wrap; /* Allows columns to wrap on smaller screens */
            gap: 40px;
            justify-content: center;
        }

        .contact-details-card,
        .contact-map {
            background-color: #fcfcfc; /* Slightly different background */
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
            flex: 1; /* Allows flexible sizing */
            min-width: 300px; /* Minimum width before wrapping */
            max-width: 48%; /* Max width for two columns */
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Space content evenly */
        }

        .contact-details-card h2,
        .contact-map h2,
        .contact-form-card h2,
        .why-choose-us h2 {
            font-size: 2.5em;
            color: var(--accent-pink);
            margin-bottom: 30px;
            font-weight: 700;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 1.1em;
            color: #555;
            text-align: left;
        }
        .detail-item i {
            color: var(--accent-pink);
            font-size: 1.5em;
            width: 30px; /* Fixed width for icon */
            text-align: center;
        }
        .detail-item p {
            margin: 0;
            line-height: 1.5;
        }

        .contact-details-card h3 {
            font-size: 1.8em;
            color: var(--text-dark);
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .social-icons-contact-page {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: auto; /* Push to bottom */
            padding-top: 20px;
        }
        .social-icons-contact-page a {
            color: var(--text-dark);
            font-size: 1.6em;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #F0F0F0;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
            text-decoration: none;
        }
        .social-icons-contact-page a:hover {
            background-color: var(--accent-pink);
            color: #fff;
        }

        .contact-map iframe {
            width: 100%;
            border-radius: 10px;
            filter: grayscale(10%); /* Subtle effect */
        }

        /* Contact Form Section (now a card inside wrapper) */
        .contact-form-card {
            background-color: #fcfcfc;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
            text-align: center;
            max-width: 700px; /* Limit form width */
            margin: 0 auto; /* Center it within the wrapper */
        }
        .contact-form-card form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .contact-form-card .form-group {
            text-align: left;
            margin-bottom: 5px;
        }
        .contact-form-card label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 1.05em;
        }
        .contact-form-card input[type="text"],
        .contact-form-card input[type="email"],
        .contact-form-card textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            font-family: 'Montserrat', sans-serif;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        .contact-form-card input[type="text"]:focus,
        .contact-form-card input[type="email"]:focus,
        .contact-form-card textarea:focus {
            border-color: var(--accent-pink);
            outline: none;
            box-shadow: 0 0 0 3px rgba(231, 116, 111, 0.2);
        }
        .contact-form-card textarea {
            resize: vertical;
            min-height: 120px;
        }
        .contact-form-card button[type="submit"] {
            background-color: var(--accent-pink);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
        }
        .contact-form-card button[type="submit"]:hover {
            background-color: #D25F5C;
            transform: translateY(-2px);
        }

        /* Error Message Styling */
        .error-message {
            color: #E44D26; /* Red color for errors */
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
            text-align: left;
        }

        /* Success Message Styling */
        .success-message {
            background-color: #d4edda; /* Light green */
            color: #155724; /* Dark green text */
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: center;
            font-weight: 500;
            display: none; /* Hidden by default */
        }

        /* Why Choose Us Section */
        .why-choose-us {
            padding: 60px 20px;
            max-width: 1000px;
            margin: 50px auto;
            background-color: var(--light-accent);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: center;
        }
        .why-choose-us h2 {
            margin-bottom: 30px;
        }
        .why-choose-us p {
            font-size: 1.1em;
            line-height: 1.8;
            color: #555;
            max-width: 800px;
            margin: 0 auto;
        }
        .why-choose-us ul {
            list-style: none;
            padding: 0;
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .why-choose-us ul li {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.2s ease;
        }
        .why-choose-us ul li:hover {
            transform: translateY(-5px);
        }
        .why-choose-us ul li i {
            color: var(--accent-pink);
            font-size: 1.2em;
        }


        /* Footer Styling (Copied from about_us.php) */
        .site-footer {
            background-color: var(--footer-bg-color);
            color: var(--footer-text-color);
            padding: 40px 20px;
            font-family: 'Montserrat', sans-serif;
            margin-top: 50px;
            text-align: center;
        }

        .footer-container {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }

        .footer-column {
            flex: 1;
            min-width: 180px;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .footer-column.about-contact {
            text-align: center;
        }


        .footer-column h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5em;
            margin-bottom: 20px;
            font-weight: 700;
            color: var(--footer-text-color);
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: var(--footer-text-color);
            text-decoration: none;
            font-size: 0.95em;
            transition: color 0.3s ease-in-out;
        }

        .footer-column ul li a:hover {
            color: var(--footer-link-hover-color);
            text-decoration: underline;
        }

        /* Basic Social Icons in the footer */
        .social-icons-footer {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons-footer a {
            color: var(--footer-text-color);
            font-size: 1.2em;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: var(--social-icon-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
            text-decoration: none;
        }

        .social-icons-footer a:hover {
            background-color: var(--social-icon-hover-bg);
            color: var(--social-icon-hover-color);
        }

        .footer-bottom {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 20px;
            margin-top: 30px;
            font-size: 0.85em;
            color: rgba(51, 51, 51, 0.7);
            text-align: center;
        }


        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-nav li { margin-left: 20px; }
            .user-actions { margin-left: 20px; }
            .user-actions a { margin-left: 15px; }

            .contact-hero { height: 300px; }
            .contact-hero h1 { font-size: 3.2em; }
            .contact-hero .breadcrumbs { font-size: 1.1em; }

            .contact-content-wrapper { padding: 40px 15px; }
            .contact-details-card,
            .contact-map { max-width: 100%; } /* Stack on smaller screens */

            .contact-details-card h2,
            .contact-map h2,
            .contact-form-card h2,
            .why-choose-us h2 {
                font-size: 2.2em;
                margin-bottom: 25px;
            }
            .detail-item { font-size: 1em; }
            .detail-item i { font-size: 1.4em; }

            .contact-form-card { padding: 30px; }
            .why-choose-us { padding: 40px 15px; }
            .why-choose-us p { font-size: 1em; }
            .why-choose-us ul li { padding: 15px 25px; font-size: 0.95em; }
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
            .dropdown-menu li a { padding-left: 40px; color: #444; }
            .dropdown-menu li a:hover { background-color: #F0F0F0; }
            .search-icon, .user-actions { margin: 10px 15px; flex-basis: 100%; justify-content: center; }
            .search-icon { order: 1; }
            .user-actions { order: 2; }
            .user-actions a { margin: 0 10px; }
            .search-bar.open { top: auto; bottom: 0; transform: translateY(0); opacity: 1; visibility: visible; }

            .contact-hero { height: 200px; }
            .contact-hero h1 { font-size: 2.5em; }
            .contact-hero .breadcrumbs { font-size: 0.95em; }

            .contact-content-wrapper { padding: 30px 15px; margin: -30px auto 30px auto; }
            .contact-info-map-container { flex-direction: column; gap: 30px; }
            .contact-details-card,
            .contact-map { min-width: unset; width: 100%; max-width: 100%; }
            .contact-map iframe { height: 300px; }
            .contact-details-card h2,
            .contact-map h2,
            .contact-form-card h2,
            .why-choose-us h2 {
                font-size: 2em;
                margin-bottom: 20px;
            }
            .social-icons-contact-page a { font-size: 1.4em; width: 45px; height: 45px; }

            .contact-form-card { padding: 25px; }
            .contact-form-card input,
            .contact-form-card textarea { padding: 12px; font-size: 0.95em; }
            .contact-form-card button[type="submit"] { padding: 12px 25px; font-size: 1em; }

            .why-choose-us { padding: 30px 10px; }
            .why-choose-us p { font-size: 0.95em; }
            .why-choose-us ul li { padding: 12px 20px; font-size: 0.9em; }
        }

        @media (max-width: 480px) {
            header { padding: 8px 10px; min-height: 50px; }
            .logo span { font-size: 1.8em; }
            .main-nav li a { padding: 10px 15px; font-size: 0.85em; }
            .user-actions a { font-size: 1.1em; margin-left: 8px; }
            .search-bar input { padding: 8px 12px; }
            .search-bar button { padding: 8px 12px; }

            .contact-hero { height: 180px; }
            .contact-hero h1 { font-size: 2em; }
            .contact-hero .breadcrumbs { font-size: 0.85em; }

            .contact-content-wrapper { padding: 20px 10px; margin: -20px auto 20px auto; }
            .contact-details-card,
            .contact-map { padding: 25px; }
            .contact-details-card h2,
            .contact-map h2,
            .contact-form-card h2,
            .why-choose-us h2 {
                font-size: 1.8em;
                margin-bottom: 15px;
            }
            .detail-item { font-size: 0.95em; margin-bottom: 15px; }
            .detail-item i { font-size: 1.2em; }
            .contact-map iframe { height: 250px; }
            .social-icons-contact-page a { font-size: 1.2em; width: 40px; height: 40px; }

            .contact-form-card { padding: 20px; }
            .contact-form-card input,
            .contact-form-card textarea { padding: 10px; }
            .contact-form-card button[type="submit"] { padding: 10px 20px; font-size: 0.95em; }

            .why-choose-us { padding: 25px 10px; }
            .why-choose-us p { font-size: 0.9em; }
            .why-choose-us ul { gap: 10px; }
            .why-choose-us ul li { padding: 10px 15px; font-size: 0.85em; }
        }
    </style>
</head>
<body>

    <?php
    // Define categories with their corresponding file names (These are used in header and footer)
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
    ?>

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
                <a href="shopping_cart.php"><i class="fas fa-shopping-bag"></i> <span class="badge">0</span></a>
            </div>
        </nav>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Search for products, categories...">
            <button type="submit" id="search-button"><i class="fas fa-search"></i></button>
        </div>
    </header>

    <section class="contact-hero">
        <div class="hero-content">
            <h1>Contact Us</h1>
            <p class="breadcrumbs"><a href="index.php">Home</a> / Contact Us</p>
        </div>
    </section>

    <div class="contact-content-wrapper">
        <section class="contact-form-card" data-aos="fade-up">
            <h2>Send Us a Message</h2>
            <p style="margin-bottom: 30px; color: #666;">Have a question or need assistance? Please fill out the form below, and our team will get back to you promptly.</p>
            <form id="contactForm">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name">
                    <span class="error-message" id="nameError"></span>
                </div>

                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address">
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Subject of your message">
                    <span class="error-message" id="subjectError"></span>
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="6" placeholder="Type your message here..."></textarea>
                    <span class="error-message" id="messageError"></span>
                </div>

                <button type="submit">Send Message</button>
                <div class="success-message" id="successMessage">
                    Thank you for your message! We will get back to you shortly.
                </div>
            </form>
        </section>

        <section class="contact-info-map-container">
            <div class="contact-details-card" data-aos="fade-right">
                <h2>Our Contact Details</h2>
                <div class="detail-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>123 Beauty Blvd, Glamour City, PK 75000</p>
                </div>
                <div class="detail-item">
                    <i class="fas fa-phone-alt"></i>
                    <p>+92 3XX XXXXXXX</p>
                </div>
                <div class="detail-item">
                    <i class="fas fa-envelope"></i>
                    <p>info@beautyzone.com</p>
                </div>
                <div class="detail-item">
                    <i class="fas fa-clock"></i>
                    <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
                </div>
                <h3>Connect With Us</h3>
                <div class="social-icons-contact-page">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="contact-map" data-aos="fade-left">
                <h2>Find Us Here</h2>
                <iframe src="https://maps.google.com/maps?q=Metro+Star+Gate+Aptech&output=embed" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
    </div>

    <section class="why-choose-us" data-aos="fade-up">
        <h2>Why Contact Beautyzone?</h2>
        <p>At Beautyzone, your satisfaction is our priority. We are committed to providing exceptional customer service and support. When you reach out to us, you can expect:</p>
        <ul>
            <li><i class="fas fa-check-circle"></i> Prompt Responses</li>
            <li><i class="fas fa-check-circle"></i> Expert Assistance</li>
            <li><i class="fas fa-check-circle"></i> Friendly Support</li>
            <li><i class="fas fa-check-circle"></i> Problem Resolution</li>
            <li><i class="fas fa-check-circle"></i> Product Information</li>
        </ul>
        <p style="margin-top: 30px;">Your feedback helps us grow and improve. Don't hesitate to connect!</p>
    </section>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-column about-contact">
                <h3>About & Contact</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about_us.php">About Us</a></li>
                    <li><a href="contact_us.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-column navigation-links">
                <h3>Cosmetics</h3>
                <ul>
                    <?php
                    foreach ($cosmeticCategories as $name => $file) {
                        echo '<li><a href="' . htmlspecialchars($file) . '">' . htmlspecialchars($name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="footer-column navigation-links">
                <h3>Jewellery</h3>
                <ul>
                    <?php
                    foreach ($jewelleryCategories as $name => $file) {
                        echo '<li><a href="' . htmlspecialchars($file) . '">' . htmlspecialchars($name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="footer-column social-media">
                <h3>Follow Us</h3>
                <div class="social-icons-footer">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            </div>
    </footer>


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            mirror: false,
            duration: 1000,
            easing: 'ease-out-cubic',
        });

        // JavaScript for Navbar Search and User Actions
        const searchIcon = document.querySelector('.search-icon');
        const searchBar = document.querySelector('.search-bar');
        const header = document.querySelector('header');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');

        // Toggle search bar visibility
        searchIcon.addEventListener('click', (event) => {
            event.stopPropagation();
            searchBar.classList.toggle('open');
            if (searchBar.classList.contains('open')) {
                searchInput.focus();
            }
        });

        // Close search bar when clicking outside header or search bar itself
        document.addEventListener('click', (event) => {
            if (!header.contains(event.target) && !searchBar.contains(event.target)) {
                if (searchBar.classList.contains('open')) {
                    searchBar.classList.remove('open');
                }
            }
        });

        // Search functionality
        function performSearch() {
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = `search_results.php?q=${encodeURIComponent(query)}`;
            } else {
                alert('Please enter a search term.');
            }
        }

        searchButton.addEventListener('click', performSearch);

        searchInput.addEventListener('keypress', (event) => {
            if (event.key === 'Enter') {
                performSearch();
            }
        });

        // Contact Form Validation
        const contactForm = document.getElementById('contactForm');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const subjectInput = document.getElementById('subject');
        const messageInput = document.getElementById('message');

        const nameError = document.getElementById('nameError');
        const emailError = document.getElementById('emailError');
        const subjectError = document.getElementById('subjectError');
        const messageError = document.getElementById('messageError');
        const successMessage = document.getElementById('successMessage');

        // Function to display error
        function displayError(element, message) {
            element.textContent = message;
            element.style.display = 'block';
        }

        // Function to clear error
        function clearError(element) {
            element.textContent = '';
            element.style.display = 'none';
        }

        // Validation logic
        function validateForm() {
            let isValid = true;

            // Name validation
            if (nameInput.value.trim() === '') {
                displayError(nameError, 'Name is required.');
                isValid = false;
            } else if (nameInput.value.trim().length < 2) {
                displayError(nameError, 'Name must be at least 2 characters long.');
                isValid = false;
            } else {
                clearError(nameError);
            }

            // Email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === '') {
                displayError(emailError, 'Email is required.');
                isValid = false;
            } else if (!emailPattern.test(emailInput.value.trim())) {
                displayError(emailError, 'Please enter a valid email address.');
                isValid = false;
            } else {
                clearError(emailError);
            }

            // Subject validation
            if (subjectInput.value.trim() === '') {
                displayError(subjectError, 'Subject is required.');
                isValid = false;
            } else if (subjectInput.value.trim().length < 3) {
                displayError(subjectError, 'Subject must be at least 3 characters long.');
                isValid = false;
            } else {
                clearError(subjectError);
            }

            // Message validation
            if (messageInput.value.trim() === '') {
                displayError(messageError, 'Message is required.');
                isValid = false;
            } else if (messageInput.value.trim().length < 10) {
                displayError(messageError, 'Message must be at least 10 characters long.');
                isValid = false;
            } else {
                clearError(messageError);
            }

            return isValid;
        }

        // Add submit event listener to the form
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent actual form submission

            if (validateForm()) {
                // If validation passes, show success message and optionally reset form
                successMessage.style.display = 'block';
                contactForm.reset(); // Clear the form fields
                
                // Hide success message after a few seconds
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000); // 5 seconds
            } else {
                // If validation fails, ensure success message is hidden
                successMessage.style.display = 'none';
            }
        });

        // Real-time validation as user types (optional but good UX)
        nameInput.addEventListener('input', () => validateForm());
        emailInput.addEventListener('input', () => validateForm());
        subjectInput.addEventListener('input', () => validateForm());
        messageInput.addEventListener('input', () => validateForm());

    </script>

</body>
</html>