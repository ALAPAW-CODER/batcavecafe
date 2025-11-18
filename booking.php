<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - The Malvar Bat Cave Cafe</title>
    <link rel="icon" type="image/png" href="./images/logoo.png">
    <link rel="stylesheet" href="coffee-landing.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/8196c78746.js" crossorigin="anonymous"></script>
    <script src="common.js" defer></script>
    <style>
        /* Booking Page Styles */
        .booking-page {
            min-height: 100vh;
            background: linear-gradient(180deg, rgba(10, 8, 6, 0.6) 0%, rgba(15, 12, 9, 0.6) 50%, rgba(12, 9, 7, 0.6) 100%), url('images/bgbooking1.png');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 20px 0;
        }

        .booking-container {
            max-width: 1600px;
            margin: 0 auto;
        }

        .booking-content-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .booking-content-wrapper.with-cart {
            grid-template-columns: 400px 1fr 1fr;
        }

        .booking-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 50px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .booking-coffee-img {
            width: 300px;
            height: auto;
            flex-shrink: 0;
            animation: zoomInOut 4s ease-in-out infinite;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
            transition: transform 0.3s ease;
        }

        .booking-coffee-img:hover {
            animation-play-state: paused;
            transform: scale(1.05);
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.4));
        }

        @keyframes zoomInOut {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        @keyframes wiggle {

            0%,
            100% {
                transform: rotate(0deg) translateY(0px);
            }

            25% {
                transform: rotate(-3deg) translateY(-5px);
            }

            50% {
                transform: rotate(0deg) translateY(0px);
            }

            75% {
                transform: rotate(3deg) translateY(-5px);
            }
        }

        .booking-text-box {
            background: #e8d4a8;
            border: 5px solid #1a1a1a;
            border-radius: 60px;
            padding: 30px 70px;
            box-shadow: 8px 8px 0px #1a1a1a;
            flex: 1;
            max-width: 900px;
        }

        .booking-header h1 {
            font-family: 'Donau', 'Arial Black', sans-serif;
            font-size: 36px;
            text-align: center;
            position: relative;
            z-index: 1;
            margin: 0;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0px;
            line-height: 1.3;
        }

        .booking-header p {
            text-align: center;
            margin: 10px 0 0 0;
            color: #2c1810;
            font-size: 16px;
            font-weight: 500;
        }

        .coffee-beans-top {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 20px;
        }

        .coffee-beans-top .bean {
            font-size: 25px;
            opacity: 0.4;
            animation: float 5s infinite ease-in-out;
        }

        .coffee-beans-top .bean:nth-child(1) {
            animation-delay: 0s;
        }

        .coffee-beans-top .bean:nth-child(2) {
            animation-delay: 0.5s;
        }

        .coffee-beans-top .bean:nth-child(3) {
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Form Container */
        .booking-form-wrapper {
            background: #e8d4a8;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }

        .booking-form-wrapper h2 {
            color: #2c1810;
            margin-bottom: 30px;
            font-size: 1.8rem;
            border-bottom: 3px solid #d4b896;
            padding-bottom: 15px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            color: #2c1810;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #d4b896;
            box-shadow: 0 0 0 3px rgba(212, 184, 150, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Price Display */
        .price-display {
            background: rgba(255, 224, 185, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #d4b896;
        }

        .price-display p {
            margin: 5px 0;
            color: #2c1810;
        }

        .price-display .total-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #d4b896;
            margin-top: 10px;
        }

        /* Payment Section */
        .payment-section {
            background: rgba(255, 224, 185, 0.9);
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            display: none;
        }

        .payment-section.active {
            display: block;
        }

        .payment-section h3 {
            color: #2c1810;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .qr-payment-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .qr-code-box {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .qr-code-box h4 {
            margin-bottom: 15px;
            color: #2c1810;
        }

        .qr-code-box img {
            max-width: 250px;
            width: 100%;
            height: auto;
            border: 3px solid #d4b896;
            border-radius: 10px;
        }

        .upload-proof-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .upload-proof-box h4 {
            margin-bottom: 15px;
            color: #2c1810;
        }

        .file-upload-wrapper {
            position: relative;
            margin: 20px 0;
        }

        .file-upload-wrapper input[type="file"] {
            display: none;
        }

        .file-upload-label {
            display: block;
            padding: 15px 20px;
            background: #d4b896;
            color: white;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .file-upload-label:hover {
            background: #c9964c;
            transform: translateY(-2px);
        }

        .file-name-display {
            margin-top: 10px;
            color: #2c1810;
            font-size: 0.9rem;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #8B4513 0%, #654321 100%);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 184, 150, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Map Section */
        .map-section {
            background: #e8d4a8;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
            height: fit-content;
        }

        .map-section h3 {
            color: #2c1810;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .map-section iframe {
            width: 100%;
            height: 500px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transform: perspective(1000px) rotateY(5deg);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .map-section iframe:hover {
            transform: perspective(1000px) rotateY(0deg);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        /* Cart Items Column in Booking */
        .booking-cart-section {
            background: #e8d4a8;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
            display: none;
        }

        .booking-cart-section.show {
            display: block;
        }

        .booking-cart-section h3 {
            color: #2c1810;
            margin-bottom: 20px;
            font-size: 1.5rem;
            border-bottom: 3px solid #d4b896;
            padding-bottom: 15px;
        }

        .booking-cart-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: #f5ecd7;
            border-radius: 15px;
            margin-bottom: 15px;
            align-items: center;
        }

        .booking-cart-item img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
        }

        .booking-cart-item-details {
            flex: 1;
        }

        .booking-cart-item-name {
            font-weight: 600;
            color: #2c1810;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .booking-cart-item-price {
            color: #d4b896;
            font-weight: 600;
            font-size: 13px;
        }

        .booking-cart-item-qty {
            color: #6b7280;
            font-size: 12px;
        }

        .booking-cart-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #d4b896;
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
            color: #2c1810;
        }

        /* Success Modal */
        .success-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            justify-content: center;
            align-items: center;
        }

        .success-modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .modal-content .success-icon {
            font-size: 4rem;
            color: #4caf50;
            margin-bottom: 20px;
        }

        .modal-content h2 {
            color: #2c1810;
            margin-bottom: 15px;
        }

        .modal-content p {
            color: #666;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .modal-content .reservation-id {
            background: #f9fafb;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: #d4b896;
        }

        .modal-content .btn-close {
            background: #d4b896;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 20px;
        }

        /* Design Under Image */
        .design-under-wrapper {
            margin: 30px 0 0 0;
            padding: 0;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            width: 100vw;
            height: 150px;
            background-image: url('images/design under.png');
            background-repeat: repeat-x;
            background-size: auto 100%;
            background-position: center;
            opacity: 0.9;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
            display: block;
        }

        .design-under-wrapper img {
            display: none;
        }

        /* Dark Mode Styles for Booking Header */
        body.dark-mode .booking-text-box {
            background: #2d2d2d;
            border-color: #404040;
            box-shadow: 8px 8px 0px #404040;
        }

        body.dark-mode .booking-header h1 {
            color: #e5e5e5;
        }

        body.dark-mode .booking-header p {
            color: #b0b0b0;
        }

        body.dark-mode .booking-coffee-img {
            filter: drop-shadow(0 5px 15px rgba(255, 255, 255, 0.1));
        }

        body.dark-mode .booking-coffee-img:hover {
            filter: drop-shadow(0 8px 20px rgba(255, 255, 255, 0.15));
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .booking-content-wrapper {
                grid-template-columns: 1fr;
            }

            .map-section iframe {
                transform: none;
            }

            .map-section iframe:hover {
                transform: none;
            }
        }

        @media (max-width: 1024px) {
            .booking-container {
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .booking-header {
                flex-direction: column;
                gap: 30px;
            }

            .booking-coffee-img {
                width: 200px;
            }

            .booking-text-box {
                padding: 25px 40px;
            }

            .booking-header h1 {
                font-size: 28px;
            }

            .booking-header p {
                font-size: 14px;
            }

            .booking-form-wrapper {
                padding: 25px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .qr-payment-container {
                grid-template-columns: 1fr;
            }

            .map-section iframe {
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            .booking-page {
                padding: 80px 15px 30px;
            }

            .booking-coffee-img {
                width: 150px;
            }

            .booking-text-box {
                padding: 20px 30px;
            }

            .booking-header h1 {
                font-size: 22px;
            }

            .booking-header p {
                font-size: 13px;
            }

            .booking-form-wrapper {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Header (copy from existing page) -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logoo.png" alt="The Malvar Bat Cave Cafe Logo">
                <span>The Malvar Bat <span class="tique">Cave Cafe</span></span>
            </div>
            <ul class="nav-links">
                <li><a href="coffee-landing.php">Home</a></li>
                <li><a href="special-menu.php">Menu</a></li>
                <li><a href="booking.php" class="active">Booking</a></li>
            </ul>
            <div class="nav-actions">
                <!-- Cart Dropdown -->
                <div class="cart-dropdown">
                    <button class="cart-btn" onclick="toggleCart()">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
                        <?php endif; ?>
                    </button>
                    <div class="cart-menu" id="cartMenu">
                        <div class="cart-header">
                            <h3>Shopping Cart</h3>
                        </div>
                        <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
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

    <!-- Booking Page Content -->
    <div class="booking-page">
        <div class="booking-container">
            <div class="booking-header">
                <img src="images/reserve.png" alt="Reserve" class="booking-coffee-img">
                <div class="booking-text-box">
                    <h1>Reserve Your Spot</h1>
                    <p>Book your table and enjoy the perfect study or event space</p>
                </div>
            </div>
            <div class="coffee-beans-top">
                <span class="bean">☕</span>
                <span class="bean">☕</span>
                <span class="bean">☕</span>
            </div>

            <div class="booking-content-wrapper<?php echo (!empty($_SESSION['cart']) && isset($_GET['from_cart'])) ? ' with-cart' : ''; ?>">
                <!-- Cart Items Column (only show if from cart) -->
                <?php if (!empty($_SESSION['cart']) && isset($_GET['from_cart'])): ?>
                    <div class="booking-cart-section show">
                        <h3>Your Order</h3>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                            <div class="booking-cart-item">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                <div class="booking-cart-item-details">
                                    <div class="booking-cart-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                    <div class="booking-cart-item-price">₱<?php echo number_format($item['price'], 0); ?></div>
                                    <div class="booking-cart-item-qty">Qty: <?php echo $item['quantity']; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="booking-cart-total">
                            <span>Total:</span>
                            <span>₱<?php echo number_format($total, 0); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Left Column: Booking Form -->
                <div class="booking-form-wrapper">
                    <h2>Reservation Details</h2>
                    <form id="bookingForm">
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="reservationType">Select Reservation Type *</label>
                                <select id="reservationType" name="reservationType" required>
                                    <option value="">Choose type...</option>
                                    <option value="Studying">Studying</option>
                                    <option value="Event">Event</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fullName">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" required placeholder="Juan Dela Cruz">
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required placeholder="juan@example.com">
                            </div>

                            <div class="form-group">
                                <label for="persons">Number of Persons *</label>
                                <select id="persons" name="persons" required>
                                    <option value="">Select...</option>
                                    <?php for ($i = 1; $i <= 20; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?> Person<?php echo $i > 1 ? 's' : ''; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="date">Date of Reservation *</label>
                                <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="startTime">Start Time *</label>
                                <select id="startTime" name="startTime" required>
                                    <option value="">Choose start time...</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                    <option value="18:00">6:00 PM</option>
                                    <option value="19:00">7:00 PM</option>
                                    <option value="20:00">8:00 PM</option>
                                    <option value="21:00">9:00 PM</option>
                                    <option value="22:00">10:00 PM</option>
                                    <option value="23:00">11:00 PM</option>
                                    <option value="00:00">12:00 AM</option>
                                    <option value="01:00">1:00 AM</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="endTime">End Time *</label>
                                <select id="endTime" name="endTime" required>
                                    <option value="">Choose end time...</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                    <option value="18:00">6:00 PM</option>
                                    <option value="19:00">7:00 PM</option>
                                    <option value="20:00">8:00 PM</option>
                                    <option value="21:00">9:00 PM</option>
                                    <option value="22:00">10:00 PM</option>
                                    <option value="23:00">11:00 PM</option>
                                    <option value="00:00">12:00 AM</option>
                                    <option value="01:00">1:00 AM</option>
                                </select>
                            </div>

                            <div class="form-group full-width">
                                <label for="specialRequests">Special Requests (Optional)</label>
                                <textarea id="specialRequests" name="specialRequests" placeholder="Any special requirements or preferences..."></textarea>
                            </div>
                        </div>

                        <!-- Price Display -->
                        <div class="price-display">
                            <p><strong>Rate:</strong> ₱100 per hour</p>
                            <p><strong>Duration:</strong> <span id="duration">-</span> hour(s)</p>
                            <p class="total-price">Total: ₱<span id="totalAmount">0</span></p>
                        </div>

                        <button type="submit" class="btn-primary" id="submitBooking">Continue to Payment</button>
                    </form>

                    <!-- Payment Section (Initially Hidden) -->
                    <div class="payment-section" id="paymentSection">
                        <h3>Complete Your Reservation</h3>
                        <div class="qr-payment-container">
                            <div class="qr-code-box">
                                <h4>Scan QR Code to Pay</h4>
                                <img src="images/qrcode.png" alt="GCash QR Code" id="qrCodeImage">
                                <p style="margin-top: 15px; color: #666; font-size: 0.9rem;">
                                    Scan this QR code using GCash to complete payment
                                </p>
                            </div>

                            <div class="upload-proof-box">
                                <h4>Upload Proof of Payment</h4>
                                <p style="color: #666; margin-bottom: 15px;">
                                    Please upload a screenshot of your payment confirmation
                                </p>

                                <div class="file-upload-wrapper">
                                    <input type="file" id="proofOfPayment" name="proofOfPayment" accept="image/*">
                                    <label for="proofOfPayment" class="file-upload-label">
                                        <i class="fa-solid fa-cloud-arrow-up"></i> Choose File
                                    </label>
                                    <div class="file-name-display" id="fileName">No file chosen</div>
                                </div>

                                <div id="reservationIdDisplay" style="background: #f9fafb; padding: 15px; border-radius: 10px; margin: 15px 0;">
                                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Reservation ID:</p>
                                    <p style="margin: 5px 0 0; font-weight: 700; color: #d4b896; font-size: 1.1rem;" id="resId">-</p>
                                </div>

                                <button type="button" class="btn-primary" id="submitPayment" disabled>
                                    Submit Payment Proof
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Google Maps Section -->
                <div class="map-section">
                    <h3><i class="fa-solid fa-location-dot"></i> Find Us Here</h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!4v1731740000000!6m8!1m7!1sCAoSLEFGMVFpcE1PWjNkdm5HMUJZb2Z1MHRmTUhsRGdYNzBnb1FjOEJqVkVZSWpI!2m2!1d14.0449448!2d121.1559532!3f0!4f0!5f0.7820865974627469"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Design Under Image -->
            <div class="design-under-wrapper">
                <img src="images/design under.png" alt="Design">
            </div>
        </div>
    </div>

    <!-- Footer -->
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
                        <li><a href="#" onclick="openAboutModal(event)">About Us</a></li>
                        <li><a href="#" onclick="openTermsModal(event)">Terms &amp; Conditions</a></li>
                        <li><a href="#contact">FAQs</a></li>
                        <li><a href="#" onclick="openPrivacyModal(event)">Privacy Policy</a></li>
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
                    <a href="#" aria-label="TikTok">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- About Us Modal -->
    <div id="aboutModal" class="info-modal">
        <div class="info-modal-content about-modal-content">
            <button class="info-modal-close" onclick="closeAboutModal()">&times;</button>
            <div class="info-modal-header">
                <img src="images/logoo.png" alt="Logo" class="info-modal-logo">
                <h2>About The Malvar Bat Cave Cafe</h2>
                <p>Discover the story behind our late-night sanctuary for the BatStateU community.</p>
            </div>
            <div class="info-modal-body about-modal-body">
                <p>
                    Welcome to The Malvar Bat Cave Café, your cozy hideout brewed for comfort, creativity, and connection.
                    Inspired by the unique charm of the Bat Cave name, our café blends warm ambiance, specialty coffee, and
                    a touch of mystery—creating a space where everyone feels at home.
                </p>
                <p>
                    Established near the Batangas State University - Malvar Campus, The Malvar Bat Cave Cafe was born
                    from a passion for exceptional coffee and a desire to provide a safe, inspiring space for students,
                    night owls, and creatives. Our mission centers on delivering comforting brews, hearty bites, and an
                    ambiance that encourages focus, collaboration, and genuine connection.
                </p>
                <p>
                    We serve premium specialty coffee, handcrafted with care using high-quality beans and perfected by
                    passionate baristas. From signature blends to ice-cold refreshers, every sip is made to elevate your
                    day. Pair it with our pastries and treats for the full Bat Cave experience. Beyond serving drinks, we
                    foster a supportive environment with thoughtful amenities: reliable Wi-Fi, reservation-ready study
                    pods, extended operating hours, and baristas who remember your favorite order.
                </p>
                <p>
                    Our story began with a simple vision: to build a relaxing haven where every guest can enjoy great
                    coffee, good conversations, and peaceful moments. Whether you’re studying, chilling with friends, or
                    taking a break from the noise, The Malvar Bat Cave Café is your perfect spot. We are proud to be
                    locally owned, sourcing beans and ingredients from trusted Philippine partners to support regional
                    farmers and artisans. Every visit contributes to a community that uplifts students and entrepreneurs
                    alike.
                </p>
                <p>
                    Whether you are gearing up for exams, hosting a late-night meetup, or simply craving comfort in a cup,
                    the Bat Cave is always ready to welcome you home. Thank you for being part of our growing community.
                    Sit back, breathe, and savor the moment at The Malvar Bat Cave Café.
                </p>
            </div>
        </div>
    </div>

    <!-- Terms & Conditions Modal -->
    <div id="termsModal" class="info-modal">
        <div class="info-modal-content terms-modal-content">
            <button class="info-modal-close" onclick="closeTermsModal()">&times;</button>
            <div class="info-modal-header">
                <img src="images/logoo.png" alt="Logo" class="info-modal-logo">
                <h2>Terms &amp; Conditions</h2>
                <p>Please review the terms and conditions for using The Malvar Bat Cave Cafe services.</p>
            </div>
            <div class="info-modal-body terms-modal-body">
                <p class="terms-last-updated"><strong>Last Updated:</strong> November 18, 2025</p>

                <h3>1. General Use</h3>
                <p>
                    By accessing or using our website, you confirm that you are at least 18 years old or have permission
                    from a parent/guardian, and that any information you submit for bookings or orders is accurate and
                    complete. Placing a booking or order signifies acceptance of these Terms &amp; Conditions and any
                    policy referenced on this site, including our Privacy Policy.
                </p>

                <h3>2. Online Pick-Up Orders</h3>
                <p>
                    Online orders are strictly for pick-up at the cafe. Orders are confirmed once all required details are
                    submitted and validated. Please arrive on time—items cannot be held indefinitely. Prices and
                    availability may change without notice, and we reserve the right to cancel or modify orders if items
                    are unavailable or if errors are discovered.
                </p>

                <h3>3. Room Bookings</h3>
                <p>
                    All rooms must be booked in advance through our website form. Confirmations depend on availability,
                    and reservations are held only for a limited grace period from the scheduled time. Late arrivals may
                    result in released slots during peak demand. Cancellations or rescheduling must follow the booking
                    policy shown at reservation time, and guests are responsible for any damages or excessive mess during
                    their stay.
                </p>

                <h3>4. Payments</h3>
                <p>
                    Payments may be required online for pick-up orders or collected in person for room bookings. You agree
                    to provide valid payment information and settle balances promptly. Proofs of payment must be
                    verifiable, and The Malvar Bat Cave Cafe is not liable for processing errors caused by third-party
                    payment systems.
                </p>

                <h3>5. Safety &amp; Conduct</h3>
                <p>
                    We expect all guests to maintain a respectful, quiet environment that supports studying and social
                    connection. Misbehavior, disruptive conduct, damage to property, or violations of cafe policies may
                    lead to denied service, cancelled bookings, or removal from the premises.
                </p>

                <h3>6. Privacy</h3>
                <p>
                    We value your privacy. Personal information (name, contact details, booking/order information) is used
                    solely to process pick-up orders and room reservations, to communicate updates about your requests, and
                    to improve the overall guest experience. We do not sell or share your data without consent, except as
                    required by law.
                </p>

                <h3>7. Liability</h3>
                <p>
                    Use of our website and services is at your own risk. The Malvar Bat Cave Cafe is not responsible for
                    personal injury, loss, or damage to belongings while on the premises, nor for delays or cancellations
                    caused by unforeseen circumstances such as power outages or severe weather.
                </p>

                <h3>8. Intellectual Property</h3>
                <p>
                    All logos, images, copy, and design assets on this website belong to The Malvar Bat Cave Cafe. Any
                    unauthorized use, reproduction, or distribution of these materials is strictly prohibited.
                </p>

                <h3>9. Changes to Terms</h3>
                <p>
                    We may update these Terms &amp; Conditions at any time to reflect operational changes or new policies.
                    Continued use of the website and our services constitutes acceptance of the latest version.
                </p>

                <h3>10. Contact Us</h3>
                <p>
                    For questions about bookings, pick-up orders, or these Terms &amp; Conditions, reach out via
                    <strong>Email:</strong> info@malvarbatcavecafe.com,
                    <strong>Phone:</strong> 09636996688, or visit us at Malvar, Batangas State University Area.
                </p>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="info-modal">
        <div class="info-modal-content privacy-modal-content">
            <button class="info-modal-close" onclick="closePrivacyModal()">&times;</button>
            <div class="info-modal-header">
                <img src="images/logoo.png" alt="Logo" class="info-modal-logo">
                <h2>Privacy Policy</h2>
                <p>Learn how The Malvar Bat Cave Café safeguards your data.</p>
            </div>
            <div class="info-modal-body privacy-modal-body">
                <div class="privacy-header">
                    <h1>Privacy Policy</h1>
                    <div class="cafe-name">The Malvar Bat Cave Café</div>
                    <div class="privacy-dates">
                        <strong>Effective Date:</strong> January 18, 2025<br>
                        <strong>Last Updated:</strong> January 18, 2025
                    </div>
                </div>
                <div class="privacy-intro">
                    The Malvar Bat Cave Café ("we," "our," or "us") is committed to protecting your privacy. This Privacy
                    Policy explains how we collect, use, store, and protect your personal information when you visit our café,
                    make reservations, order for pickup, or use our services.<br><br>
                    <strong>By accessing our services, you agree to the practices described in this policy.</strong>
                </div>

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

                <div class="privacy-section">
                    <h2>3. Event &amp; Study Reservations Policy</h2>
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

                <div class="privacy-section">
                    <h2>4. Order for Pickup (No Dine-In)</h2>
                    <p>When you place an order for pickup, we use your information to:</p>
                    <ul>
                        <li>Prepare your order</li>
                        <li>Notify you when it's ready</li>
                        <li>Verify identity upon pickup</li>
                    </ul>
                </div>

                <div class="privacy-section">
                    <h2>5. Operating Hours</h2>
                    <div class="highlight-box">
                        <p><strong>The Malvar Bat Cave Café is open from:</strong></p>
                        <p class="hours-highlight">⏰ 1:00 PM to 1:00 AM</p>
                        <p>Any data collected outside these hours (e.g., online reservations) will be processed during operational times.</p>
                    </div>
                </div>

                <div class="privacy-section">
                    <h2>6. Data Storage &amp; Security</h2>
                    <p>We take appropriate measures to protect your personal information, including:</p>
                    <ul>
                        <li>Secure digital storage</li>
                        <li>Limited access to authorized staff</li>
                        <li>Encryption where applicable</li>
                    </ul>
                    <p><strong>We do not sell, rent, or share your personal data with third parties except when required by law.</strong></p>
                </div>

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

                <div class="privacy-section">
                    <h2>8. Retention of Information</h2>
                    <p>We keep your data only as long as necessary for:</p>
                    <ul>
                        <li>Reservation and event records</li>
                        <li>Order fulfillment</li>
                        <li>Legal or business requirements</li>
                    </ul>
                </div>

                <div class="privacy-section">
                    <h2>9. Minors' Privacy</h2>
                    <p>We do not knowingly collect personal information from individuals under 18 without parental or guardian consent.</p>
                </div>

                <div class="privacy-section">
                    <h2>10. Changes to This Privacy Policy</h2>
                    <p>We may update this policy at any time. Any changes will be posted with a new "Last Updated" date.</p>
                </div>

                <div class="contact-box">
                    <h2>11. Contact Us</h2>
                    <p>For questions, concerns, or requests regarding your data, contact us:</p>
                    <p><strong>The Malvar Bat Cave Café</strong></p>
                    <p>📍 Malvar, Batangas State University Area</p>
                    <p>📞 09636996688</p>
                    <p>📧 info@malvarbatcavecafe.com</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            inset: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            animation: fadeIn 0.3s;
        }

        .info-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-modal-content {
            background: #fff;
            border-radius: 25px;
            max-width: 540px;
            width: 90%;
            padding: 40px;
            position: relative;
            animation: slideUp 0.3s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .about-modal-content,
        .terms-modal-content,
        .privacy-modal-content {
            max-height: 80vh;
            overflow-y: auto;
            max-width: 960px;
            width: min(960px, 95vw);
        }

        .info-modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 32px;
            background: none;
            border: none;
            cursor: pointer;
            color: #2b1a12;
            line-height: 1;
            transition: color 0.3s ease;
        }

        .info-modal-close:hover {
            color: #c9964c;
        }

        .info-modal-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .info-modal-logo {
            width: 70px;
            height: 70px;
            margin-bottom: 15px;
        }

        .info-modal-header h2 {
            font-size: 26px;
            color: #2b1a12;
            margin-bottom: 8px;
        }

        .info-modal-header p {
            color: #6f4e37;
            font-size: 14px;
        }

        .info-modal-body {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .about-modal-body p {
            font-size: 14px;
            color: #6f4e37;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .terms-modal-body h3 {
            margin-top: 16px;
            margin-bottom: 6px;
            font-size: 16px;
            color: #2b1a12;
        }

        .terms-modal-body p {
            font-size: 14px;
            color: #6f4e37;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .terms-last-updated {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            color: #c9964c;
        }

        .privacy-modal-body {
            color: #2b1a12;
        }

        .privacy-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .privacy-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .cafe-name {
            font-weight: 600;
            color: #6f4e37;
        }

        .privacy-dates {
            font-size: 14px;
            color: #6f4e37;
            margin-top: 10px;
            line-height: 1.6;
        }

        .privacy-intro {
            background: #fff7ed;
            border-left: 4px solid #c9964c;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .privacy-section {
            margin-bottom: 20px;
        }

        .privacy-section h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #2b1a12;
        }

        .privacy-section h3 {
            font-size: 16px;
            margin: 12px 0 8px;
            color: #6f4e37;
        }

        .privacy-section p,
        .privacy-section ul {
            font-size: 14px;
            line-height: 1.5;
            color: #4a3728;
        }

        .privacy-section ul {
            padding-left: 20px;
        }

        .highlight-box {
            background: #faf3e0;
            border: 1px solid #e5d4b5;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .hours-highlight {
            font-size: 20px;
            font-weight: 600;
            color: #c9964c;
            margin: 15px 0;
        }

        .contact-box {
            background: #fff5e1;
            border: 1px solid #f0d7b4;
            border-radius: 12px;
            padding: 18px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        body.dark-mode .info-modal-content {
            background: #2b1a12;
        }

        body.dark-mode .info-modal-header h2 {
            color: #faf3e0;
        }

        body.dark-mode .info-modal-header p,
        body.dark-mode .about-modal-body p,
        body.dark-mode .terms-modal-body p {
            color: #d4b896;
        }

        body.dark-mode .terms-modal-body h3 {
            color: #faf3e0;
        }

        body.dark-mode .info-modal-close {
            color: #faf3e0;
        }

        body.dark-mode .terms-last-updated {
            color: #f4d7a1;
        }

        body.dark-mode .privacy-modal-body {
            color: #faf3e0;
        }

        body.dark-mode .privacy-section h2 {
            color: #faf3e0;
        }

        body.dark-mode .privacy-section h3,
        body.dark-mode .privacy-section p,
        body.dark-mode .privacy-section ul,
        body.dark-mode .privacy-dates,
        body.dark-mode .privacy-intro {
            color: #d4b896;
        }

        body.dark-mode .privacy-intro,
        body.dark-mode .highlight-box,
        body.dark-mode .contact-box {
            background: #2f2015;
            border-color: #5a3e24;
        }

        body.dark-mode .hours-highlight {
            color: #f4d7a1;
        }
    </style>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="modal-content">
            <div class="success-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h2>Reservation Confirmed!</h2>
            <p>Thank you for your reservation. A confirmation receipt has been sent to your email.</p>
            <div class="reservation-id" id="modalReservationId">TMBC-XXXXXX</div>
            <p style="font-size: 0.9rem; color: #888;">
                Please check your email for complete details.
            </p>
            <button class="btn-close" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        let currentReservationId = '';

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('process_booking.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    currentReservationId = result.reservation_id;
                    document.getElementById('resId').textContent = currentReservationId;

                    // Show payment section
                    document.getElementById('paymentSection').classList.add('active');
                    document.getElementById('submitBooking').disabled = true;
                    document.getElementById('submitBooking').textContent = 'Awaiting Payment';

                    // Scroll to payment section
                    document.getElementById('paymentSection').scrollIntoView({
                        behavior: 'smooth'
                    });
                } else {
                    alert(result.message);
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
                console.error('Error:', error);
            }
        });

        // Handle file selection
        document.getElementById('proofOfPayment').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('fileName').textContent = fileName;
            document.getElementById('submitPayment').disabled = !this.files[0];
        });

        // Handle payment submission
        document.getElementById('submitPayment').addEventListener('click', async function() {
            const fileInput = document.getElementById('proofOfPayment');

            if (!fileInput.files[0]) {
                alert('Please select a proof of payment file');
                return;
            }

            const formData = new FormData();
            formData.append('proofOfPayment', fileInput.files[0]);
            formData.append('reservation_id', currentReservationId);

            this.disabled = true;
            this.textContent = 'Uploading...';

            try {
                const response = await fetch('upload_payment.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    document.getElementById('modalReservationId').textContent = currentReservationId;
                    document.getElementById('successModal').classList.add('active');
                } else {
                    alert(result.message);
                    this.disabled = false;
                    this.textContent = 'Submit Payment Proof';
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
                console.error('Error:', error);
                this.disabled = false;
                this.textContent = 'Submit Payment Proof';
            }
        });

        function closeModal() {
            document.getElementById('successModal').classList.remove('active');
            window.location.href = 'coffee-landing.php';
        }

        // Calculate duration and total price
        function calculatePrice() {
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;

            if (startTime && endTime) {
                const start = parseInt(startTime.split(':')[0]);
                const end = parseInt(endTime.split(':')[0]);

                let hours;
                if (end <= start) {
                    // Crossing midnight (e.g., 11 PM to 1 AM)
                    hours = (24 - start) + end;
                } else {
                    hours = end - start;
                }

                if (hours <= 0) {
                    document.getElementById('duration').textContent = '-';
                    document.getElementById('totalAmount').textContent = '0';
                    alert('End time must be after start time');
                    return;
                }

                const total = hours * 100;
                document.getElementById('duration').textContent = hours;
                document.getElementById('totalAmount').textContent = total;
            } else {
                document.getElementById('duration').textContent = '-';
                document.getElementById('totalAmount').textContent = '0';
            }
        }

        // Add event listeners for time calculation
        document.getElementById('startTime').addEventListener('change', calculatePrice);
        document.getElementById('endTime').addEventListener('change', calculatePrice);

        // Cart Functions
        function toggleCart() {
            const cartMenu = document.getElementById('cartMenu');
            cartMenu.classList.toggle('active');
        }

        function updateQuantity(index, change) {
            const formData = new FormData();
            formData.append('index', index);
            formData.append('change', change);

            fetch('update-cart.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        function continueBooking() {
            // Already on booking page, just close cart
            toggleCart();
        }

        function pickUpLater() {
            window.location.href = 'cart.php';
        }

        // Close cart when clicking outside
        document.addEventListener('click', function(event) {
            const cartMenu = document.getElementById('cartMenu');
            const cartBtn = document.querySelector('.cart-btn');

            if (!cartBtn.contains(event.target) && !cartMenu.contains(event.target)) {
                cartMenu.classList.remove('active');
            }
        });

        function openAboutModal(event) {
            if (event) event.preventDefault();
            const modal = document.getElementById('aboutModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeAboutModal() {
            const modal = document.getElementById('aboutModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        function openTermsModal(event) {
            if (event) event.preventDefault();
            const modal = document.getElementById('termsModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeTermsModal() {
            const modal = document.getElementById('termsModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        function openPrivacyModal(event) {
            if (event) event.preventDefault();
            const modal = document.getElementById('privacyModal');
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closePrivacyModal() {
            const modal = document.getElementById('privacyModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        document.getElementById('aboutModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeAboutModal();
            }
        });

        document.getElementById('termsModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeTermsModal();
            }
        });

        document.getElementById('privacyModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closePrivacyModal();
            }
        });
    </script>
</body>

</html>