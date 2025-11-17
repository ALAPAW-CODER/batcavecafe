<?php
session_start();

// Initialize cart in session if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $product = [
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'image' => $_POST['product_image'],
            'quantity' => 1
        ];

        // Check if product already in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $product['name']) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $product;
        }

        header('Location: coffee-landing.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Malvar Bat Cave Cafe</title>
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
        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            position: relative;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            min-width: 200px;
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-menu.active {
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

        .dropdown-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .dropdown-header p {
            margin: 0;
            font-size: 12px;
            color: #6b7280;
        }

        .dropdown-header strong {
            font-size: 14px;
            color: #2c1810;
        }

        .dropdown-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2c1810;
            text-decoration: none;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 14px;
        }

        .dropdown-item:hover {
            background: #fff7ed;
            color: #d4b896;
        }

        .dropdown-item.logout {
            color: #dc2626;
            border-top: 1px solid #e5e7eb;
        }

        .dropdown-item.logout:hover {
            background: #fee2e2;
        }

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

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .cart-menu {
                min-width: 300px;
                right: -50px;
            }

            .dropdown-menu {
                right: -20px;
            }
        }

        @media (max-width: 600px) {
            .cart-menu {
                min-width: 280px;
                max-width: 90vw;
                right: -80px;
            }

            .dropdown-menu {
                min-width: 180px;
                right: -30px;
            }

            .cart-item-image {
                width: 50px;
                height: 50px;
            }

            .cart-item-name {
                font-size: 13px;
            }

            .cart-item-price {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <!-- Page Opening Animation Overlay -->
    <div id="introOverlay" class="intro-overlay">
        <img id="introBeanRoll" src="images/roll coffee bean.png" alt="Rolling Coffee Bean" class="intro-bean">
        <img id="introLogo" src="images/logoo.png" alt="Logo" class="intro-logo">
    </div>

    <!-- Main Content Wrapper -->
    <div id="mainContent" class="main-content">
    <!-- Header Section -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logoo.png" alt="The Malvar Bat Cave Cafe Logo">
                <span>The Malvar Bat <span class="tique">Cave Cafe</span></span>
            </div>
            <ul class="nav-links">
                <li><a href="coffee-landing.php" class="active">Home</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="coffee-beans">
            <span class="bean bean1">☕</span>
            <span class="bean bean2">☕</span>
            <span class="bean bean3">☕</span>
            <span class="bean bean4">☕</span>
            <span class="bean bean5">☕</span>
            <span class="bean bean6">☕</span>
        </div>

        <div class="hero-content">
            <div class="hero-text">
                <h1>The Malvar Bat <span class="highlight">Cave Cafe</span></h1>
                <p>The premier late-night study, social, and coffee spot near the Batangas State University Malvar Campus. Your perfect place for studying, socializing, and enjoying premium coffee.</p>
                <div class="hero-buttons">
                    <button class="btn-primary" onclick="window.location.href='booking.php'">
                        <img src="images/booking.png" alt="Book" class="btn-icon"> Book Now
                    </button>
                    <a href="#bestseller" class="btn-bestseller">
                        <img src="images/coffee beans.png" alt="Coffee" class="btn-icon"> Best Sellers
                    </a>
                </div>
            </div>

            <div class="hero-image">
                <div class="coffee-cup">
                    <img src="images/commercialcoffee-png.png" alt="Iced Bat Brew">
                    <div class="tag tag-cappuccino">The Bat Brew</div>
                    <div class="tag tag-rating">4.8 ⭐</div>
                    <div class="tag tag-sales">18K</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Now Section -->
    <section class="popular" id="bestseller">
        <div class="popular-header">
            <img src="images/themalvar.png" alt="Coffee" class="popular-coffee-img">
            <div class="popular-text-box">
                <h2>Our trending sips and bites that keep customers coming back for more.</h2>
            </div>
        </div>
        <div class="coffee-beans-bottom">
            <span class="bean">☕</span>
            <span class="bean">☕</span>
            <span class="bean">☕</span>
        </div>

        <div class="products-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/batbrew.png" alt="Iced Bat Brew">
                </div>
                <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                    <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;">Iced Bat Brew</h3>
                    <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;">Mystical dark roast with a smooth, bold flavor</p>
                    <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                        <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.9</span>
                        <span>Signature Brew</span>
                    </div>
                    <form method="POST" style="margin-top: 1.5rem;">
                        <input type="hidden" name="product_name" value="Iced Bat Brew">
                        <input type="hidden" name="product_price" value="145">
                        <input type="hidden" name="product_image" value="images/batbrew.png">
                        <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                            Add to Cart <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/redvelvet.png" alt="Red Velvet Muffin">
                </div>
                <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                    <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;">Red Velvet Muffin</h3>
                    <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;">Decadent red velvet muffin with cream cheese frosting</p>
                    <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                        <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.7</span>
                        <span>Sweet Treat</span>
                    </div>
                    <form method="POST" style="margin-top: 1.5rem;">
                        <input type="hidden" name="product_name" value="Red Velvet Muffin">
                        <input type="hidden" name="product_price" value="95">
                        <input type="hidden" name="product_image" value="images/redvelvet.png">
                        <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                            Add to Cart <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/nachos.png" alt="Nachos">
                </div>
                <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                    <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;">Nachos</h3>
                    <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;">Crispy tortilla chips topped with cheese and salsa</p>
                    <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                        <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.6</span>
                        <span>Savory Snack</span>
                    </div>
                    <form method="POST" style="margin-top: 1.5rem;">
                        <input type="hidden" name="product_name" value="Nachos">
                        <input type="hidden" name="product_price" value="110">
                        <input type="hidden" name="product_image" value="images/nachos.png">
                        <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                            Add to Cart <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product 4: Hot Cappuccino -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/hot capuccino.png" alt="Hot Cappuccino">
                </div>
                <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                    <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;">Hot Cappuccino</h3>
                    <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;">Rich espresso with velvety steamed milk foam</p>
                    <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                        <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.8</span>
                        <span>Hot Coffee</span>
                    </div>
                    <form method="POST" style="margin-top: 1.5rem;">
                        <input type="hidden" name="product_name" value="Hot Cappuccino">
                        <input type="hidden" name="product_price" value="120">
                        <input type="hidden" name="product_image" value="images/hot capuccino.png">
                        <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                            Add to Cart <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Product 5: Matcha Green Tea Frappe -->
            <div class="product-card">
                <div class="product-image">
                    <img src="images/matcha green tea frappe.png" alt="Matcha Green Tea Frappe">
                </div>
                <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                    <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;">Matcha Green Tea Frappe</h3>
                    <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;">Refreshing blended matcha with ice and cream</p>
                    <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                        <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.7</span>
                        <span>Iced Frappe</span>
                    </div>
                    <form method="POST" style="margin-top: 1.5rem;">
                        <input type="hidden" name="product_name" value="Matcha Green Tea Frappe">
                        <input type="hidden" name="product_price" value="135">
                        <input type="hidden" name="product_image" value="images/matcha green tea frappe.png">
                        <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                            Add to Cart <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision-section">
        <div class="mission-vision-container">
            <!-- Two Column Layout -->
            <div class="mission-vision-grid">
                <!-- Mission Column -->
                <div class="mission-column">
                    <h2 class="section-title">MISSION STATEMENT</h2>
                    <div class="statement-box">
                        <p>The Malvar Bat Cave Cafe is dedicated to providing a consistently comfortable, secure, and inspiring environment where students can focus and socialize. We commit to serving high-quality coffee and nourishment, and offering a seamless, professional experience through functional services like our dedicated reservation system, ensuring every visit lights up the path to their next achievement.</p>
                    </div>
                    <div class="image-container">
                        <img src="images/inside the cafe 1.png" alt="The Malvar Bat Cave Cafe Interior" class="statement-img">
                    </div>
                </div>

                <!-- Vision Column -->
                <div class="vision-column">
                    <h2 class="section-title">VISION STATEMENT</h2>
                    <div class="statement-box">
                        <p>To be the undisputed sanctuary and second home for the BSU community, recognized as the best late-night establishment that fuels academic success, fosters genuine connection, and elevates the local coffee culture in Malvar.</p>
                    </div>
                    <div class="image-container">
                        <img src="images/inside the cafe 2.png" alt="Inside The Malvar Bat Cave Cafe" class="statement-img">
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <!-- Login Modal -->
    <div id="loginModal" class="login-modal">
        <div class="login-modal-content">
            <button class="login-modal-close" onclick="closeLoginModal()">&times;</button>
            <div class="login-modal-header">
                <img src="images/logoo.png" alt="Logo" class="login-modal-logo">
                <h2>Welcome Back!</h2>
                <p>Please select how you want to continue</p>
            </div>
            <div class="login-modal-body">
                <div class="login-option-card" onclick="continueToBooking()">
                    <div class="login-option-icon">📅</div>
                    <div class="login-option-content">
                        <h3>Continue to Booking</h3>
                        <p>Proceed with your reservation and order</p>
                    </div>
                    <div class="login-option-arrow">→</div>
                </div>
                <div class="login-option-card" onclick="addForLater()">
                    <div class="login-option-icon">🛒</div>
                    <div class="login-option-content">
                        <h3>Add for Later</h3>
                        <p>Save items to cart and continue browsing</p>
                    </div>
                    <div class="login-option-arrow">→</div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            animation: fadeIn 0.3s;
        }

        .login-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-modal-content {
            background: white;
            border-radius: 25px;
            max-width: 500px;
            width: 90%;
            padding: 40px;
            position: relative;
            animation: slideUp 0.3s;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .login-modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 35px;
            background: none;
            border: none;
            cursor: pointer;
            color: #2B1A12;
            line-height: 1;
            transition: color 0.3s;
        }

        .login-modal-close:hover {
            color: #C9964C;
        }

        .login-modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-modal-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }

        .login-modal-header h2 {
            font-size: 28px;
            color: #2B1A12;
            margin-bottom: 10px;
        }

        .login-modal-header p {
            color: #6F4E37;
            font-size: 14px;
        }

        .login-modal-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .login-option-card {
            display: flex;
            align-items: center;
            padding: 20px;
            border: 2px solid #E5E7EB;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s;
            gap: 15px;
        }

        .login-option-card:hover {
            border-color: #C9964C;
            background: #FFF7ED;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(201, 150, 76, 0.2);
        }

        .login-option-icon {
            font-size: 40px;
            flex-shrink: 0;
        }

        .login-option-content {
            flex: 1;
        }

        .login-option-content h3 {
            font-size: 18px;
            color: #2B1A12;
            margin: 0 0 5px 0;
        }

        .login-option-content p {
            font-size: 13px;
            color: #6F4E37;
            margin: 0;
        }

        .login-option-arrow {
            font-size: 24px;
            color: #C9964C;
            flex-shrink: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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

        body.dark-mode .login-modal-content {
            background: #2B1A12;
        }

        body.dark-mode .login-modal-header h2,
        body.dark-mode .login-option-content h3 {
            color: #FAF3E0;
        }

        body.dark-mode .login-modal-header p,
        body.dark-mode .login-option-content p {
            color: #D4B896;
        }

        body.dark-mode .login-option-card {
            border-color: #4A3728;
            background: #1F120B;
        }

        body.dark-mode .login-option-card:hover {
            border-color: #C9964C;
            background: #3A2818;
        }

        body.dark-mode .login-modal-close {
            color: #FAF3E0;
        }

        body.dark-mode .login-modal-close:hover {
            color: #C9964C;
        }
    </style>

    <script>
        // Toggle Cart Dropdown
        function toggleCart() {
            const menu = document.getElementById('cartMenu');
            const cartItems = <?php echo count($_SESSION['cart']); ?>;
            
            // Show login modal if cart has items
            if (cartItems > 0) {
                showLoginModal();
            } else {
                menu.classList.toggle('active');
            }
        }

        // Show Login Modal
        function showLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Close Login Modal
        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Continue to Booking
        function continueToBooking() {
            window.location.href = 'booking.php';
        }

        // Add for Later (close modal and show cart)
        function addForLater() {
            closeLoginModal();
            const menu = document.getElementById('cartMenu');
            menu.classList.add('active');
        }

        // Close modal when clicking outside
        document.getElementById('loginModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeLoginModal();
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const cartDropdown = document.querySelector('.cart-dropdown');
            const cartMenu = document.getElementById('cartMenu');

            if (!cartDropdown.contains(event.target)) {
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

        // Continue Booking - redirect to booking page
        function continueBooking() {
            window.location.href = 'booking.php';
        }

        // Pick Up For Later - close cart and continue browsing
        function pickUpLater() {
            const cartMenu = document.getElementById('cartMenu');
            cartMenu.classList.remove('active');
            alert('Your items are saved! Continue browsing and come back to your cart anytime.');
        }
    </script>

    <!-- Page Opening Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const introOverlay = document.getElementById('introOverlay');
            const introBeanRoll = document.getElementById('introBeanRoll');
            const introLogo = document.getElementById('introLogo');
            const mainContent = document.getElementById('mainContent');
            
            // Fallback: Force show content after 4 seconds no matter what
            setTimeout(function() {
                if (introOverlay && introOverlay.style.display !== 'none') {
                    introOverlay.style.display = 'none';
                    mainContent.style.opacity = '1';
                    triggerEntranceAnimations();
                }
            }, 4000);
            
            // Hide main content initially
            mainContent.style.opacity = '0';
            
            // Stage 1: Bean rolls from top to center (1s)
            if (introBeanRoll) introBeanRoll.classList.add('bean-stage-1');
            
            // Stage 2: Bean spins while scaling (1s) - starts at 1s
            setTimeout(function() {
                if (introBeanRoll) {
                    introBeanRoll.classList.remove('bean-stage-1');
                    introBeanRoll.classList.add('bean-stage-2');
                }
            }, 1000);
            
            // Stage 3: Show logo (1s) - starts at 2s
            setTimeout(function() {
                if (introBeanRoll) introBeanRoll.style.display = 'none';
                if (introLogo) introLogo.classList.add('logo-appear');
            }, 2000);
            
            // Stage 4: Fade out and show content - starts at 3s
            setTimeout(function() {
                if (introOverlay) {
                    introOverlay.style.transition = 'opacity 0.6s ease';
                    introOverlay.style.opacity = '0';
                    
                    setTimeout(function() {
                        introOverlay.style.display = 'none';
                        mainContent.style.opacity = '1';
                        triggerEntranceAnimations();
                    }, 600);
                }
            }, 3000);
            
            function triggerEntranceAnimations() {
                const heroImage = document.querySelector('.hero-image');
                const heroText = document.querySelector('.hero-text');
                const popularSection = document.querySelector('.popular');
                
                if (heroImage) heroImage.classList.add('animate-slide-down');
                if (heroText) heroText.classList.add('animate-fade-in');
                if (popularSection) popularSection.classList.add('animate-fade-in-up');
            }
        });
    </script>
    </div><!-- Close main-content wrapper -->
</body>

</html>