<?php
class CustomerController
{
    private $db;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $this->db = Database::getInstance();
    }

    public function index()
    {
        $products = $this->db->fetchAll(
            "SELECT p.*, c.name as category_name 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.featured = 1 
             LIMIT 8"
        );

        $pageTitle = 'My Account';
        $currentPage = 'customer/dashboard';
        require BASE_PATH . '/views/layouts/main.php';
    }
}
