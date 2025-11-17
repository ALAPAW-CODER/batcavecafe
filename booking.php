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
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.08);
            }
        }

        @keyframes wiggle {
            0%, 100% {
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
            0%, 100% {
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
                        <i class="fa-solid fa-cart-shopping fa-xl"></i>
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
                
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </button>
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
                                <?php for($i = 1; $i <= 20; $i++): ?>
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
                                <option value="02:00">2:00 AM</option>
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
                    document.getElementById('paymentSection').scrollIntoView({ behavior: 'smooth' });
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
    </script>
</body>
</html>
