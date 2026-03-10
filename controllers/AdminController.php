<?php
class AdminController
{
    private $db;

    public function __construct()
    {
        // Simple authentication and authorization check
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
        $this->db = Database::getInstance();
    }

    // Dashboard Overview
    public function index()
    {
        $stats = [
            'users' => $this->db->fetch("SELECT COUNT(*) as count FROM users")['count'],
            'products' => $this->db->fetch("SELECT COUNT(*) as count FROM products")['count'],
            'categories' => $this->db->fetch("SELECT COUNT(*) as count FROM categories")['count']
        ];

        $pageTitle = 'Admin Dashboard';
        $currentPage = 'admin/dashboard';
        require BASE_PATH . '/views/layouts/main.php';
    }

    // Manage Users
    public function users()
    {
        $users = $this->db->fetchAll("SELECT id, name, email, role, created_at, IFNULL(is_active, 1) as is_active FROM users ORDER BY created_at DESC");

        $pageTitle = 'Manage Users';
        $currentPage = 'admin/users';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function updateUserStatus()
    {
        $userId = $_POST['user_id'] ?? 0;
        $isActive = intval($_POST['is_active'] ?? 1);

        if ($userId && $userId != 1) { // Prevent modifying main admin
            // Check if is_active column exists, if not add it
            try {
                $this->db->query("UPDATE users SET is_active = ? WHERE id = ?", [$isActive, $userId], 'ii');
                $_SESSION['success'] = $isActive ? "User activated successfully!" : "User deactivated successfully!";
            } catch (Exception $e) {
                // Column might not exist, create it
                $this->db->query("ALTER TABLE users ADD COLUMN is_active TINYINT(1) DEFAULT 1 AFTER role");
                $this->db->query("UPDATE users SET is_active = ? WHERE id = ?", [$isActive, $userId], 'ii');
                $_SESSION['success'] = $isActive ? "User activated successfully!" : "User deactivated successfully!";
            }
        } else {
            $_SESSION['error'] = "Cannot modify this user.";
        }

        header('Location: ' . BASE_URL . '/admin/users');
        exit;
    }

    public function updateUserRole()
    {
        $userId = $_POST['user_id'] ?? 0;
        $newRole = $_POST['role'] ?? 'customer';
        $validRoles = ['admin', 'seller', 'customer'];

        if ($userId && in_array($newRole, $validRoles)) {
            // Prevent changing the main admin's role
            if ($userId != 1) {
                $this->db->query("UPDATE users SET role = ? WHERE id = ?", [$newRole, $userId], 'si');
            }
        }
        header('Location: ' . BASE_URL . '/admin/users');
        exit;
    }

    // Manage Categories
    public function categories()
    {
        $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");

        $pageTitle = 'Manage Categories';
        $currentPage = 'admin/categories';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function addCategory()
    {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['category_url_name'] ?? '');

        if (!empty($name) && !empty($slug)) {
            // Check if slug exists
            $exists = $this->db->fetch("SELECT id FROM categories WHERE category_url_name = ?", [$slug]);
            if (!$exists) {
                $this->db->insert("INSERT INTO categories (name, category_url_name) VALUES (?, ?)", [$name, $slug]);
            }
        }
        header('Location: ' . BASE_URL . '/admin/categories');
        exit;
    }

    public function updateCategory()
    {
        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['category_url_name'] ?? '');

        if ($id && !empty($name) && !empty($slug)) {
            $this->db->query("UPDATE categories SET name = ?, category_url_name = ? WHERE id = ?", [$name, $slug, $id], 'ssi');
        }
        header('Location: ' . BASE_URL . '/admin/categories');
        exit;
    }

    public function deleteCategory()
    {
        $id = $_POST['id'] ?? 0;
        if ($id) {
            // Check if there are products in this category before deleting
            $productsCount = $this->db->fetch("SELECT COUNT(*) as count FROM products WHERE category_id = ?", [$id], 'i')['count'];

            if ($productsCount == 0) {
                $this->db->query("DELETE FROM categories WHERE id = ?", [$id], 'i');
            } else {
                $_SESSION['error'] = "Cannot delete category: it still contains products.";
            }
        }
        header('Location: ' . BASE_URL . '/admin/categories');
        exit;
    }

