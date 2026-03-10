<?php

class CheckoutController
{
    private $db;
    private $userId;

    public function __construct()
    {
        // FORCE LOGIN: Immediately kick guests out if they somehow guess the URL!
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['customer', 'seller', 'admin'])) {
            $_SESSION['error'] = "You must be logged in to checkout.";
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->db = Database::getInstance();
        $this->userId = $_SESSION['user_id'];
    }

    public function index()
    {
        // 1. Fetch user's cart
        $cartItems = $this->db->fetchAll(
            "SELECT c.*, p.name, p.price, p.sale_price, p.image, p.stock, p.slug 
             FROM cart c 
             JOIN products p ON c.product_id = p.id 
             WHERE c.user_id = ?",
            [$this->userId]
        );

        if (empty($cartItems)) {
            $_SESSION['error'] = "Your cart is empty. Please add items to checkout.";
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        // Calculate total
        $total = 0;
        foreach ($cartItems as $item) {
            $price = $item['sale_price'] ?? $item['price'];
            $total += $price * $item['quantity'];
            
            // Safety check: is stock still available?
            if ($item['quantity'] > $item['stock']) {
                $_SESSION['error'] = "Sorry, '{$item['name']}' only has {$item['stock']} left in stock. Please update your cart.";
                header('Location: ' . BASE_URL . '/cart');
                exit;
            }
        }

        // 2. Fetch user's last shipping address if they have one (auto-fill)
        $lastAddress = $this->db->fetch(
            "SELECT * FROM shipping_addresses WHERE user_id = ? ORDER BY created_at DESC LIMIT 1",
            [$this->userId]
        );

        $pageTitle = 'Secure Checkout';
        $currentPage = 'checkout'; // We will create this view next!
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function process()
    {
        // 1. Validate inputs
        $fullName = trim($_POST['full_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? '');
        $pincode = trim($_POST['pincode'] ?? '');
        
        if (empty($fullName) || empty($phone) || empty($address) || empty($city) || empty($state) || empty($pincode)) {
            $_SESSION['error'] = "Please fill in all shipping address fields.";
            header('Location: ' . BASE_URL . '/checkout');
            exit;
        }

        // 2. Double check cart isn't empty and calculate final total
        $cartItems = $this->db->fetchAll(
            "SELECT c.*, p.price, p.sale_price, p.stock, p.seller_id, p.name 
             FROM cart c 
             JOIN products p ON c.product_id = p.id 
             WHERE c.user_id = ?",
            [$this->userId]
        );

        if (empty($cartItems)) {
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $price = $item['sale_price'] ?? $item['price'];
            $totalAmount += $price * $item['quantity'];
            
            if ($item['quantity'] > $item['stock']) {
                $_SESSION['error'] = "Sorry, '{$item['name']}' just went out of stock! Only {$item['stock']} left.";
                header('Location: ' . BASE_URL . '/cart');
                exit;
            }
        }

        // 3. Payment Method Validation
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $razorpayPaymentId = $_POST['razorpay_payment_id'] ?? null;

        if (!in_array($paymentMethod, ['cod', 'razorpay'])) {
            $paymentMethod = 'cod';
        }

        $paymentStatus = ($paymentMethod === 'razorpay' && !empty($razorpayPaymentId)) ? 'paid' : 'pending';

        // --- Begin Checkout Database Transactions ---
        
        try {
            // A. Save the shipping address
            $this->db->insert(
                "INSERT INTO shipping_addresses (user_id, full_name, phone, address, city, state, pincode) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$this->userId, $fullName, $phone, $address, $city, $state, $pincode]
            );
            $addressId = $this->db->getInstance()->getConnection()->insert_id;

            // B. Create the massive Order wrapper
            $this->db->insert(
                "INSERT INTO orders (user_id, shipping_address_id, total_amount, payment_method, payment_status, razorpay_payment_id) VALUES (?, ?, ?, ?, ?, ?)",
                [$this->userId, $addressId, $totalAmount, $paymentMethod, $paymentStatus, $razorpayPaymentId]
            );
            $orderId = $this->db->getInstance()->getConnection()->insert_id;

            // C. Insert each individual item & decrement stock!
            foreach ($cartItems as $item) {
                $price = $item['sale_price'] ?? $item['price'];
                
                // Add to order_items
                $this->db->insert(
                    "INSERT INTO order_items (order_id, product_id, seller_id, quantity, price) VALUES (?, ?, ?, ?, ?)",
                    [$orderId, $item['product_id'], $item['seller_id'], $item['quantity'], $price]
                );
                
                // DECREMENT STOCK
                $newStock = $item['stock'] - $item['quantity'];
                $this->db->query(
                    "UPDATE products SET stock = ? WHERE id = ?",
                    [$newStock, $item['product_id']]
                );
            }

            // D. Wipe the user's cart!
            $this->db->query("DELETE FROM cart WHERE user_id = ?", [$this->userId]);

            // Success! Send to confirmation page
            header('Location: ' . BASE_URL . '/order/success?id=' . $orderId);
            exit;

        } catch (Exception $e) {
            // If anything fails in the queries
            $_SESSION['error'] = "Something went wrong processing your order. Please try again.";
            header('Location: ' . BASE_URL . '/checkout');
            exit;
        }
    }

    public function success($orderId)
    {
        // Verify this order belongs to THIS user securely
        $order = $this->db->fetch(
            "SELECT * FROM orders WHERE id = ? AND user_id = ?", 
            [$orderId, $this->userId]
        );

        if (!$order) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $pageTitle = 'Order Successful!';
        $currentPage = 'checkout-success'; // Fixing this string to match naming convention later 
        require BASE_PATH . '/views/layouts/main.php';
    }
}
