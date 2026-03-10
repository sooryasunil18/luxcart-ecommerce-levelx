<?php

class OrderController
{
    private $db;
    private $userId;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['customer', 'seller', 'admin'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->db = Database::getInstance();
        $this->userId = $_SESSION['user_id'];
    }

    public function history()
    {
        // Fetch all orders for this user, ordered by newest first
        $orders = $this->db->fetchAll(
            "SELECT o.*, sa.full_name, sa.city 
             FROM orders o 
             JOIN shipping_addresses sa ON o.shipping_address_id = sa.id 
             WHERE o.user_id = ? 
             ORDER BY o.created_at DESC",
            [$this->userId]
        );

        // For each order, fetch its items so we can show a rich summary
        foreach ($orders as &$order) {
            $order['items'] = $this->db->fetchAll(
                "SELECT oi.*, p.name as product_name, p.image, p.slug 
                 FROM order_items oi 
                 JOIN products p ON oi.product_id = p.id 
                 WHERE oi.order_id = ?",
                [$order['id']]
            );
        }

        $pageTitle = 'My Orders';
        $currentPage = 'customer/orders';
        require BASE_PATH . '/views/layouts/main.php';
    }
}
