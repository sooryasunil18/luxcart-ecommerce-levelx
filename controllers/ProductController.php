<?php
class ProductController
{
    public function index()
    {
        $db = Database::getInstance();

        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
        $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $where = "WHERE 1=1";
        $params = [];

        if ($categoryFilter) {
            $where .= " AND c.category_url_name = ?";
            $params[] = $categoryFilter;
        }

        if ($search) {
            $where .= " AND (p.name LIKE ? OR p.description LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $orderBy = "ORDER BY p.created_at DESC";
        switch ($sortBy) {
            case 'price_low':
                $orderBy = "ORDER BY p.price ASC";
                break;
            case 'price_high':
                $orderBy = "ORDER BY p.price DESC";
                break;
            case 'name':
                $orderBy = "ORDER BY p.name ASC";
                break;
            case 'rating':
                $orderBy = "ORDER BY p.rating DESC";
                break;
            default:
                $orderBy = "ORDER BY p.created_at DESC";
        }

        $products = $db->fetchAll(
            "SELECT p.*, c.name as category_name, c.category_url_name as category_slug 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             {$where} {$orderBy}",
            $params
        );

        $categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");

        $pageTitle = 'Products';
        $currentPage = 'products';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function show($slug)
    {
        $db = Database::getInstance();

        $product = $db->fetch(
            "SELECT p.*, c.name as category_name, c.category_url_name as category_slug 
             FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.slug = ?",
            [$slug]
        );

        if (!$product) {
            http_response_code(404);
            echo '<h1>Product Not Found</h1>';
            return;
        }

        $relatedProducts = $db->fetchAll(
            "SELECT p.*, c.name as category_name FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.category_id = ? AND p.id != ? 
             ORDER BY RAND() LIMIT 4",
            [$product['category_id'], $product['id']]
        );

        $pageTitle = $product['name'];
        $currentPage = 'product-detail';
        require BASE_PATH . '/views/layouts/main.php';
    }
}