    // Seller Management
    public function sellers()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        if (!empty($search)) {
            $sellers = $this->db->fetchAll(
                "SELECT id, name, email, role, created_at, IFNULL(is_active, 1) as is_active, IFNULL(seller_status, 'pending') as seller_status FROM users WHERE role = 'seller' AND (name LIKE ? OR email LIKE ?) ORDER BY created_at DESC",
                ["%{$search}%", "%{$search}%"]
            );
        } else {
            $sellers = $this->db->fetchAll(
                "SELECT id, name, email, role, created_at, IFNULL(is_active, 1) as is_active, IFNULL(seller_status, 'pending') as seller_status FROM users WHERE role = 'seller' ORDER BY created_at DESC"
            );
        }

        $pageTitle = 'Seller Management';
        $currentPage = 'admin/sellers';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function updateSellerStatus()
    {
        $sellerId = $_POST['seller_id'] ?? 0;
        $action = $_POST['action'] ?? '';

        if (!$sellerId) {
            $_SESSION['error'] = "Invalid seller.";
            header('Location: ' . BASE_URL . '/admin/sellers');
            exit;
        }

        switch ($action) {
            case 'approve':
                $this->db->query("UPDATE users SET seller_status = 'active', is_active = 1 WHERE id = ? AND role = 'seller'", [$sellerId], 'i');
                $_SESSION['success'] = "Seller approved successfully!";
                break;
            case 'disable':
                $this->db->query("UPDATE users SET seller_status = 'disabled', is_active = 0 WHERE id = ? AND role = 'seller'", [$sellerId], 'i');
                $_SESSION['success'] = "Seller disabled successfully!";
                break;
            case 'delete':
                $this->db->query("DELETE FROM users WHERE id = ? AND role = 'seller'", [$sellerId], 'i');
                $_SESSION['success'] = "Seller deleted successfully!";
                break;
            default:
                $_SESSION['error'] = "Invalid action.";
        }

        header('Location: ' . BASE_URL . '/admin/sellers');
        exit;
    }

    // Seller Detail
    public function sellerDetail($id)
    {
        $seller = $this->db->fetch(
            "SELECT id, name, email, role, created_at, IFNULL(is_active, 1) as is_active, IFNULL(seller_status, 'pending') as seller_status FROM users WHERE id = ? AND role = 'seller'",
            [$id],
            'i'
        );

        if (!$seller) {
            $_SESSION['error'] = "Seller not found.";
            header('Location: ' . BASE_URL . '/admin/sellers');
            exit;
        }

        $sellerProducts = $this->db->fetchAll(
            "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.seller_id = ? ORDER BY p.created_at DESC",
            [$id],
            'i'
        );

        $pageTitle = 'Seller Details - ' . $seller['name'];
        $currentPage = 'admin/seller-detail';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function orders()
    {
        // Admins can see ALL orders and their nested items.
        // We'll fetch orders first, then attach items to them similar to Customer view but globally.
        $orders = $this->db->fetchAll(
            "SELECT o.*, u.name as customer_name, u.email as customer_email,
                    sa.full_name as shipping_name, sa.city, sa.state
             FROM orders o
             JOIN users u ON o.user_id = u.id
             JOIN shipping_addresses sa ON o.shipping_address_id = sa.id
             ORDER BY o.created_at DESC"
        );

        foreach ($orders as &$order) {
            $order['items'] = $this->db->fetchAll(
                "SELECT oi.*, p.name as product_name, p.image,
                        s.name as seller_name
                 FROM order_items oi
                 JOIN products p ON oi.product_id = p.id
                 JOIN users s ON oi.seller_id = s.id
                 WHERE oi.order_id = ?",
                [$order['id']]
            );
        }

        $pageTitle = 'Manage Orders';
        $currentPage = 'admin/orders';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function updateOrderStatus()
    {
        $orderId = $_POST['order_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if ($orderId && in_array($status, $validStatuses)) {
            // Admin updates the TOP LEVEL order status
            $this->db->query(
                "UPDATE orders SET order_status = ? WHERE id = ?",
                [$status, $orderId]
            );
            
            // Auto-update the items globally if admin forces a change
            $this->db->query(
                "UPDATE order_items SET item_status = ? WHERE order_id = ?",
                [$status, $orderId]
            );
            
            $_SESSION['success'] = "Order #$orderId global status updated to " . ucfirst($status) . ".";
        } else {
            $_SESSION['error'] = "Invalid status update requested.";
        }
        
        header('Location: ' . BASE_URL . '/admin/orders');
        exit;
    }
}
