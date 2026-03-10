<?php
class SellerController
{
    private $db;
    private $sellerId;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'seller') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->db = Database::getInstance();
        $this->sellerId = $_SESSION['user_id'];
    }

    public function index()
    {
        // Fetch seller stats
        $stats = [
            'products' => $this->db->fetch("SELECT COUNT(*) as count FROM products WHERE seller_id = ?", [$this->sellerId])['count'],
            'active_products' => $this->db->fetch("SELECT COUNT(*) as count FROM products WHERE seller_id = ? AND stock > 0", [$this->sellerId])['count']
        ];

        // Fetch recent products
        $recentProducts = $this->db->fetchAll(
            "SELECT p.*, c.name as category_name 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.seller_id = ? 
             ORDER BY p.created_at DESC LIMIT 5",
            [$this->sellerId]
        );


        $pageTitle = 'Seller Dashboard';
        $currentPage = 'seller/dashboard';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function products()
    {
        $products = $this->db->fetchAll(
            "SELECT p.*, c.name as category_name 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.seller_id = ? 
             ORDER BY p.created_at DESC",
            [$this->sellerId]
        );

        $pageTitle = 'My Products';
        $currentPage = 'seller/products';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function createProduct()
    {
        $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");

        $product = [
            'id' => '',
            'name' => '',
            'slug' => '',
            'category_id' => '',
            'description' => '',
            'price' => '',
            'sale_price' => '',
            'stock' => '',
            'image' => ''
        ];
        $isEdit = false;

        $pageTitle = 'Add New Product';
        $currentPage = 'seller/product-form';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function editProduct($id)
    {
        $product = $this->db->fetch("SELECT * FROM products WHERE id = ? AND seller_id = ?", [$id, $this->sellerId]);

        if (!$product) {
            header('Location: ' . BASE_URL . '/seller/products');
            exit;
        }

        $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
        $isEdit = true;

        $pageTitle = 'Edit Product';
        $currentPage = 'seller/product-form';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function saveProduct()
    {
        $id = $_POST['id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $category_id = $_POST['category_id'] ?? 0;
        $description = trim($_POST['description'] ?? '');
        $price = $_POST['price'] ?? 0;
        $sale_price = !empty($_POST['sale_price']) ? $_POST['sale_price'] : null;
        $stock = $_POST['stock'] ?? 0;

        // Basic validation
        if (empty($name) || empty($slug) || empty($category_id) || empty($price)) {
            $_SESSION['error'] = "Please fill in all required fields.";
            header('Location: ' . BASE_URL . ($id ? "/seller/products/edit/$id" : "/seller/products/create"));
            exit;
        }

        // Handle image upload
        $image = trim($_POST['old_image'] ?? ''); // Default to old image

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/images/';

            // Create dir if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($_FILES['image']['name']);
            // Sanitize file name (remove spaces and special chars, keep dots)
            $cleanFileName = preg_replace('/[^A-Za-z0-9\.\-]/', '_', $fileName);
            // Ensure uniqueness
            $finalFileName = time() . '_' . $cleanFileName;
            $uploadPath = $uploadDir . $finalFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $image = $finalFileName;
            } else {
                $_SESSION['error'] = "Failed to upload image.";
                header('Location: ' . BASE_URL . ($id ? "/seller/products/edit/$id" : "/seller/products/create"));
                exit;
            }
        }

        if ($id) {
            // Update
            $this->db->query(
                "UPDATE products SET name=?, slug=?, category_id=?, description=?, price=?, sale_price=?, stock=?, image=? WHERE id=? AND seller_id=?",
                [$name, $slug, $category_id, $description, $price, $sale_price, $stock, $image, $id, $this->sellerId]
            );
            $_SESSION['success'] = "Product updated successfully!";
        } else {
            // Insert
            $this->db->insert(
                "INSERT INTO products (seller_id, name, slug, category_id, description, price, sale_price, stock, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [$this->sellerId, $name, $slug, $category_id, $description, $price, $sale_price, $stock, $image]
            );
            $_SESSION['success'] = "Product created successfully!";
        }

        header('Location: ' . BASE_URL . '/seller/products');
        exit;
    }

    public function deleteProduct()
    {
        $id = $_POST['id'] ?? 0;

        if ($id) {
            $this->db->query("DELETE FROM products WHERE id = ? AND seller_id = ?", [$id, $this->sellerId]);
            $_SESSION['success'] = "Product deleted successfully.";
        }

        header('Location: ' . BASE_URL . '/seller/products');
        exit;
    }

    public function customerHistory()
    {
        $historyData = $this->db->fetchAll(
            "SELECT 
                'Order Placed' as action_type,
                p.name as product_name,
                u.name as customer_name,
                u.email as customer_email,
                o.created_at as added_at,
                o.payment_method,
                o.payment_status
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            JOIN users u ON o.user_id = u.id
            WHERE oi.seller_id = ?
            
            UNION ALL
            
            SELECT 
                'Cart' as action_type,
                p.name as product_name,
                u.name as customer_name,
                u.email as customer_email,
                c.added_at,
                NULL as payment_method,
                NULL as payment_status
            FROM cart c
            JOIN products p ON c.product_id = p.id
            JOIN users u ON c.user_id = u.id
            WHERE p.seller_id = ?
            
            UNION ALL
            
            SELECT 
                'Wishlist' as action_type,
                p.name as product_name,
                u.name as customer_name,
                u.email as customer_email,
                w.added_at,
                NULL as payment_method,
                NULL as payment_status
            FROM wishlist w
            JOIN products p ON w.product_id = p.id
            JOIN users u ON w.user_id = u.id
            WHERE p.seller_id = ?
            
            ORDER BY added_at DESC",
            [$this->sellerId, $this->sellerId, $this->sellerId],
            'iii'
        );

        $pageTitle = 'Customer History';
        $currentPage = 'seller/customer-history';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function orders()
    {
        // Fetch all order items that belong to this seller specifically
        $orders = $this->db->fetchAll(
            "SELECT oi.*, p.name as product_name, p.image, p.price as current_price, 
                    o.total_amount, o.payment_method, o.payment_status, o.razorpay_payment_id, o.created_at as order_date,
                    u.name as customer_name, u.email as customer_email,
                    sa.full_name as shipping_name, sa.phone, sa.address, sa.city, sa.state, sa.pincode
             FROM order_items oi
             JOIN orders o ON oi.order_id = o.id
             JOIN products p ON oi.product_id = p.id
             JOIN users u ON o.user_id = u.id
             JOIN shipping_addresses sa ON o.shipping_address_id = sa.id
             WHERE oi.seller_id = ?
             ORDER BY o.created_at DESC",
            [$this->sellerId]
        );

        $pageTitle = 'Orders Received';
        $currentPage = 'seller/orders';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function updateOrderStatus()
    {
        $itemId = $_POST['item_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if ($itemId && in_array($status, $validStatuses)) {
            // Verify this item belongs to this seller before updating!
            $this->db->query(
                "UPDATE order_items SET item_status = ? WHERE id = ? AND seller_id = ?",
                [$status, $itemId, $this->sellerId]
            );
            $_SESSION['success'] = "Order status updated to " . ucfirst($status) . ".";
        } else {
            $_SESSION['error'] = "Invalid status update requested.";
        }
        
        header('Location: ' . BASE_URL . '/seller/orders');
        exit;
    }
}
