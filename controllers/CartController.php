<?php
class CartController
{
    private $db;
    private $userId;

    public function __construct()
    {
        $this->db = Database::getInstance();
        // For logged-in users, use user_id; for guests, we'll handle in add() method
        if (isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
        }
    }

    // Display cart page
    public function index()
    {
        // Guest user - show session cart
        if (!isset($_SESSION['user_id'])) {
            $cartItems = [];
            $total = 0;
            
            if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
                $productIds = array_keys($_SESSION['guest_cart']);
                $placeholders = implode(',', array_fill(0, count($productIds), '?'));
                
                $db = Database::getInstance();
                $products = $db->fetchAll(
                    "SELECT * FROM products WHERE id IN ($placeholders)",
                    $productIds
                );
                
                foreach ($products as $product) {
                    $quantity = $_SESSION['guest_cart'][$product['id']];
                    $price = $product['sale_price'] ?? $product['price'];
                    $cartItems[] = [
                        'id' => 0,
                        'product_id' => $product['id'],
                        'quantity' => $quantity,
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'sale_price' => $product['sale_price'],
                        'image' => $product['image'],
                        'slug' => $product['slug'],
                        'stock' => $product['stock']
                    ];
                    $total += $price * $quantity;
                }
            }
            
            $pageTitle = 'Shopping Cart';
            $currentPage = 'cart';
            require BASE_PATH . '/views/layouts/main.php';
            return;
        }
        
        // Logged-in user - show database cart
        $this->userId = $_SESSION['user_id'];
        
        $cartItems = $this->db->fetchAll(
            "SELECT c.*, p.name, p.price, p.sale_price, p.image, p.slug, p.stock 
             FROM cart c 
             LEFT JOIN products p ON c.product_id = p.id 
             WHERE c.user_id = ? 
             ORDER BY c.added_at DESC",
            [$this->userId]
        );

        $total = 0;
        foreach ($cartItems as $item) {
            $price = $item['sale_price'] ?? $item['price'];
            $total += $price * $item['quantity'];
        }

