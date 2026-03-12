<?php
session_start();

define('BASE_PATH', __DIR__);
define('BASE_URL', '/Ecommerce%20task');

require_once BASE_PATH . '/models/Database.php';
require_once BASE_PATH . '/controllers/HomeController.php';
require_once BASE_PATH . '/controllers/ProductController.php';
require_once BASE_PATH . '/controllers/AuthController.php';
require_once BASE_PATH . '/controllers/PageController.php';
require_once BASE_PATH . '/controllers/ContactController.php';
require_once BASE_PATH . '/controllers/SellerController.php';
require_once BASE_PATH . '/controllers/CustomerController.php';
require_once BASE_PATH . '/controllers/CartController.php';

$page = isset($_GET['page']) ? trim($_GET['page'], '/') : 'home';

switch ($page) {
    case '':
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'products':
        $controller = new ProductController();
        $controller->index();
        break;

    case (preg_match('/^product\/(.+)$/', $page, $matches) ? true : false):
        $controller = new ProductController();
        $controller->show($matches[1]);
        break;

    case 'login':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->loginPost();
        }
        else {
            $controller->login();
        }
        break;

    case 'register':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->registerPost();
        }
        else {
            $controller->register();
        }
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'about':
        $controller = new PageController();
        $controller->about();
        break;

    case 'seller':
        $controller = new SellerController();
        $controller->index();
        break;

    case 'seller/customer-history':
        require_once BASE_PATH . '/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->customerHistory();
        break;

    case 'seller/products':
        $controller = new SellerController();
        $controller->products();
        break;

    case 'seller/products/create':
        $controller = new SellerController();
        $controller->createProduct();
        break;

    case (preg_match('/^seller\/products\/edit\/(.+)$/', $page, $matches) ? true : false):
        $controller = new SellerController();
        $controller->editProduct($matches[1]);
        break;

    case 'seller/products/save':
        $controller = new SellerController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->saveProduct();
        }
        else {
            header('Location: ' . BASE_URL . '/seller/products');
            exit;
        }
        break;

    case 'seller/products/delete':
        $controller = new SellerController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->deleteProduct();
        }
        else {
            header('Location: ' . BASE_URL . '/seller/products');
            exit;
        }
        break;

    case 'account':
        $controller = new CustomerController();
        $controller->index();
        break;

    case 'cart':
        $controller = new CartController();
        $controller->index();
        break;

    case 'customer/wishlist':
        require_once BASE_PATH . '/controllers/WishlistController.php';
        $controller = new WishlistController();
        $controller->index();
        break;

    case 'wishlist/add':
        require_once BASE_PATH . '/controllers/WishlistController.php';
        $controller = new WishlistController();
        $controller->add();
        break;

    case 'wishlist/remove':
        require_once BASE_PATH . '/controllers/WishlistController.php';
        $controller = new WishlistController();
        $controller->remove();
        break;

    case 'cart/add':
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->add();
        }
        else {
            header('Location: ' . BASE_URL . '/products');
            exit;
        }
        break;

    case 'cart/update':
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update();
        }
        else {
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }
        break;

    case 'cart/remove':
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->remove();
        }
        else {
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }
        break;

    case 'cart/clear':
        $controller = new CartController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->clear();
        }
        else {
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }
        break;

    case 'contact':
        $controller = new ContactController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        }
        else {
            $controller->index();
        }
        break;

    case 'admin':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;

    case 'admin/users':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['user_id']) && isset($_POST['is_active'])) {
                $controller->updateUserStatus();
            }
            else {
                $controller->updateUserRole();
            }
        }
        else {
            $controller->users();
        }
        break;

    case 'admin/update-user-status':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->updateUserStatus();
        break;

    case 'admin/categories':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'add') {
                $controller->addCategory();
            }
            elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
                $controller->deleteCategory();
            }
            else {
                $controller->updateCategory();
            }
        }
        else {
            $controller->categories();
        }
        break;

    case (preg_match('/^admin\/seller\/(\d+)$/', $page, $matches) ? true : false):
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->sellerDetail($matches[1]);
        break;

    case 'admin/sellers':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->updateSellerStatus();
        }
        else {
            $controller->sellers();
        }
        break;

    // Checkout & Order Management Routes
    case 'checkout':
        require_once BASE_PATH . '/controllers/CheckoutController.php';
        $controller = new CheckoutController();
        $controller->index();
        break;

    case 'checkout/process':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once BASE_PATH . '/controllers/CheckoutController.php';
            $controller = new CheckoutController();
            $controller->process();
        }
        break;

    case 'order/success':
        require_once BASE_PATH . '/controllers/CheckoutController.php';
        $controller = new CheckoutController();
        $orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $controller->success($orderId);
        break;

    case 'customer/orders':
        require_once BASE_PATH . '/controllers/OrderController.php';
        $controller = new OrderController();
        $controller->history();
        break;

    case 'seller/orders':
        require_once BASE_PATH . '/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->orders();
        break;

    case (preg_match('/^seller\/order\/(\d+)$/', $page, $matches) ? true : false):
        require_once BASE_PATH . '/controllers/SellerController.php';
        $controller = new SellerController();
        $controller->orderDetail($matches[1]);
        break;

    case 'seller/orders/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once BASE_PATH . '/controllers/SellerController.php';
            $controller = new SellerController();
            $controller->updateOrderStatus();
        }
        break;

    case 'admin/orders':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->orders();
        break;

    case 'admin/orders/update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once BASE_PATH . '/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->updateOrderStatus();
        }
        break;

    default:
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
        break;


}
