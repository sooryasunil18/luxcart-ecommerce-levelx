<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - LuxeCart' : 'LuxeCart - Online Store' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="<?= BASE_URL ?>/" class="logo">
                <i class="fas fa-shopping-bag logo-icon"></i>
                <span class="logo-text">Luxe<span class="logo-accent">Cart</span></span>
            </a>
            <div class="nav-links" id="navLinks">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <!-- Admin Navigation -->
                    <a href="<?= BASE_URL ?>/admin"
                        class="<?= strpos($currentPage ?? '', 'admin') === 0 && ($currentPage ?? '') !== 'admin/orders' ? 'active' : '' ?>">Dashboard</a>
                    <a href="<?= BASE_URL ?>/admin/users"
                        class="<?= ($currentPage ?? '') === 'admin/users' ? 'active' : '' ?>">Users</a>
                    <a href="<?= BASE_URL ?>/admin/categories"
                        class="<?= ($currentPage ?? '') === 'admin/categories' ? 'active' : '' ?>">Categories</a>
                    <a href="<?= BASE_URL ?>/admin/orders"
                        class="<?= ($currentPage ?? '') === 'admin/orders' ? 'active' : '' ?>">Manage Orders</a>
                    <a href="<?= BASE_URL ?>/products"
                        class="<?= ($currentPage ?? '') === 'products' ? 'active' : '' ?>">All Products</a>
                <?php else: ?>
                    <?php if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['customer', 'seller'])): ?>
                        <!-- Regular User Navigation -->
                        <a href="<?= BASE_URL ?>/" class="<?= ($currentPage ?? '') === 'home' ? 'active' : '' ?>">Home</a>
                        <a href="<?= BASE_URL ?>/products"
                            class="<?= ($currentPage ?? '') === 'products' ? 'active' : '' ?>">Products</a>
                        <a href="<?= BASE_URL ?>/about"
                            class="<?= ($currentPage ?? '') === 'about' ? 'active' : '' ?>">About</a>
                        <a href="<?= BASE_URL ?>/contact"
                            class="<?= ($currentPage ?? '') === 'contact' ? 'active' : '' ?>">Contact</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="nav-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="<?= BASE_URL ?>/admin" class="btn btn-sm btn-outline"><i class="fas fa-hammer"></i> Admin
                            Panel</a>
                    <?php elseif ($_SESSION['user_role'] === 'seller'): ?>
                        <a href="<?= BASE_URL ?>/seller" class="btn btn-sm btn-outline"><i class="fas fa-store"></i> Seller
                            Panel</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/account" class="btn btn-sm btn-outline"><i class="fas fa-user-circle"></i> My
                            Account</a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/logout" class="btn btn-sm btn-outline">Logout</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/login" class="btn btn-sm btn-outline" style="margin-right: 8px;">Login</a>
                    <a href="<?= BASE_URL ?>/register" class="btn btn-sm btn-primary">Register</a>
                <?php endif; ?>
                <?php if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'seller'])): ?>
                    <?php
                    if (!class_exists('WishlistController')) {
                        require_once BASE_PATH . '/controllers/WishlistController.php';
                    }
                    $wishlistUrl = isset($_SESSION['user_id']) ? BASE_URL . '/customer/wishlist' : BASE_URL . '/#guest-wishlist';
                    ?>
                    <a href="<?= $wishlistUrl ?>" class="nav-action-btn"
                        style="text-decoration: none; margin-right: 5px;">
                        <i class="far fa-heart"></i>
                        <span class="cart-count"
                            style="background: #f43f5e;"><?= WishlistController::getWishlistCount() ?></span>
                    </a>
                    <a href="<?= BASE_URL ?>/cart" class="nav-action-btn" style="text-decoration: none;">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?= \CartController::getCartCount() ?></span>
                    </a>
                <?php endif; ?>
                <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <?php
    $validViews = [
        'home',
        'products',
        'product-detail',
        'login',
        'register',
        'about',
        'contact',
        'admin/dashboard',
        'admin/users',
        'admin/categories',
        'admin/sellers',
        'admin/seller-detail',
        'seller/dashboard',
        'seller/products',
        'seller/customer-history',
        'seller/product-form',
        'customer/dashboard',
        'customer/wishlist',
        'cart',
        'checkout',
        'checkout-success',
        'customer/orders',
        'seller/orders',
        'seller/order-detail',
        'admin/orders'
    ];
    $current = $currentPage ?? 'home';
    if (in_array($current, $validViews)) {
        require BASE_PATH . '/views/' . $current . '.php';
    } else {
        echo '<h1>404 - View Not Found</h1>';
    }
    ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <div>
                        <div class="footer-logo">
                            <i class="fas fa-shopping-bag logo-icon"></i>
                            <span class="logo-text">LuxeCart</span>
                        </div>
                        <p class="footer-about">Your one-stop shop for Electronics and Fashion. Quality products at
                            great prices.</p>
                    </div>
                    <div class="footer-col">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="<?= BASE_URL ?>/">Home</a></li>
                            <li><a href="<?= BASE_URL ?>/products">Products</a></li>
                            <li><a href="<?= BASE_URL ?>/about">About</a></li>
                            <li><a href="<?= BASE_URL ?>/contact">Contact</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Categories</h4>
                        <ul>
                            <li><a href="<?= BASE_URL ?>/products?category=electronics">Electronics</a></li>
                            <li><a href="<?= BASE_URL ?>/products?category=fashion">Fashion</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Contact</h4>
                        <div class="footer-contact-info">
                            <p><i class="fas fa-map-marker-alt"></i> 123 MG Road, Mumbai, Maharashtra 400001</p>
                            <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                            <p><i class="fas fa-envelope"></i> support@luxecart.in</p>
                            <p><i class="fas fa-clock"></i> Mon-Sat: 9AM - 8PM IST</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2026 LuxeCart. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scroll Top Button -->
    <button class="scroll-top" id="scrollTop"><i class="fas fa-arrow-up"></i></button>

    <script src="<?= BASE_URL ?>/public/js/main.js"></script>
</body>

</html>