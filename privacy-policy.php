<?php
session_start();

// Initialize cart in session if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - The Malvar Bat Cave Cafe</title>
    <script src="https://kit.fontawesome.com/8196c78746.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="./images/logoo.png">
    <link rel="stylesheet" href="coffee-landing.css?v=<?php echo time(); ?>">
    <script>
        // Dark Mode - Inline to ensure it loads first
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
            updateDarkModeIcon();
        }

        function updateDarkModeIcon() {
            const icon = document.getElementById('darkModeIcon');
            if (icon) {
                icon.src = document.body.classList.contains('dark-mode') ? 'images/lightmode.png' : 'images/darkmode.png';
                icon.style.width = '24px';
                icon.style.height = '24px';
                icon.style.objectFit = 'contain';
                icon.style.filter = 'brightness(0.9)';
            }
        }

        // Apply saved preference immediately
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode');
            document.body.classList.add('dark-mode');
        }

        // Update icon after page loads
        window.addEventListener('load', function() {
            updateDarkModeIcon();
        });
    </script>
    <script src="common.js" defer></script>
    <style>
        /* Cart Dropdown */
        .cart-dropdown {
            position: relative;
        }

        .cart-btn {
            position: relative;
            cursor: pointer;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc2626;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

        .cart-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            min-width: 550px;
            max-width: 650px;
            z-index: 1000;
            max-height: 800px;
            overflow-y: auto;
        }

        .cart-menu.active {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-header {
            padding: 20px;
            border-bottom: 2px solid #e5e7eb;
            background: #f9fafb;
        }

        .cart-header h3 {
            margin: 0;
            font-size: 18px;
            color: #2c1810;
        }

        .cart-items {
            padding: 15px;
            max-height: 300px;
            overflow-y: auto;
        }

        .cart-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            color: #2c1810;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .cart-item-price {
            color: #d4b896;
            font-weight: 600;
            font-size: 14px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
        }

        .qty-btn {
            width: 24px;
            height: 24px;
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #f9fafb;
        }

        .cart-footer {
            padding: 20px;
            border-top: 2px solid #e5e7eb;
            background: #f9fafb;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 700;
            color: #2c1810;
        }

        .checkout-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #d4b896 0%, #c9964c 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(217, 119, 6, 0.3);
        }

        .empty-cart {
            padding: 40px;
            text-align: center;
            color: #6b7280;
        }

        .empty-cart-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        /* Privacy Policy Specific Styles */
        .privacy-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 60px 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        body.dark-mode .privacy-container {
            background: #2B1A12;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .privacy-header {
            text-align: center;
            margin-bottom: 50px;
            padding-bottom: 30px;
            border-bottom: 3px solid #d4b896;
        }

        .privacy-header h1 {
            font-size: 42px;
            color: #2B1A12;
            margin-bottom: 15px;
            font-weight: 700;
        }

        body.dark-mode .privacy-header h1 {
            color: #FAF3E0;
        }

        .privacy-header .cafe-name {
            font-size: 28px;
            color: #C9964C;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .privacy-dates {
            font-size: 14px;
            color: #6F4E37;
            margin-top: 15px;
        }

        body.dark-mode .privacy-dates {
            color: #D4B896;
        }

        .privacy-intro {
            font-size: 16px;
            line-height: 1.8;
            color: #2c1810;
            margin-bottom: 40px;
            padding: 25px;
            background: #FFF7ED;
            border-left: 4px solid #C9964C;
            border-radius: 8px;
        }

        body.dark-mode .privacy-intro {
            background: #3A2818;
            color: #FAF3E0;
        }

        .privacy-section {
            margin-bottom: 40px;
        }

        .privacy-section h2 {
            font-size: 26px;
            color: #2B1A12;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        body.dark-mode .privacy-section h2 {
            color: #D4B896;
        }

        .privacy-section h3 {
            font-size: 20px;
            color: #6F4E37;
            margin-top: 25px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        body.dark-mode .privacy-section h3 {
            color: #C9964C;
        }

        .privacy-section p {
            font-size: 15px;
            line-height: 1.8;
            color: #4A3728;
            margin-bottom: 15px;
        }

        body.dark-mode .privacy-section p {
            color: #D4B896;
        }

        .privacy-section ul {
            margin-left: 25px;
            margin-bottom: 20px;
        }

        .privacy-section li {
            font-size: 15px;
            line-height: 1.8;
            color: #4A3728;
            margin-bottom: 10px;
        }

        body.dark-mode .privacy-section li {
            color: #D4B896;
        }

        .highlight-box {
            background: #FFF7ED;
            border-left: 4px solid #C9964C;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }

        body.dark-mode .highlight-box {
            background: #3A2818;
        }

        .contact-box {
            background: linear-gradient(135deg, #d4b896 0%, #c9964c 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-top: 50px;
            text-align: center;
        }

        .contact-box h2 {
            color: white !important;
            margin-bottom: 20px;
        }

        .contact-box p {
            color: white !important;
            font-size: 16px;
            margin: 10px 0;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: #2B1A12;
            color: #FAF3E0;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            margin-bottom: 30px;
        }

        .back-button:hover {
            background: #C9964C;
            transform: translateX(-5px);
        }

        body.dark-mode .back-button {
            background: #C9964C;
            color: #2B1A12;
        }

        body.dark-mode .back-button:hover {
            background: #D4B896;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .privacy-container {
                margin: 80px 20px 30px;
                padding: 40px 25px;
            }

            .privacy-header h1 {
                font-size: 32px;
            }

            .privacy-header .cafe-name {
                font-size: 22px;
            }

            .privacy-section h2 {
                font-size: 22px;
            }

            .cart-menu {
                min-width: 300px;
                right: -50px;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logoo.png" alt="The Malvar Bat Cave Cafe Logo">
                <span>The Malvar Bat <span class="tique">Cave Cafe</span></span>
            </div>
            <ul class="nav-links">
                <li><a href="coffee-landing.php">Home</a></li>
                <li><a href="special-menu.php">Menu</a></li>
                <li><a href="booking.php">Booking</a></li>
            </ul>
            <div class="nav-actions">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search menu items..." onkeyup="searchMenu()">
                    <button id="search-Input" class="search-btn"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                </div>

                <!-- Cart Dropdown -->
                <div class="cart-dropdown">
                    <button class="cart-btn" onclick="toggleCart()">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                        <?php if (count($_SESSION['cart']) > 0): ?>
                            <span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
                        <?php endif; ?>
                    </button>
                    <div class="cart-menu" id="cartMenu">
                        <div class="cart-header">
                            <h3>Shopping Cart</h3>
                        </div>
                        <?php if (empty($_SESSION['cart'])): ?>
                            <div class="empty-cart">
                                <div class="empty-cart-icon">🛒</div>
                                <p>Your cart is empty</p>
                            </div>
                        <?php else: ?>
                            <div class="cart-items">
                                <?php
                                $total = 0;
                                foreach ($_SESSION['cart'] as $index => $item):
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $total += $subtotal;
                                ?>
                                    <div class="cart-item">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-item-image">
                                        <div class="cart-item-details">
                                            <div class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                            <div class="cart-item-price">₱<?php echo number_format($item['price'], 0); ?></div>
                                            <div class="cart-item-quantity">
                                                <button class="qty-btn" onclick="updateQuantity(<?php echo $index; ?>, -1)">-</button>
                                                <span><?php echo $item['quantity']; ?></span>
                                                <button class="qty-btn" onclick="updateQuantity(<?php echo $index; ?>, 1)">+</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="cart-footer">
                                <div class="cart-total">
                                    <span>Total:</span>
                                    <span>₱<?php echo number_format($total, 0); ?></span>
                                </div>
                                <div class="cart-action-buttons">
                                    <button class="checkout-btn" onclick="continueBooking()">Continue Booking</button>
                                    <button class="pickup-later-btn" onclick="pickUpLater()">Pick Up For Later</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button type="button" class="dark-mode-btn" id="darkModeBtn" onclick="toggleDarkMode(); return false;" title="Switch to Dark Mode">
                    <i id="darkModeIcon" class="fa-solid fa-moon fa-2xl"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- Privacy Policy Content -->
    <div class="privacy-container">
        <a href="coffee-landing.php" class="back-button">
            <i class="fa-solid fa-arrow-left"></i> Back to Home
        </a>

        <div class="privacy-header">
            <h1>Privacy Policy</h1>
            <div class="cafe-name">The Malvar Bat Cave Café</div>
            <div class="privacy-dates">
                <strong>Effective Date:</strong> January 1, 2025<br>
                <strong>Last Updated:</strong> January 1, 2025
            </div>
        </div>

        <div class="privacy-intro">
            The Malvar Bat Cave Café ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, store, and protect your personal information when you visit our café, make reservations, order for pickup, or use our services.<br><br>
            <strong>By accessing our services, you agree to the practices described in this policy.</strong>
        </div>

        <!-- Section 1 -->
        <div class="privacy-section">
            <h2>1. Information We Collect</h2>
            <p>We collect personal information only when necessary for operations, including:</p>
            
            <h3>1.1 Personal Information Provided by You</h3>
            <ul>
                <li>Full Name</li>
                <li>Contact Number</li>
                <li>Email Address</li>
                <li>Reservation Details (event or study slot)</li>
                <li>Order Details for Pickup</li>
                <li>Number of participants for events</li>
                <li>Preferred time and date</li>
            </ul>

            <h3>1.2 Automatically Collected Information</h3>
            <p>When you visit our website or reservation page:</p>
            <ul>
                <li>IP Address</li>
                <li>Browser type</li>
                <li>Device information</li>
                <li>Pages viewed</li>
            </ul>
        </div>

        <!-- Section 2 -->
        <div class="privacy-section">
            <h2>2. How We Use Your Information</h2>
            <p>We use your data to provide and improve our services, including:</p>
            <ul>
                <li>Managing event reservations</li>
                <li>Managing study area slots</li>
                <li>Handling pickup orders</li>
                <li>Confirming and updating your reservation status</li>
                <li>Communicating important announcements or changes</li>
                <li>Improving customer experience</li>
                <li>Maintaining security and preventing misuse</li>
            </ul>
        </div>

        <!-- Section 3 -->
        <div class="privacy-section">
            <h2>3. Event & Study Reservations Policy</h2>
            
            <div class="highlight-box">
                <h3>3.1 Event Reservation Capacity Rule</h3>
                <ul>
                    <li>Event reservations are allowed only until the first <strong>20 persons</strong> are confirmed.</li>
                    <li>Once 20 participants are reached, no additional reservations will be accepted until the ongoing event has finished.</li>
                </ul>
            </div>

            <div class="highlight-box">
                <h3>3.2 Study Area Reservation Rule</h3>
                <ul>
                    <li>Study slots are available as long as the 20-person limit is not yet reached.</li>
                    <li>A real-time update will indicate whether slots remain open.</li>
                </ul>
            </div>

            <h3>3.3 Reservation Verification</h3>
            <p>We may contact you to:</p>
            <ul>
                <li>Confirm your reservation</li>
                <li>Verify event size</li>
                <li>Update you about slot availability</li>
            </ul>
        </div>

        <!-- Section 4 -->
        <div class="privacy-section">
            <h2>4. Order for Pickup (No Dine-In)</h2>
            <p>When you place an order for pickup, we use your information to:</p>
            <ul>
                <li>Prepare your order</li>
                <li>Notify you when it's ready</li>
                <li>Verify identity upon pickup</li>
            </ul>
        </div>

        <!-- Section 5 -->
        <div class="privacy-section">
            <h2>5. Operating Hours</h2>
            <div class="highlight-box">
                <p><strong>The Malvar Bat Cave Café is open from:</strong></p>
                <p style="font-size: 20px; font-weight: 600; color: #C9964C; margin: 15px 0;">⏰ 1:00 PM to 1:00 AM</p>
                <p>Any data collected outside these hours (e.g., online reservations) will be processed during operational times.</p>
            </div>
        </div>

        <!-- Section 6 -->
        <div class="privacy-section">
            <h2>6. Data Storage & Security</h2>
            <p>We take appropriate measures to protect your personal information, including:</p>
            <ul>
                <li>Secure digital storage</li>
                <li>Limited access to authorized staff</li>
                <li>Encryption where applicable</li>
            </ul>
            <p><strong>We do not sell, rent, or share your personal data with third parties except when required by law.</strong></p>
        </div>

        <!-- Section 7 -->
        <div class="privacy-section">
            <h2>7. Your Rights</h2>
            <p>You may:</p>
            <ul>
                <li>Request to view the information we hold about you</li>
                <li>Ask for corrections to inaccurate data</li>
                <li>Request deletion of your personal information (unless required for recordkeeping)</li>
            </ul>
            <p>Contact details are provided below.</p>
        </div>

        <!-- Section 8 -->
        <div class="privacy-section">
            <h2>8. Retention of Information</h2>
            <p>We keep your data only as long as necessary for:</p>
            <ul>
                <li>Reservation and event records</li>
                <li>Order fulfillment</li>
                <li>Legal or business requirements</li>
            </ul>
        </div>

        <!-- Section 9 -->
        <div class="privacy-section">
            <h2>9. Minors' Privacy</h2>
            <p>We do not knowingly collect personal information from individuals under 18 without parental or guardian consent.</p>
        </div>

        <!-- Section 10 -->
        <div class="privacy-section">
            <h2>10. Changes to This Privacy Policy</h2>
            <p>We may update this policy at any time. Any changes will be posted with a new "Last Updated" date.</p>
        </div>

        <!-- Section 11 - Contact -->
        <div class="contact-box">
            <h2>11. Contact Us</h2>
            <p>For questions, concerns, or requests regarding your data, contact us:</p>
            <p><strong>The Malvar Bat Cave Café</strong></p>
            <p>📍 Malvar, Batangas State University Area</p>
            <p>📞 09636996688</p>
            <p>📧 info@malvarbatcavecafe.com</p>
        </div>
    </div>

    <!-- Professional Footer Section -->
    <footer class="footer-main">
        <div class="footer-container">
            <!-- Main Footer Content -->
            <div class="footer-grid">
                <!-- Brand Section -->
                <div class="footer-brand">
                    <div class="footer-logo-group">
                        <img src="images/logo.png" alt="The Malvar Bat Cave Cafe Logo">
                        <span class="footer-brand-name">The Malvar Bat<br>Cave Cafe</span>
                    </div>
                    <p class="footer-description">
                        The premier late-night study, social, and coffee spot near BatStateU Malvar Campus. Your sanctuary for exceptional brews and warm connections.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="footer-column">
                    <h3 class="footer-heading">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="coffee-landing.php">Home</a></li>
                        <li><a href="special-menu.php">Menu</a></li>
                        <li><a href="booking.php">Booking</a></li>
                    </ul>
                </div>

                <!-- Information -->
                <div class="footer-column">
                    <h3 class="footer-heading">Information</h3>
                    <ul class="footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#careers">Careers</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-column">
                    <h3 class="footer-heading">Contact & Hours</h3>
                    <p class="footer-contact">📍 Malvar, Batangas State University Area</p>
                    <p class="footer-contact">📞 09636996688</p>
                    <p class="footer-contact">📧 info@malvarbatcavecafe.com</p>
                    <p class="footer-contact">⏰ Mon - Sun: 1:00 PM - 1:00 AM</p>
                </div>
            </div>

            <!-- Footer Divider -->
            <div class="footer-divider"></div>

            <!-- Bottom Section -->
            <div class="footer-bottom">
                <p class="footer-copyright">
                    © 2025 The Malvar Bat Cave Cafe. All rights reserved.
                </p>

                <!-- Social Links -->
                <div class="footer-social">
                    <a href="#" aria-label="Facebook">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </a>
                    <a href="#" aria-label="TikTok">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle Cart Dropdown
        function toggleCart() {
            const menu = document.getElementById('cartMenu');
            const cartItems = <?php echo count($_SESSION['cart']); ?>;
            
            if (cartItems > 0) {
                // If cart has items, redirect to booking
                window.location.href = 'booking.php';
            } else {
                menu.classList.toggle('active');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const cartDropdown = document.querySelector('.cart-dropdown');
            const cartMenu = document.getElementById('cartMenu');

            if (cartDropdown && !cartDropdown.contains(event.target)) {
                cartMenu.classList.remove('active');
            }
        });

        // Update cart quantity
        function updateQuantity(index, change) {
            fetch('update-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `index=${index}&change=${change}`
                })
                .then(() => {
                    location.reload();
                });
        }

        // Continue Booking
        function continueBooking() {
            window.location.href = 'booking.php?from_cart=1';
        }

        // Pick Up For Later - go to cart page
        function pickUpLater() {
            window.location.href = 'cart.php';
        }
    </script>
</body>

</html>
