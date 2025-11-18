<?php
session_start();

// Initialize cart in session if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
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

    header('Location: special-menu.php');
    exit();
}

// Menu items data
$menuItems = [
    'frappe' => [
        ['name' => 'Mocha Frappe', 'price' => 185, 'image' => 'images/mocha frappe.png', 'desc' => 'A rich blend of coffee, chocolate, and milk blended with ice, topped with whipped cream. Perfect for chocolate and coffee lovers alike.'],
        ['name' => 'Caramel Frappe', 'price' => 180, 'image' => 'images/caramel frappe.png', 'desc' => 'Sweet caramel sauce swirled into a creamy coffee blend, finished with whipped cream and a drizzle of caramel on top.'],
        ['name' => 'Java Chip Frappe', 'price' => 190, 'image' => 'images/java chip frappe.png', 'desc' => 'A chocolatey mix of coffee, milk, and chocolate chips — blended smooth and topped with whipped cream and mocha drizzle.'],
        ['name' => 'Matcha Green Tea Frappe', 'price' => 195, 'image' => 'images/matcha green tea frappe.png', 'desc' => 'A refreshing fusion of earthy matcha green tea and creamy milk, perfectly blended and lightly sweetened.'],
        ['name' => 'Strawberries & Cream Frappe', 'price' => 185, 'image' => 'images/strawberries and cream frappe.png', 'desc' => 'Sweet and creamy strawberry goodness in every sip — a refreshing, non-coffee option for a fruity treat.'],
    ],
    'pastries' => [
        ['name' => 'Banana Bread Slice', 'price' => 85, 'image' => 'images/banana bread.jpg', 'desc' => 'Moist, flavorful, and baked fresh with ripe bananas for that comforting homemade taste. A timeless favorite that pairs perfectly with coffee or tea.'],
        ['name' => 'Buttered Croissant', 'price' => 95, 'image' => 'images/buttered croissantt.jpg', 'desc' => 'Flaky, golden layers of buttery pastry baked to perfection. Simple, elegant, and best enjoyed warm with your favorite brew.'],
        ['name' => 'Red Velvet mini cake', 'price' => 90, 'image' => 'images/redvelvet.png', 'desc' => 'Soft, velvety layers with a hint of cocoa, topped with smooth cream cheese frosting. A sweet, classic indulgence to brighten your day.'],
    ],
    'snacks' => [
        ['name' => 'Nachos Grande', 'price' => 130, 'image' => 'images/nachos.png', 'desc' => 'Crispy tortilla chips layered with melted cheese, savory beef, and tangy salsa. Perfect for sharing or pairing with your favorite iced drink.'],
        ['name' => 'Truffle Fries', 'price' => 130, 'image' => 'images/trufflefries.png', 'desc' => 'Crispy golden fries tossed in aromatic truffle oil and topped with parmesan cheese. A rich and indulgent twist on a classic favorite.'],
        ['name' => 'Mini Hotdog Bites', 'price' => 135, 'image' => 'images/minihotdogbites.jpg', 'desc' => 'Bite-sized, juicy hotdogs wrapped in soft pastry rolls. A fun, savory snack that\'s great for quick bites or sharing with friends over coffee.'],
        ['name' => 'Potato Wedges', 'price' => 120, 'image' => 'images/potatowedges.jpg', 'desc' => 'Thick-cut and seasoned to perfection, our potato wedges are crispy on the outside and fluffy inside — a satisfying snack for any time of day.'],
        ['name' => 'Mozzarella Sticks', 'price' => 150, 'image' => 'images/mozarellasticks.jpg', 'desc' => 'Crispy on the outside, soft and gooey on the inside. These golden mozzarella sticks are perfect for sharing and pair deliciously with marinara dip.'],
    ],
    'meals' => [
        ['name' => 'Creamy Carbonara', 'price' => 185, 'image' => 'images/creamy carbonara.jpg', 'desc' => 'Rich and savory pasta coated in a creamy white sauce with bacon bits and parmesan.'],
        ['name' => 'Spaghetti', 'price' => 175, 'image' => 'images/spaghetti.png', 'desc' => 'Classic Filipino-style sweet and savory spaghetti topped with ground meat and cheese.'],
        ['name' => 'Bulgogi Rice Bowl', 'price' => 195, 'image' => 'images/bulgogi rice bowl.jpg', 'desc' => 'Korean-inspired beef slices marinated in sweet soy-garlic sauce, served over steamed rice.'],
        ['name' => 'Chicken Fillet Rice Bowl', 'price' => 185, 'image' => 'images/chicken fillet.jpg', 'desc' => 'Crispy golden chicken fillet paired with rice and a side of special house gravy.'],
        ['name' => 'Chicken Teriyaki Rice Bowl', 'price' => 195, 'image' => 'images/chicken teriyaki rice.jpg', 'desc' => 'Grilled chicken glazed with teriyaki sauce, served with steamed rice and vegetables.'],
        ['name' => 'Tuna Sandwich', 'price' => 145, 'image' => 'images/Tuna sandwich.jpg', 'desc' => 'Classic tuna spread mixed with mayo, celery, and spices, served on toasted bread.'],
        ['name' => 'Chicken Sandwich', 'price' => 155, 'image' => 'images/chicken sandwich.jpg', 'desc' => 'Tender shredded chicken in creamy dressing with lettuce and tomato on soft bread.'],
        ['name' => 'Caesar Salad', 'price' => 165, 'image' => 'images/caesar salad.jpg', 'desc' => 'Crisp romaine lettuce, parmesan, croutons, and Caesar dressing for a timeless favorite.'],
        ['name' => 'Kani Salad', 'price' => 175, 'image' => 'images/kani salad.jpg', 'desc' => 'Japanese-style salad with crab sticks, cucumber, mango, and creamy sesame dressing.'],
    ],
    'hot-coffee' => [
        ['name' => 'Hot Espresso', 'price' => 75, 'image' => 'images/hot espresso.png', 'desc' => 'Rich and bold single or double shot of pure espresso. Perfect for espresso enthusiasts.'],
        ['name' => 'Hot Americano', 'price' => 85, 'image' => 'images/hot americano.png', 'desc' => 'Bold espresso diluted with hot water for a smooth, full-bodied cup.'],
        ['name' => 'Hot Cappuccino', 'price' => 95, 'image' => 'images/hot capuccino.png', 'desc' => 'Perfect balance of espresso, steamed milk, and velvety foam topped.'],
        ['name' => 'Hot Latte', 'price' => 100, 'image' => 'images/hot latte.png', 'desc' => 'Smooth and creamy espresso with steamed milk and a touch of foam.'],
        ['name' => 'Hot Macchiato', 'price' => 90, 'image' => 'images/hot macchiato.png', 'desc' => 'Espresso "marked" with a dollop of steamed milk foam for a strong, bold taste.'],
        ['name' => 'Hot Mocha', 'price' => 105, 'image' => 'images/hot mocha.png', 'desc' => 'Rich espresso combined with steamed milk and chocolate, topped with whipped cream.'],
        ['name' => 'Hot Spanish Latte', 'price' => 105, 'image' => 'images/hot spanish latte.png', 'desc' => 'Creamy latte with a touch of sea salt and caramel for a unique flavor.'],
        ['name' => 'Hot Matcha Latte', 'price' => 110, 'image' => 'images/hot matcha latte.png', 'desc' => 'Smooth and creamy matcha green tea latte, lightly sweetened and beautifully frothy.'],
    ],
    'iced-coffee' => [
        ['name' => 'Dirty Matcha Latte', 'price' => 150, 'image' => 'images/dirtymatchalattew.png', 'desc' => 'Matcha with espresso shot, topped with whipped cream'],
        ['name' => 'Matcha', 'price' => 140, 'image' => 'images/matcha.png', 'desc' => 'Pure matcha latte blended with ice'],
        ['name' => 'Iced Americano', 'price' => 120, 'image' => 'images/iced americano.png', 'desc' => 'Strong and refreshing espresso over ice'],
        ['name' => 'Iced Cappucino', 'price' => 120, 'image' => 'images/iced cappucino.png', 'desc' => 'Cold cappucino with foam'],
        ['name' => 'Iced Bat Brew', 'price' => 150, 'image' => 'images/batbrew.png', 'desc' => 'Our signature blend served over ice'],
        ['name' => 'Iced Salted Spanish Latte', 'price' => 150, 'image' => 'images/iced salted spanish latte.png', 'desc' => 'Creamy Spanish latte with a touch of sea salt'],
        ['name' => 'Iced Caramel Latte', 'price' => 140, 'image' => 'images/iced caramel latte.png', 'desc' => 'Smooth latte with sweet caramel flavor'],
        ['name' => 'Vanilla Latte', 'price' => 130, 'image' => 'images/vanilla latte.png', 'desc' => 'Classic vanilla-flavored latte'],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu - The Malvar Bat Cave Cafe</title>
    <link rel="icon" type="image/png" href="./images/logoo.png">
    <link rel="stylesheet" href="coffee-landing.css?v=<?php echo time(); ?>">
    <script src="https://kit.fontawesome.com/8196c78746.js" crossorigin="anonymous"></script>

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
                // When dark mode is enabled, show sun icon (lightmode.png)
                // When dark mode is disabled, show moon icon (darkmode.png)
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
        /* Include the same dropdown styles as coffee-landing.php */
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
            min-width: 350px;
            max-width: 400px;
            z-index: 1000;
            max-height: 500px;
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

        @media (max-width: 768px) {
            .cart-menu {
                min-width: 300px;
                right: -50px;
            }

            .dropdown-menu {
                right: -20px;
            }
        }

        @media (max-width: 480px) {
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
                <li><a href="special-menu.php" class="active">Menu</a></li>
                <li><a href="booking.php">Booking</a></li>
            </ul>
            <div class="nav-actions">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search menu items..." onkeyup="searchMenu()">
                    <button class="search-btn"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
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

    <!-- Special Menu Section -->
    <section class="special-menu-section">
        <div class="container">
            <h2 class="section-title">Menu</h2>

            <!-- Category Filter Buttons -->
            <div class="category-filters">
                <button class="filter-btn active" onclick="filterCategory('all')">All</button>
                <button class="filter-btn" onclick="filterCategory('hot-coffee')">Hot Coffee</button>
                <button class="filter-btn" onclick="filterCategory('iced-coffee')">Iced Coffee</button>
                <button class="filter-btn" onclick="filterCategory('frappe')">Frappe</button>
                <button class="filter-btn" onclick="filterCategory('pastries')">Pastries</button>
                <button class="filter-btn" onclick="filterCategory('snacks')">Snacks</button>
                <button class="filter-btn" onclick="filterCategory('meals')">Meals</button>
            </div>

            <!-- Hot Coffee Section -->
            <div class="category-header">
                <h3 class="category-title" data-category="hot-coffee">Hot Coffee</h3>
                <p class="category-description">Warm, bold, and comforting — our hot coffee selection is brewed to energize your day with rich flavors in every sip.</p>
            </div>
            <div class="menu-grid" data-category="hot-coffee">
                <?php foreach ($menuItems['hot-coffee'] as $item): ?>
                    <a href="#" data-category="hot-coffee" class="group relative flex h-full flex-col overflow-hidden rounded-3xl bg-white/90 shadow ring-1 ring-[#D7A86E]/20 transition-all duration-300 hover:-translate-y-2 hover:shadow-lg hover:ring-[#C9964C]/30" style="text-decoration: none; color: inherit;">
                        <div class="relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="aspect-4/5 w-full mt-9 object-contain transition duration-500 group-hover:scale-105" style="height: 350px; object-fit: contain;">
                        </div>
                        <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                            <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;"><?php echo htmlspecialchars($item['desc']); ?></p>
                            <div class="mt-4 flex flex-wrap gap-2" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2] transition" data-size="short" data-price="<?php echo $item['price'] - 20; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Short - ₱<?php echo $item['price'] - 20; ?></button>
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#C9964C] text-white rounded-full hover:bg-[#B8854B] transition active" data-size="tall" data-price="<?php echo $item['price']; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #C9964C; color: white; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Tall - ₱<?php echo $item['price']; ?></button>
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2] transition" data-size="grande" data-price="<?php echo $item['price'] + 25; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Grande - ₱<?php echo $item['price'] + 25; ?></button>
                            </div>
                            <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                                <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.9</span>
                                <span>Premium Blend</span>
                            </div>
                            <form method="POST" style="margin-top: 1.5rem;">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?> (Tall)" class="product-name-input">
                                <input type="hidden" name="product_price" value="<?php echo $item['price']; ?>" class="product-price-input">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($item['image']); ?>">
                                <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                                    Add to Cart <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Iced Coffee Section -->
            <div class="category-header">
                <h3 class="category-title" data-category="iced-coffee">Iced Coffee</h3>
                <p class="category-description">Chilled, refreshing, and handcrafted — our iced coffee lineup delivers smooth, satisfying blends perfect for any weather.</p>
            </div>
            <div class="menu-grid" data-category="iced-coffee">
                <?php foreach ($menuItems['iced-coffee'] as $item): ?>
                    <a href="#" data-category="iced-coffee" class="group relative flex h-full flex-col overflow-hidden rounded-3xl bg-white/90 shadow ring-1 ring-[#D7A86E]/20 transition-all duration-300 hover:-translate-y-2 hover:shadow-lg hover:ring-[#C9964C]/30" style="text-decoration: none; color: inherit;">
                        <div class="relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="aspect-4/5 w-full mt-9 object-contain transition duration-500 group-hover:scale-105" style="height: 350px; object-fit: contain;">
                        </div>
                        <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                            <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;"><?php echo htmlspecialchars($item['desc']); ?></p>
                            <div class="mt-4 flex flex-wrap gap-2" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2] transition" data-size="short" data-price="<?php echo $item['price'] - 20; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Short - ₱<?php echo $item['price'] - 20; ?></button>
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#C9964C] text-white rounded-full hover:bg-[#B8854B] transition active" data-size="tall" data-price="<?php echo $item['price']; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #C9964C; color: white; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Tall - ₱<?php echo $item['price']; ?></button>
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2] transition" data-size="grande" data-price="<?php echo $item['price'] + 25; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Grande - ₱<?php echo $item['price'] + 25; ?></button>
                            </div>
                            <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                                <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.9</span>
                                <span>Rich Aroma</span>
                            </div>
                            <form method="POST" style="margin-top: 1.5rem;">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?> (Tall)" class="product-name-input">
                                <input type="hidden" name="product_price" value="<?php echo $item['price']; ?>" class="product-price-input">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($item['image']); ?>">
                                <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                                    Add to Cart <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Frappe Section -->
            <div class="category-header">
                <h3 class="category-title" data-category="frappe">Frappe</h3>
                <p class="category-description">Blended to perfection — our frappés offer creamy, icy indulgence with every refreshing sip.</p>
            </div>
            <div class="menu-grid" data-category="frappe">
                <?php foreach ($menuItems['frappe'] as $item): ?>
                    <a href="#" data-category="frappe" class="group relative flex h-full flex-col overflow-hidden rounded-3xl bg-white/90 shadow ring-1 ring-[#D7A86E]/20 transition-all duration-300 hover:-translate-y-2 hover:shadow-lg hover:ring-[#C9964C]/30" style="text-decoration: none; color: inherit;">
                        <div class="relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="aspect-4/5 w-full mt-9 object-contain transition duration-500 group-hover:scale-105" style="height: 350px; object-fit: contain;">
                        </div>
                        <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                            <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;"><?php echo htmlspecialchars($item['desc']); ?></p>
                            <div class="mt-4 flex flex-wrap gap-2" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2] transition" data-size="short" data-price="<?php echo $item['price'] - 20; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Short - ₱<?php echo $item['price'] - 20; ?></button>
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#C9964C] text-white rounded-full hover:bg-[#B8854B] transition active" data-size="tall" data-price="<?php echo $item['price']; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #C9964C; color: white; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Tall - ₱<?php echo $item['price']; ?></button>
                                <button type="button" class="size-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2] transition" data-size="grande" data-price="<?php echo $item['price'] + 25; ?>" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">Grande - ₱<?php echo $item['price'] + 25; ?></button>
                            </div>
                            <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                                <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.9</span>
                                <span>Rich Aroma</span>
                            </div>
                            <form method="POST" style="margin-top: 1.5rem;">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?> (Tall)" class="product-name-input">
                                <input type="hidden" name="product_price" value="<?php echo $item['price']; ?>" class="product-price-input">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($item['image']); ?>">
                                <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                                    Add to Cart <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Pastries Section -->
            <div class="category-header">
                <h3 class="category-title" data-category="pastries">Pastries</h3>
                <p class="category-description">Freshly baked and irresistible — our pastries bring the perfect touch of sweetness to your cafe experience.</p>
            </div>
            <div class="menu-grid" data-category="pastries">
                <?php foreach ($menuItems['pastries'] as $item): ?>
                    <a href="#" data-category="pastries" class="group relative flex h-full flex-col overflow-hidden rounded-3xl bg-white/90 shadow ring-1 ring-[#D7A86E]/20 transition-all duration-300 hover:-translate-y-2 hover:shadow-lg hover:ring-[#C9964C]/30" style="text-decoration: none; color: inherit;">
                        <div class="relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="aspect-4/5 w-full mt-9 object-contain transition duration-500 group-hover:scale-105" style="height: 350px; object-fit: contain;">
                        </div>
                        <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                            <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;"><?php echo htmlspecialchars($item['desc']); ?></p>
                            <div class="mt-4 flex flex-wrap gap-2" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button class="price-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2]" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">₱<?php echo $item['price']; ?></button>
                            </div>
                            <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                                <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.9</span>
                                <span>Freshly Baked</span>
                            </div>
                            <form method="POST" style="margin-top: 1.5rem;">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo $item['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($item['image']); ?>">
                                <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                                    Add to Cart <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Snacks Section -->
            <div class="category-header">
                <h3 class="category-title" data-category="snacks">Snacks</h3>
                <p class="category-description">Quick bites made tasty — enjoy delicious, easy-to-love snacks that pair perfectly with your favorite drinks.</p>
            </div>
            <div class="menu-grid" data-category="snacks">
                <?php foreach ($menuItems['snacks'] as $item): ?>
                    <a href="#" data-category="snacks" class="group relative flex h-full flex-col overflow-hidden rounded-3xl bg-white/90 shadow ring-1 ring-[#D7A86E]/20 transition-all duration-300 hover:-translate-y-2 hover:shadow-lg hover:ring-[#C9964C]/30" style="text-decoration: none; color: inherit;">
                        <div class="relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="aspect-4/5 w-full mt-9 object-contain transition duration-500 group-hover:scale-105" style="height: 350px; object-fit: contain;">
                        </div>
                        <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                            <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;"><?php echo htmlspecialchars($item['desc']); ?></p>
                            <div class="mt-4 flex flex-wrap gap-2" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button class="price-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2]" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">₱<?php echo $item['price']; ?></button>
                            </div>
                            <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                                <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.8</span>
                                <span>Savory Delight</span>
                            </div>
                            <form method="POST" style="margin-top: 1.5rem;">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo $item['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($item['image']); ?>">
                                <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                                    Add to Cart <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Meals Section -->
            <div class="category-header">
                <h3 class="category-title" data-category="meals">Pasta & Rice Bowls</h3>
                <p class="category-description">Hearty and flavorful — our meals are crafted to satisfy your cravings, whether you're here for lunch or dinner.</p>
            </div>
            <div class="menu-grid" data-category="meals">
                <?php foreach ($menuItems['meals'] as $item): ?>
                    <a href="#" data-category="meals" class="group relative flex h-full flex-col overflow-hidden rounded-3xl bg-white/90 shadow ring-1 ring-[#D7A86E]/20 transition-all duration-300 hover:-translate-y-2 hover:shadow-lg hover:ring-[#C9964C]/30" style="text-decoration: none; color: inherit;">
                        <div class="relative overflow-hidden">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="aspect-4/5 w-full mt-9 object-contain transition duration-500 group-hover:scale-105" style="height: 350px; object-fit: contain;">
                        </div>
                        <div class="flex flex-1 flex-col p-6" style="display: flex; flex-direction: column; flex: 1; padding: 1.5rem;">
                            <h3 class="text-lg font-semibold text-[#2B1A12]" style="font-size: 1.125rem; font-weight: 600; color: #2B1A12;"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="mt-1 text-sm text-[#6F4E37]" style="margin-top: 0.25rem; font-size: 0.875rem; color: #6F4E37; line-height: 1.5;"><?php echo htmlspecialchars($item['desc']); ?></p>
                            <div class="mt-4 flex flex-wrap gap-2" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                <button class="price-option px-3 py-1 text-xs font-medium bg-[#FAF3E0] rounded-full hover:bg-[#E2D6C2]" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 500; background-color: #FAF3E0; border-radius: 9999px; border: none; cursor: pointer; transition: background 0.3s;">₱<?php echo $item['price']; ?></button>
                            </div>
                            <div class="mt-6 flex items-center gap-2 text-xs font-medium uppercase text-[#A37A58]" style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; font-weight: 500; text-transform: uppercase; color: #A37A58;">
                                <span class="flex items-center gap-1 text-[#C9964C]" style="display: flex; align-items: center; gap: 0.25rem; color: #C9964C;">★ 4.9</span>
                                <span>Hearty Meal</span>
                            </div>
                            <form method="POST" style="margin-top: 1.5rem;">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo $item['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($item['image']); ?>">
                                <button type="submit" name="add_to_cart" class="mt-6 inline-flex items-center justify-center gap-2 rounded-full bg-[#2B1A12] px-5 py-2 text-sm font-medium text-[#FAF3E0] transition hover:bg-[#1F120B] w-full" style="margin-top: 1.5rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 9999px; background-color: #2B1A12; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 500; color: #FAF3E0; border: none; cursor: pointer; transition: background 0.3s; width: 100%;">
                                    Add to Cart <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </a>
                <?php endforeach; ?>
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
                    <p class="footer-contact">⏰ Mon-Fri: 8:00 AM - 9:00 PM</p>
                    <p class="footer-contact">⏰ Sat-Sun: 9:00 AM - 10:00 PM</p>
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
    <div id="aboutModal" class="login-modal">
        <div class="login-modal-content about-modal-content">
            <button class="login-modal-close" onclick="closeAboutModal()">&times;</button>
            <div class="login-modal-header">
                <img src="images/logoo.png" alt="Logo" class="login-modal-logo">
                <h2>About The Malvar Bat Cave Cafe</h2>
                <p>Discover the story behind our late-night sanctuary for the BatStateU community.</p>
            </div>
            <div class="login-modal-body about-modal-body">
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
    <div id="termsModal" class="login-modal">
        <div class="login-modal-content terms-modal-content">
            <button class="login-modal-close" onclick="closeTermsModal()">&times;</button>
            <div class="login-modal-header">
                <img src="images/logoo.png" alt="Logo" class="login-modal-logo">
                <h2>Terms &amp; Conditions</h2>
                <p>Please review the terms and conditions for using The Malvar Bat Cave Cafe services.</p>
            </div>
            <div class="login-modal-body terms-modal-body">
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
    <div id="privacyModal" class="login-modal">
        <div class="login-modal-content privacy-modal-content">
            <button class="login-modal-close" onclick="closePrivacyModal()">&times;</button>
            <div class="login-modal-header">
                <img src="images/logoo.png" alt="Logo" class="login-modal-logo">
                <h2>Privacy Policy</h2>
                <p>Learn how The Malvar Bat Cave Café safeguards your data.</p>
            </div>
            <div class="login-modal-body privacy-modal-body">
                <div class="privacy-header">
                    <h1>Privacy Policy</h1>
                    <div class="cafe-name">The Malvar Bat Cave Café</div>
                    <div class="privacy-dates">
                        <strong>Effective Date:</strong> January 18, 2025<br>
                        <strong>Last Updated:</strong> January 18, 2025
                    </div>
                </div>
                <div class="privacy-intro">
                    The Malvar Bat Cave Café ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, store, and protect your personal information when you visit our café, make reservations, order for pickup, or use our services.<br><br>
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

        .about-modal-content,
        .terms-modal-content,
        .privacy-modal-content {
            max-height: 80vh;
            overflow-y: auto;
            max-width: 960px;
            width: min(960px, 95vw);
        }

        .about-modal-content,
        .terms-modal-content {
            max-height: 80vh;
            overflow-y: auto;
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

        .about-modal-body p {
            font-size: 14px;
            color: #6F4E37;
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .terms-modal-body h3 {
            margin-top: 10px;
            margin-bottom: 6px;
            font-size: 16px;
            color: #2B1A12;
        }

        .terms-modal-body p {
            font-size: 14px;
            color: #6F4E37;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .terms-last-updated {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            color: #C9964C;
        }

        .privacy-modal-body {
            color: #2B1A12;
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
            color: #6F4E37;
        }

        .privacy-dates {
            font-size: 14px;
            color: #6F4E37;
            margin-top: 10px;
            line-height: 1.6;
        }

        .privacy-intro {
            background: #FFF7ED;
            border-left: 4px solid #C9964C;
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
            color: #2B1A12;
        }

        .privacy-section h3 {
            font-size: 16px;
            margin: 12px 0 8px;
            color: #6F4E37;
        }

        .privacy-section p,
        .privacy-section ul {
            font-size: 14px;
            line-height: 1.5;
            color: #4A3728;
        }

        .privacy-section ul {
            padding-left: 20px;
        }

        .highlight-box {
            background: #FAF3E0;
            border: 1px solid #E5D4B5;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .hours-highlight {
            font-size: 20px;
            font-weight: 600;
            color: #C9964C;
            margin: 15px 0;
        }

        .contact-box {
            background: #FFF5E1;
            border: 1px solid #F0D7B4;
            border-radius: 12px;
            padding: 18px;
        }

        .about-modal-body p {
            font-size: 14px;
            color: #6F4E37;
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .terms-modal-body h3 {
            margin-top: 10px;
            margin-bottom: 6px;
            font-size: 16px;
            color: #2B1A12;
        }

        .terms-modal-body p {
            font-size: 14px;
            color: #6F4E37;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .terms-last-updated {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            color: #C9964C;
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

        body.dark-mode .login-modal-content {
            background: #2B1A12;
        }

        body.dark-mode .login-modal-header h2,
        body.dark-mode .login-option-content h3 {
            color: #FAF3E0;
        }

        body.dark-mode .login-modal-header p,
        body.dark-mode .login-option-content p,
        body.dark-mode .about-modal-body p,
        body.dark-mode .terms-modal-body p {
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

        body.dark-mode .terms-modal-body h3 {
            color: #FAF3E0;
        }

        body.dark-mode .terms-last-updated {
            color: #F4D7A1;
        }

        body.dark-mode .privacy-modal-body {
            color: #FAF3E0;
        }

        body.dark-mode .privacy-section h2 {
            color: #FAF3E0;
        }

        body.dark-mode .privacy-section h3,
        body.dark-mode .privacy-section p,
        body.dark-mode .privacy-section ul,
        body.dark-mode .privacy-dates,
        body.dark-mode .privacy-intro {
            color: #D4B896;
        }

        body.dark-mode .privacy-intro,
        body.dark-mode .highlight-box,
        body.dark-mode .contact-box {
            background: #2F2015;
            border-color: #5A3E24;
        }

        body.dark-mode .hours-highlight {
            color: #F4D7A1;
        }

        body.dark-mode .about-modal-body p,
        body.dark-mode .terms-modal-body p {
            color: #D4B896;
        }

        body.dark-mode .terms-modal-body h3 {
            color: #FAF3E0;
        }

        body.dark-mode .terms-last-updated {
            color: #F4D7A1;
        }
    </style>

    <script>
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

        // Close modal when clicking outside
        document.getElementById('loginModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeLoginModal();
            }
        });

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

        document.addEventListener('click', function(event) {
            const cartDropdown = document.querySelector('.cart-dropdown');
            const cartMenu = document.getElementById('cartMenu');

            if (!cartDropdown.contains(event.target)) {
                cartMenu.classList.remove('active');
            }
        });

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
            window.location.href = 'booking.php?from_cart=1';
        }

        // Pick Up For Later - go to cart page
        function pickUpLater() {
            window.location.href = 'cart.php';
        }

        // Category Filter Function
        function filterCategory(category) {
            const allItems = document.querySelectorAll('[data-category]');
            const filterBtns = document.querySelectorAll('.filter-btn');

            // Update active button
            filterBtns.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Show/hide items based on category
            allItems.forEach(item => {
                if (category === 'all') {
                    item.style.display = '';
                } else {
                    const itemCategories = item.getAttribute('data-category').split(' ');
                    if (itemCategories.includes(category)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        }

        // Size Selection Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sizeOptions = document.querySelectorAll('.size-option');

            sizeOptions.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Get the parent card container
                    const card = this.closest('.group');
                    const siblingButtons = card.querySelectorAll('.size-option');

                    // Remove active state from all size buttons in this card
                    siblingButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.style.backgroundColor = '#FAF3E0';
                        btn.style.color = '';
                    });

                    // Add active state to clicked button
                    this.classList.add('active');
                    this.style.backgroundColor = '#C9964C';
                    this.style.color = 'white';

                    // Update hidden form inputs
                    const form = card.querySelector('form');
                    const nameInput = form.querySelector('.product-name-input');
                    const priceInput = form.querySelector('.product-price-input');

                    const size = this.getAttribute('data-size');
                    const price = this.getAttribute('data-price');
                    const baseName = nameInput.value.replace(/ \(Short\)| \(Tall\)| \(Grande\)/g, '');

                    // Capitalize first letter of size
                    const sizeFormatted = size.charAt(0).toUpperCase() + size.slice(1);

                    nameInput.value = baseName + ' (' + sizeFormatted + ')';
                    priceInput.value = price;
                });
            });
        });
    </script>
</body>

</html>