        $pageTitle = 'Shopping Cart';
        $currentPage = 'cart';
        require BASE_PATH . '/views/layouts/main.php';
    }

    // Add item to cart
    public function add()
    {
        $productId = $_POST['product_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$productId || $quantity < 1) {
            $_SESSION['error'] = "Invalid product or quantity.";
            header('Location: ' . BASE_URL . '/products');
            exit;
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Guest user - store cart in session temporarily
            if (!isset($_SESSION['guest_cart'])) {
                $_SESSION['guest_cart'] = [];
            }
            
            // Add to guest cart
            if (isset($_SESSION['guest_cart'][$productId])) {
                $_SESSION['guest_cart'][$productId] += $quantity;
            } else {
                $_SESSION['guest_cart'][$productId] = $quantity;
            }
            
            $_SESSION['success'] = "Product added to cart!";
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }
        
        // Logged-in user - use database
        $this->userId = $_SESSION['user_id'];

        // Check if product exists and is in stock
        $product = $this->db->fetch("SELECT * FROM products WHERE id = ?", [$productId]);
        
        if (!$product) {
            $_SESSION['error'] = "Product not found.";
            header('Location: ' . BASE_URL . '/products');
            exit;
        }

        if ($product['stock'] < $quantity) {
            $_SESSION['error'] = "Not enough stock available.";
            header('Location: ' . BASE_URL . '/product/' . $product['slug']);
            exit;
        }

        // Check if item already in cart
        $existing = $this->db->fetch(
            "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?",
            [$this->userId, $productId]
        );

        if ($existing) {
            // Update quantity
            $newQuantity = $existing['quantity'] + $quantity;
            
            // Check stock limit
            if ($newQuantity > $product['stock']) {
                $_SESSION['error'] = "Cannot add more than available stock.";
                header('Location: ' . BASE_URL . '/product/' . $product['slug']);
                exit;
            }
            
            $this->db->query(
                "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?",
                [$newQuantity, $this->userId, $productId]
            );
        } else {
            // Add new item
            $this->db->insert(
                "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)",
                [$this->userId, $productId, $quantity]
            );
        }

        $_SESSION['success'] = "Product added to cart!";
        
        // Redirect back if came from product detail, otherwise to cart
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'product/') !== false) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: ' . BASE_URL . '/cart');
        }
        exit;
    }

    // Update cart item quantity
    public function update()
    {
        // Guest user - update session cart
        if (!isset($_SESSION['user_id'])) {
            $productId = $_POST['cart_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            
            if (!$productId || !isset($_SESSION['guest_cart'][$productId])) {
                $_SESSION['error'] = "Invalid request.";
                header('Location: ' . BASE_URL . '/cart');
                exit;
            }
            
            if ($quantity == 0) {
                // Remove item from guest cart
                unset($_SESSION['guest_cart'][$productId]);
                $_SESSION['success'] = "Item removed from cart.";
            } else {
                // Update quantity in guest cart
                $_SESSION['guest_cart'][$productId] = $quantity;
                $_SESSION['success'] = "Cart updated.";
            }
            
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }
        
        // Logged-in user - use database
        $this->userId = $_SESSION['user_id'];
        $cartId = $_POST['cart_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$cartId || $quantity < 0) {
            $_SESSION['error'] = "Invalid request.";
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }

        if ($quantity == 0) {
            // Remove item
            $this->db->query("DELETE FROM cart WHERE id = ? AND user_id = ?", [$cartId, $this->userId]);
            $_SESSION['success'] = "Item removed from cart.";
        } else {
            // Check stock
            $cartItem = $this->db->fetch(
                "SELECT c.*, p.stock FROM cart c 
                 LEFT JOIN products p ON c.product_id = p.id 
                 WHERE c.id = ? AND c.user_id = ?",
                [$cartId, $this->userId]
            );

            if (!$cartItem) {
                $_SESSION['error'] = "Cart item not found.";
                header('Location: ' . BASE_URL . '/cart');
                exit;
            }

            if ($quantity > $cartItem['stock']) {
                $_SESSION['error'] = "Only {$cartItem['stock']} items available in stock.";
                header('Location: ' . BASE_URL . '/cart');
                exit;
            }

            $this->db->query(
                "UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?",
                [$quantity, $cartId, $this->userId]
            );
            $_SESSION['success'] = "Cart updated.";
        }

        header('Location: ' . BASE_URL . '/cart');
        exit;
    }

    // Remove item from cart
    public function remove()
    {
        // Guest user - remove from session cart
        if (!isset($_SESSION['user_id'])) {
            $productId = $_POST['cart_id'] ?? 0;
            
            if ($productId && isset($_SESSION['guest_cart'][$productId])) {
                unset($_SESSION['guest_cart'][$productId]);
                $_SESSION['success'] = "Item removed from cart.";
            }
            
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }
        
        // Logged-in user - use database
        $cartId = $_POST['cart_id'] ?? 0;

        if ($cartId) {
            $this->db->query("DELETE FROM cart WHERE id = ? AND user_id = ?", [$cartId, $this->userId]);
            $_SESSION['success'] = "Item removed from cart.";
        }

        header('Location: ' . BASE_URL . '/cart');
        exit;
    }

    // Clear entire cart
    public function clear()
    {
        // Guest user - clear session cart
        if (!isset($_SESSION['user_id'])) {
            unset($_SESSION['guest_cart']);
            $_SESSION['success'] = "Cart cleared.";
            header('Location: ' . BASE_URL . '/cart');
            exit;
        }
        
        // Logged-in user - use database
        $this->db->query("DELETE FROM cart WHERE user_id = ?", [$this->userId]);
        $_SESSION['success'] = "Cart cleared.";
        header('Location: ' . BASE_URL . '/cart');
        exit;
    }

    // Get cart count for navbar
    public static function getCartCount()
    {
        // Guest user - count session cart items
        if (!isset($_SESSION['user_id'])) {
            if (isset($_SESSION['guest_cart'])) {
                return array_sum($_SESSION['guest_cart']);
            }
            return 0;
        }
        
        // Logged-in user - count database cart items
        $db = Database::getInstance();
        $result = $db->fetch(
            "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?",
            [$_SESSION['user_id']]
        );
        
        return $result['total'] ?? 0;
    }
}
