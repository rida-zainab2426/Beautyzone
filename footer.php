<style>
    /* Footer Styling */
    footer {
        background: linear-gradient(to right, #FFE4E1, #FFB6C1); /* Same as navbar background */
        color: #333; /* Dark text for contrast */
        padding: 60px 20px;
        font-size: 0.95em;
        margin-top: 60px; /* Add some space above the footer */
    }

    .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        gap: 30px;
    }

    .footer-column {
        flex: 1;
        min-width: 200px;
        margin-bottom: 20px;
    }

    .footer-column h3 {
        color: #E75488; /* Rose Pink for headings */
        font-size: 1.3em;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .footer-column p, .footer-column ul {
        color: #333; /* Dark text for paragraphs and lists */
        line-height: 1.8;
        margin-bottom: 10px;
    }

    .footer-column ul {
        list-style: none;
        padding: 0;
    }

    .footer-column ul li {
        margin-bottom: 10px;
    }

    .footer-column ul li a {
        color: #333; /* Dark text for links */
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-column ul li a:hover {
        color: #fff; /* White on hover for better contrast */
    }

    .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-icons a {
        color: #333; /* Dark text for social icons */
        font-size: 1.5em;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #fff; /* White on hover for better contrast */
    }

    /* Mobile Responsiveness for Footer */
    @media (max-width: 768px) {
        .footer-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-column {
            min-width: unset;
            width: 100%;
        }

        .social-icons {
            justify-content: center;
        }
    }
</style>
<footer>
        <div class="footer-container">
            <div class="footer-column about-us-f">
                <h3>Beautyzone</h3>
                <p>Your ultimate destination for high-quality cosmetics and skincare. We empower you to express your unique beauty with confidence.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about_us.php">About Us</a></li>
                    <li><a href="contact_us.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Categories</h3>
                <ul>
                    <li><a href="Lipsticks.php">Lipstick</a></li>
                    <li><a href="Blushes.php">Blushes</a></li>
                    <li><a href="Foundations.php">Foundation</a></li>
                    <li><a href="Necklaces.php">Necklace</a></li>
                    <li><a href="Rings.php">Ring</a></li>
                </ul>
            </div>
            <div class="footer-column contact-info">
                <h3>Contact Us</h3>
                <p><i class="fas fa-map-marker-alt"></i> 123 Beauty Ave, Glamour City, BC 12345</p>
                <p><i class="fas fa-phone"></i> +1 (123) 456-7890</p>
                <p><i class="fas fa-envelope"></i> info@beautyzone.com</p>
            </div>
        </div>
    </footer>