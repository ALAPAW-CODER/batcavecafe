<?php
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle item removal
if (isset($_POST['remove_item'])) {
    $index = $_POST['item_index'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    }
    header('Location: cart.php');
    exit();
}

// Handle quantity update
if (isset($_POST['update_quantity'])) {
    $index = $_POST['item_index'];
    $quantity = max(1, intval($_POST['quantity']));
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
    header('Location: cart.php');
    exit();
}

// Handle size update
if (isset($_POST['update_size'])) {
    $index = $_POST['item_index'];
    $size = $_POST['size'];
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['size'] = $size;
        // Update price based on size
        $basePrice = $_SESSION['cart'][$index]['base_price'] ?? $_SESSION['cart'][$index]['price'];
        $_SESSION['cart'][$index]['base_price'] = $basePrice;
        
        // Size pricing multipliers
        $multipliers = [
            'Short' => 0.8,
            'Tall' => 1.0,
            'Grande' => 1.3
        ];
        
        if (isset($multipliers[$size])) {
            $_SESSION['cart'][$index]['price'] = $basePrice * $multipliers[$size];
        }
    }
    header('Location: cart.php');
    exit();
}

// Calculate totals
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$total = $subtotal; // No tax
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - The Malvar Bat Cave Cafe</title>
    <link rel="icon" type="image/png" href="./images/logoo.png">
    <link rel="stylesheet" href="coffee-landing.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/8196c78746.js" crossorigin="anonymous"></script>
    <script src="common.js" defer></script>
    <style>
        /* Cart Page Styles */
        .cart-page {
            min-height: 100vh;
            background: linear-gradient(180deg, rgba(10, 8, 6, 0.6) 0%, rgba(15, 12, 9, 0.6) 50%, rgba(12, 9, 7, 0.6) 100%), url('images/bgbooking1.png');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 20px 0;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .cart-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 50px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            background: transparent;
        }

        .cart-coffee-img {
            width: 250px;
            height: auto;
            flex-shrink: 0;
            animation: zoomInOut 4s ease-in-out infinite;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
            transition: transform 0.3s ease;
        }

        .cart-coffee-img:hover {
            animation-play-state: paused;
            transform: scale(1.05);
        }

        @keyframes zoomInOut {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        .cart-text-box {
            background: #e8d4a8;
            border: 5px solid #1a1a1a;
            border-radius: 60px;
            padding: 30px 70px;
            box-shadow: 8px 8px 0px #1a1a1a;
            flex: 1;
            max-width: 900px;
        }

        .cart-header h1 {
            font-family: 'Donau', 'Arial Black', sans-serif;
            font-size: 36px;
            text-align: center;
            margin: 0;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            line-height: 1.3;
        }

        .cart-header p {
            text-align: center;
            margin: 10px 0 0 0;
            color: #1a1a1a;
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

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Cart Content */
        .cart-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        .cart-items-section {
            background: #e8d4a8;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
        }

        .cart-items-section h2 {
            color: #2c1810;
            margin-bottom: 30px;
            font-size: 1.8rem;
            border-bottom: 3px solid #d4b896;
            padding-bottom: 15px;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #d4b896;
            margin-bottom: 20px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 120px 1fr auto;
            gap: 20px;
            padding: 20px;
            background: #f5ecd7;
            border-radius: 15px;
            margin-bottom: 20px;
            align-items: center;
        }

        .cart-item-image {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            overflow: hidden;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c1810;
            margin-bottom: 10px;
        }

        .cart-item-price {
            font-size: 1.1rem;
            color: #d4b896;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .size-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .size-btn {
            padding: 8px 16px;
            border: 2px solid #d4b896;
            background: white;
            color: #2c1810;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .size-btn.active {
            background: #d4b896;
            color: white;
        }

        .size-btn:hover {
            transform: translateY(-2px);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .qty-btn {
            width: 35px;
            height: 35px;
            border: 2px solid #d4b896;
            background: white;
            color: #2c1810;
            border-radius: 50%;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s;
        }

        .qty-btn:hover {
            background: #d4b896;
            color: white;
        }

        .quantity-display {
            font-size: 1.1rem;
            font-weight: 700;
            min-width: 30px;
            text-align: center;
            color: #2c1810;
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .remove-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .remove-btn:hover {
            background: #cc0000;
            transform: translateY(-2px);
        }

        /* Summary Section */
        .cart-summary {
            background: #e8d4a8;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
            height: fit-content;
            position: sticky;
            top: 120px;
        }

        .cart-summary h2 {
            color: #2c1810;
            margin-bottom: 30px;
            font-size: 1.8rem;
            border-bottom: 3px solid #d4b896;
            padding-bottom: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 1.1rem;
            color: #2c1810;
        }

        .summary-row.total {
            font-size: 1.5rem;
            font-weight: 700;
            color: #d4b896;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
            margin-top: 20px;
        }

        .checkout-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #d4b896 0%, #c9964c 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 184, 150, 0.3);
        }

        .continue-shopping {
            width: 100%;
            padding: 15px;
            background: white;
            color: #2c1810;
            border: 2px solid #d4b896;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .continue-shopping:hover {
            background: #f9fafb;
        }

        /* Payment Section */
        .payment-section {
            background: rgba(45, 45, 45, 0.8);
            border: 2px solid rgba(212, 184, 150, 0.3);
            padding: 40px;
            border-radius: 20px;
            margin-top: 30px;
            display: none;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
        }

        .payment-section.active {
            display: block;
        }

        .payment-section h3 {
            color: #e8d5c4;
            margin-bottom: 30px;
            font-size: 1.5rem;
            text-align: center;
            border-bottom: 3px solid #d4b896;
            padding-bottom: 15px;
        }

        .qr-payment-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .qr-code-box {
            text-align: center;
            background: rgba(30, 30, 30, 0.9);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid rgba(212, 184, 150, 0.2);
        }

        .qr-code-box h4 {
            margin-bottom: 20px;
            color: #e8d5c4;
            font-size: 1.2rem;
        }

        .qr-code-box img {
            max-width: 280px;
            width: 100%;
            height: auto;
            border: 3px solid #d4b896;
            border-radius: 15px;
        }

        .qr-code-box p {
            margin-top: 15px;
            color: #b0b0b0;
            font-size: 0.95rem;
        }

        .upload-proof-box {
            background: rgba(30, 30, 30, 0.9);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid rgba(212, 184, 150, 0.2);
        }

        .upload-proof-box h4 {
            margin-bottom: 20px;
            color: #e8d5c4;
            font-size: 1.2rem;
        }

        .upload-proof-box p {
            color: #b0b0b0;
            margin-bottom: 20px;
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
            padding: 18px 25px;
            background: #d4b896;
            color: #1a1a1a;
            text-align: center;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 1rem;
        }

        .file-upload-label:hover {
            background: #c9964c;
            transform: translateY(-2px);
        }

        .file-name-display {
            margin-top: 15px;
            color: #e8d5c4;
            font-size: 0.9rem;
            text-align: center;
        }

        .submit-payment-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #d4b896 0%, #c9964c 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 25px;
            transition: all 0.3s;
        }

        .submit-payment-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 184, 150, 0.3);
        }

        .submit-payment-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Dark Mode */
        body.dark-mode .cart-text-box {
            background: #2d2d2d;
            border-color: #404040;
            box-shadow: 8px 8px 0px #404040;
        }

        body.dark-mode .cart-header h1,
        body.dark-mode .cart-header p {
            color: #e5e5e5;
        }

        body.dark-mode .cart-items-section,
        body.dark-mode .cart-summary {
            background: #2d2d2d;
        }

        body.dark-mode .cart-items-section h2,
        body.dark-mode .cart-summary h2,
        body.dark-mode .cart-item-name {
            color: #e5e5e5;
        }

        body.dark-mode .cart-item {
            background: #1a1a1a;
        }

        body.dark-mode .size-btn,
        body.dark-mode .qty-btn,
        body.dark-mode .continue-shopping {
            background: #1a1a1a;
            color: #e5e5e5;
        }

        body.dark-mode .summary-row {
            color: #e5e5e5;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cart-content {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: relative;
                top: 0;
            }
        }

        @media (max-width: 768px) {
            .cart-header {
                flex-direction: column;
            }

            .cart-coffee-img {
                width: 180px;
            }

            .cart-text-box {
                padding: 25px 40px;
            }

            .cart-item {
                grid-template-columns: 80px 1fr;
                gap: 15px;
            }

            .cart-item-image {
                width: 80px;
                height: 80px;
            }

            .cart-item-actions {
                grid-column: 1 / -1;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
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
                <div class="cart-dropdown">
                    <button class="cart-btn" id="cartBtn">
                        <i class="fa-solid fa-cart-shopping fa-xl"></i>
                        <span class="cart-count" id="cartCount"><?php echo count($_SESSION['cart']); ?></span>
                    </button>
                </div>
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        <i class="fa-solid fa-user fa-xl"></i>
                    </button>
                </div>
                <button type="button" class="dark-mode-btn" id="darkModeBtn" onclick="toggleDarkMode(); return false;" title="Switch to Dark Mode">
                    <i id="darkModeIcon" class="fa-solid fa-moon fa-2xl"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- Cart Page Content -->
    <div class="cart-page">
        <div class="cart-container">
            <div class="cart-header">
                <img src="images/themalvar.png" alt="Coffee" class="cart-coffee-img">
                <div class="cart-text-box">
                    <h1>Your Shopping Cart</h1>
                    <p>Review your items and complete your order</p>
                </div>
            </div>
            <div class="coffee-beans-top">
                <span class="bean">☕</span>
                <span class="bean">☕</span>
                <span class="bean">☕</span>
            </div>

            <div class="cart-content">
                <!-- Cart Items -->
                <div class="cart-items-section">
                    <h2>Cart Items (<?php echo count($_SESSION['cart']); ?>)</h2>
                    
                    <?php if (empty($_SESSION['cart'])): ?>
                        <div class="empty-cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <h3>Your cart is empty</h3>
                            <p>Add some delicious items to get started!</p>
                            <button class="checkout-btn" onclick="window.location.href='special-menu.php'" style="max-width: 300px; margin: 20px auto;">
                                Browse Menu
                            </button>
                        </div>
                    <?php else: ?>
                        <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                            <div class="cart-item">
                                <div class="cart-item-image">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                                
                                <div class="cart-item-details">
                                    <div class="cart-item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                    <div class="cart-item-price">₱<?php echo number_format($item['price'], 2); ?></div>
                                    
                                    <!-- Size Selector (for drinks) -->
                                    <?php if (stripos($item['name'], 'coffee') !== false || stripos($item['name'], 'brew') !== false || stripos($item['name'], 'latte') !== false || stripos($item['name'], 'frappe') !== false || stripos($item['name'], 'cappuccino') !== false || stripos($item['name'], 'matcha') !== false): ?>
                                        <div class="size-selector">
                                            <form method="POST" style="display: flex; gap: 10px;">
                                                <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                                <input type="hidden" name="update_size" value="1">
                                                <?php $currentSize = $item['size'] ?? 'Tall'; ?>
                                                <button type="submit" name="size" value="Short" class="size-btn <?php echo $currentSize === 'Short' ? 'active' : ''; ?>">Short</button>
                                                <button type="submit" name="size" value="Tall" class="size-btn <?php echo $currentSize === 'Tall' ? 'active' : ''; ?>">Tall</button>
                                                <button type="submit" name="size" value="Grande" class="size-btn <?php echo $currentSize === 'Grande' ? 'active' : ''; ?>">Grande</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="quantity-controls">
                                        <form method="POST" style="display: flex; align-items: center; gap: 15px;">
                                            <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                            <input type="hidden" name="update_quantity" value="1">
                                            <button type="submit" name="quantity" value="<?php echo $item['quantity'] - 1; ?>" class="qty-btn" <?php echo $item['quantity'] <= 1 ? 'disabled' : ''; ?>>-</button>
                                            <span class="quantity-display"><?php echo $item['quantity']; ?></span>
                                            <button type="submit" name="quantity" value="<?php echo $item['quantity'] + 1; ?>" class="qty-btn">+</button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="cart-item-actions">
                                    <form method="POST">
                                        <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                        <button type="submit" name="remove_item" value="1" class="remove-btn">
                                            <i class="fa-solid fa-trash"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Order Summary -->
                <?php if (!empty($_SESSION['cart'])): ?>
                    <div class="cart-summary">
                        <h2>Order Summary</h2>
                        
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>₱<?php echo number_format($total, 2); ?></span>
                        </div>
                        
                        <button class="checkout-btn" id="proceedCheckoutBtn" onclick="window.location.href='booking.php?from_cart=1'">
                            <i class="fa-solid fa-calendar-check"></i> Continue to Booking
                        </button>
                        
                        <button class="continue-shopping" onclick="window.location.href='special-menu.php'">
                            <i class="fa-solid fa-arrow-left"></i> Continue Shopping
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Payment Section -->
            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="payment-section" id="paymentSection">
                    <h3>Complete Your Payment</h3>
                    <div class="qr-payment-container">
                        <div class="qr-code-box">
                            <h4>Scan QR Code to Pay</h4>
                            <img src="images/qrcode.png" alt="GCash QR Code">
                            <p>Total Amount: <strong>₱<?php echo number_format($total, 2); ?></strong></p>
                            <p style="margin-top: 10px;">Scan this QR code using GCash to complete payment</p>
                        </div>

                        <div class="upload-proof-box">
                            <h4>Upload Proof of Payment</h4>
                            <p>Please upload a screenshot of your payment confirmation</p>
                            
                            <form action="upload_payment.php" method="POST" enctype="multipart/form-data" id="paymentForm">
                                <div class="file-upload-wrapper">
                                    <input type="file" id="proofOfPayment" name="proofOfPayment" accept="image/*" required onchange="displayFileName()">
                                    <label for="proofOfPayment" class="file-upload-label">
                                        <i class="fa-solid fa-cloud-arrow-up"></i> Choose File
                                    </label>
                                    <div class="file-name-display" id="fileName">No file chosen</div>
                                </div>

                                <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                                <input type="hidden" name="cart_items" value='<?php echo json_encode($_SESSION['cart']); ?>'>

                                <button type="submit" class="submit-payment-btn" id="submitPaymentBtn" disabled>
                                    <i class="fa-solid fa-paper-plane"></i> Submit Payment Proof
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-main">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo-group">
                        <img src="images/logo.png" alt="The Malvar Bat Cave Cafe Logo">
                        <span class="footer-brand-name">The Malvar Bat<br>Cave Cafe</span>
                    </div>
                    <p class="footer-description">
                        The premier late-night study, social, and coffee spot near BatStateU Malvar Campus. Your sanctuary for exceptional brews and warm connections.
                    </p>
                </div>

                <div class="footer-column">
                    <h3 class="footer-heading">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="coffee-landing.php">Home</a></li>
                        <li><a href="special-menu.php">Menu</a></li>
                        <li><a href="booking.php">Booking</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3 class="footer-heading">Information</h3>
                    <ul class="footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#careers">Careers</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3 class="footer-heading">Contact & Hours</h3>
                    <p class="footer-contact">📍 Malvar, Batangas State University Area</p>
                    <p class="footer-contact">📞 09636996688</p>
                    <p class="footer-contact">📧 info@malvarbatcavecafe.com</p>
                    <p class="footer-contact">⏰ Mon - Sun: 1:00 PM - 1:00 AM</p>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-bottom">
                <p class="footer-copyright">
                    © 2025 The Malvar Bat Cave Cafe. All rights reserved.
                </p>

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
        // Show payment section
        function showPaymentSection() {
            const paymentSection = document.getElementById('paymentSection');
            paymentSection.classList.add('active');
            
            // Scroll to payment section
            paymentSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Hide checkout button
            document.getElementById('proceedCheckoutBtn').style.display = 'none';
        }

        // Display selected file name
        function displayFileName() {
            const input = document.getElementById('proofOfPayment');
            const fileNameDisplay = document.getElementById('fileName');
            const submitBtn = document.getElementById('submitPaymentBtn');
            
            if (input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
                submitBtn.disabled = false;
            } else {
                fileNameDisplay.textContent = 'No file chosen';
                submitBtn.disabled = true;
            }
        }

        // Dark mode support
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
            updateDarkModeIcon();
        }

        function updateDarkModeIcon() {
            const icon = document.getElementById('darkModeIcon');
            if (icon) {
                icon.className = document.body.classList.contains('dark-mode') ? 'fa-solid fa-sun fa-2xl' : 'fa-solid fa-moon fa-2xl';
            }
        }

        // Apply saved preference
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
        
        window.addEventListener('load', updateDarkModeIcon);
    </script>
</body>
</html>
