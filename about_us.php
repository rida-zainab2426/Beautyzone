<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautyzone - About Us</title>
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
            background: linear-gradient(to right, #FFE4E1, #FFB6C1); /* Original pink gradient */
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


        /* About Hero Section */
        .about-hero {
            background-image: url('imgs/about-us-hero.webp');
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
        /* Overlay for readability */
        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 182, 193, 0.4);
            z-index: 1;
        }
        .about-hero .hero-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            text-align: center;
        }
        .about-hero h1 {
            font-size: 3.8em;
            margin-bottom: 15px;
            font-weight: 700;
            color: var(--text-dark); /* Changed to black/dark for "About Us" heading */
            text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.6); /* Adjusted shadow for dark text */
        }
        .about-hero .breadcrumbs {
            font-size: 1.2em;
            color: #333; /* Dark grey/black as requested */
            margin-top: 0;
            text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.6); /* Adjusted shadow for dark text */
        }
        .about-hero .breadcrumbs a {
            color: #333; /* Dark grey/black as requested */
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .about-hero .breadcrumbs a:hover {
            color: var(--accent-pink);
        }


        /* About Content Section */
        .about-content-section {
            padding: 80px 20px;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-radius: 10px;
            transform: translateY(-50px);
            position: relative;
            z-index: 5;
        }
        .about-content-section h2 {
            font-size: 2.8em;
            color: var(--accent-pink);
            margin-bottom: 30px;
            font-weight: 700;
            text-align: center;
        }
        .about-content-section p {
            font-size: 1.1em;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
            text-align: justify;
            text-justify: inter-word;
        }
        .about-content-section p:last-of-type {
            margin-bottom: 0;
        }
        .about-content-section .signature {
            font-family: 'Playfair Display', serif;
            font-size: 1.8em;
            font-style: italic;
            color: var(--text-dark);
            margin-top: 20px;
            text-align: right;
            font-weight: 500;
        }

        /* Our Mission & Vision */
        .mission-vision-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 60px 20px;
            max-width: 1200px;
            margin: 20px auto 50px auto;
            background-color: var(--light-accent);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            flex-wrap: wrap;
        }
        .mission-vision-card {
            background-color: #FFFFFF;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
            flex: 1;
            min-width: 300px;
            max-width: 45%;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .mission-vision-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        .mission-vision-card h3 {
            font-size: 2.2em;
            color: var(--accent-pink);
            margin-bottom: 20px;
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }
        .mission-vision-card h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--light-accent);
            border-radius: 2px;
        }
        .mission-vision-card p {
            font-size: 1em;
            line-height: 1.7;
            color: #666;
            margin-bottom: 0;
        }

        /* New: Owner Spotlight Section */
        .owner-spotlight-section {
            padding: 60px 20px;
            max-width: 900px;
            margin: 50px auto; /* Centered with top/bottom margin */
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }
        .owner-spotlight-section h2 {
            font-size: 2.8em;
            color: var(--accent-pink); /* Pink heading */
            margin-bottom: 10px;
            font-weight: 700;
        }
        .owner-spotlight-section .owner-card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 600px; /* Limit content width */
        }
        .owner-spotlight-section img {
            width: 200px; /* Larger image */
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 25px;
            border: 6px solid var(--light-accent); /* Thicker, lighter pink border */
            box-shadow: 0 8px 15px rgba(0,0,0,0.1); /* Subtle shadow for image */
        }
        .owner-spotlight-section h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2em; /* Larger name */
            color: var(--text-dark);
            margin-bottom: 10px;
            font-weight: 700;
        }
        .owner-spotlight-section .owner-title {
            font-size: 1.2em; /* Larger title */
            color: var(--accent-pink);
            font-weight: 600;
            margin-bottom: 20px;
        }
        .owner-spotlight-section p {
            font-size: 1.05em; /* Slightly larger description text */
            line-height: 1.7;
            color: #555;
            margin-bottom: 20px;
            text-align: center; /* Center the description */
        }
        .owner-spotlight-section .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }
        .owner-spotlight-section .social-icons a {
            color: var(--text-dark);
            font-size: 1.4em; /* Larger social icons */
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #F0F0F0;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }
        .owner-spotlight-section .social-icons a:hover {
            background-color: var(--accent-pink);
            color: #fff;
        }


        /* Our Team Section */
        .our-team-section {
            padding: 80px 20px;
            background-color: #FDF9F8;
            text-align: center;
        }
        .our-team-section h2 {
            font-size: 2.8em;
            color: var(--text-dark);
            margin-bottom: 60px;
            font-weight: 700;
        }
        .team-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .team-member-card {
            background-color: #FFFFFF;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 30px;
            width: 280px;
            text-align: center;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .team-member-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }
        .team-member-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 4px solid var(--accent-pink);
        }
        .team-member-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8em;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-weight: 700;
        }
        .team-member-card p {
            font-size: 1em;
            color: #666;
            margin-bottom: 20px;
        }
        .team-member-card .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .team-member-card .social-icons a {
            color: var(--text-dark);
            font-size: 1.2em;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #F0F0F0;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
        }
        .team-member-card .social-icons a:hover {
            background-color: var(--accent-pink);
            color: #fff;
        }

        /* Footer Styling */
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

            .about-hero h1 { font-size: 3.2em; }
            .about-hero .breadcrumbs { font-size: 1.1em; }
            .about-content-section { padding: 60px 15px; }
            .about-content-section h2 { font-size: 2.2em; }
            .about-content-section p { font-size: 1em; }
            .mission-vision-card { max-width: 48%; }
            .mission-vision-card h3 { font-size: 2em; }
            
            /* Owner Spotlight Responsive */
            .owner-spotlight-section { padding: 50px 15px; }
            .owner-spotlight-section h2 { font-size: 2.2em; }
            .owner-spotlight-section img { width: 180px; height: 180px; }
            .owner-spotlight-section h3 { font-size: 2em; }
            .owner-spotlight-section .owner-title { font-size: 1.1em; }
            .owner-spotlight-section p { font-size: 1em; }
            .owner-spotlight-section .social-icons a { font-size: 1.3em; width: 40px; height: 40px; }


            .team-member-card { width: 250px; }

            /* Footer Responsive */
            .footer-container {
                flex-direction: column;
                gap: 20px;
            }
            .footer-column {
                min-width: unset;
                flex-basis: 100%;
                text-align: center;
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
            .dropdown-menu li a { padding-left: 40px; color: #444; }
            .dropdown-menu li a:hover { background-color: #F0F0F0; }
            .search-icon, .user-actions { margin: 10px 15px; flex-basis: 100%; justify-content: center; }
            .search-icon { order: 1; }
            .user-actions { order: 2; }
            .user-actions a { margin: 0 10px; }
            .search-bar.open { top: auto; bottom: 0; transform: translateY(0); opacity: 1; visibility: visible; }

            .about-hero { height: 300px; }
            .about-hero h1 { font-size: 2.8em; }
            .about-hero .breadcrumbs { font-size: 1em; }
            .about-content-section { padding: 40px 15px; transform: translateY(-30px); }
            .about-content-section h2 { font-size: 2em; }
            .about-content-section p { font-size: 0.95em; }
            .mission-vision-section {
                flex-direction: column;
                margin: 30px auto 30px auto;
                gap: 30px;
            }
            .mission-vision-card { max-width: 90%; margin: 0 auto; }
            .mission-vision-card h3 { font-size: 1.8em; }

            /* Owner Spotlight Responsive */
            .owner-spotlight-section { padding: 40px 10px; margin: 30px auto; }
            .owner-spotlight-section h2 { font-size: 2em; }
            .owner-spotlight-section img { width: 150px; height: 150px; }
            .owner-spotlight-section h3 { font-size: 1.8em; }
            .owner-spotlight-section .owner-title { font-size: 1.05em; }
            .owner-spotlight-section p { font-size: 0.95em; }
            .owner-spotlight-section .social-icons a { font-size: 1.2em; width: 40px; height: 40px; }

            .our-team-section h2 { font-size: 2.2em; margin-bottom: 40px; }
            .team-grid { gap: 30px; }
            .team-member-card { width: 220px; }
            .team-member-card h3 { font-size: 1.6em; }
        }

        @media (max-width: 480px) {
            header { padding: 8px 10px; min-height: 50px; }
            .logo span { font-size: 1.8em; }
            .main-nav li a { padding: 12px 15px; font-size: 0.9em; }
            .user-actions a { font-size: 1.2em; margin-left: 10px; }
            .search-bar input { padding: 10px 15px; }
            .search-bar button { padding: 10px 15px; }

            .about-hero { height: 250px; }
            .about-hero h1 { font-size: 1.8em; }
            .about-hero .breadcrumbs { font-size: 0.9em; }
            .about-content-section { padding: 30px 10px; transform: translateY(-20px); }
            .about-content-section h2 { font-size: 1.8em; }
            .about-content-section p { font-size: 0.9em; }
            .about-content-section .signature { font-size: 1.4em; }
            .mission-vision-section { padding: 40px 10px; }
            .mission-vision-card { min-width: unset; width: 100%; }
            .mission-vision-card h3 { font-size: 1.6em; }

            /* Owner Spotlight Responsive */
            .owner-spotlight-section { padding: 30px 10px; margin: 20px auto; }
            .owner-spotlight-section h2 { font-size: 1.8em; }
            .owner-spotlight-section img { width: 120px; height: 120px; }
            .owner-spotlight-section h3 { font-size: 1.6em; }
            .owner-spotlight-section .owner-title { font-size: 1em; }
            .owner-spotlight-section p { font-size: 0.9em; }
            .owner-spotlight-section .social-icons a { font-size: 1.1em; width: 35px; height: 35px; }

            .our-team-section h2 { font-size: 1.8em; margin-bottom: 30px; }
            .team-member-card { width: 100%; max-width: 280px; margin: 0 auto; }
            .team-member-card h3 { font-size: 1.4em; }
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

    <section class="about-hero">
        <div class="hero-content">
            <h1>About Us</h1>
            <p class="breadcrumbs"><a href="index.php">Home</a> / About Us</p>
        </div>
    </section>

    <section class="about-content-section" data-aos="fade-up">
        <h2>Our Story</h2>
        <p>Welcome to Beautyzone, your ultimate destination for all things beauty! Founded in 2010, we started with a simple vision: to make high-quality, authentic beauty products accessible to everyone. From humble beginnings as a small local boutique, we have grown into a trusted online presence, dedicated to bringing you the best in cosmetics, skincare, and exquisite jewellery.</p>
        <p>At Beautyzone, we believe that beauty is more than just skin deep; it's about confidence, self-expression, and feeling good in your own skin. We carefully curate our collections, partnering with reputable brands and artisans, to ensure every product meets our stringent standards for quality, safety, and ethical sourcing.</p>
        <p>Our passion lies in helping you discover products that enhance your natural beauty and reflect your unique style. Whether you're looking for the perfect shade of lipstick, a foundation that flawlessly matches your skin tone, a rejuvenating skincare routine, or a stunning piece of jewellery to complete your look, Beautyzone is here to guide you.</p>
        <p>Thank you for choosing Beautyzone. We are honored to be a part of your beauty journey.</p>
        <p class="signature">- The Beautyzone Team</p>
    </section>

    <section class="mission-vision-section">
        <div class="mission-vision-card" data-aos="fade-right">
            <h3>Our Mission</h3>
            <p>To empower individuals by providing a diverse selection of high-quality, authentic beauty and jewellery products, fostering self-confidence and self-expression, and delivering an exceptional shopping experience.</p>
        </div>
        <div class="mission-vision-card" data-aos="fade-left">
            <h3>Our Vision</h3>
            <p>To be the leading online destination for beauty and jewellery, recognized for our commitment to quality, customer satisfaction, and for inspiring a global community to embrace their unique beauty.</p>
        </div>
    </section>

    <section class="owner-spotlight-section" data-aos="fade-up">
        <h2>Meet Our Founder</h2>
        <div class="owner-card-content">
            <img src="imgs/aysha.jpeg" alt="Aysha Khan">
            <h3>Aysha Khan</h3>
            <p class="owner-title">Founder & Owner</p>
            <p>Aysha founded Beautyzone with a passion for empowering individuals through beauty. Her vision for high-quality, ethically sourced products has driven the brand's success and commitment to customer satisfaction. She believes in creating a space where every individual can find products that truly resonate with their unique essence.</p>
            <div class="social-icons">
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </section>

    <section class="our-team-section">
        <h2>Meet Our Team</h2>
        <div class="team-grid">
            <div class="team-member-card" data-aos="zoom-in" data-aos-delay="100">
                <img src="imgs/sana.jpeg" alt="Team Member 1">
                <h3>Sana Ahmed</h3>
                <p>CEO</p>
                <div class="social-icons">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="team-member-card" data-aos="zoom-in" data-aos-delay="200">
                <img src="imgs/zainab.jpeg" alt="Team Member 2">
                <h3>Zainab Khan</h3>
                <p>Chief Product Officer</p>
                <div class="social-icons">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="team-member-card" data-aos="zoom-in" data-aos-delay="300">
                <img src="imgs/usman.jpeg" alt="Team Member 3">
                <h3>Usman Ali</h3>
                <p>Head of Marketing</p>
                <div class="social-icons">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            </div>
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
    </script>

</body>
</html>