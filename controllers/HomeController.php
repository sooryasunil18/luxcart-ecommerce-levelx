<?php
class HomeController
{
    public function index()
    {
        $db = Database::getInstance();
        $categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'seller') {
            $featuredProducts = $db->fetchAll(
                "SELECT p.*, c.name as category_name FROM products p 
                 LEFT JOIN categories c ON p.category_id = c.id 
                 WHERE p.seller_id = ? ORDER BY p.created_at DESC LIMIT 8",
                 [$_SESSION['user_id']]
            );
        } else {
            $featuredProducts = $db->fetchAll(
                "SELECT p.*, c.name as category_name FROM products p 
                 LEFT JOIN categories c ON p.category_id = c.id 
                 WHERE p.featured = 1 ORDER BY p.created_at DESC LIMIT 8"
            );
        }

        $wishlistItems = [];
        if (!isset($_SESSION['user_id'])) {
            if (isset($_SESSION['guest_wishlist']) && count($_SESSION['guest_wishlist']) > 0) {
                $ids = implode(',', array_map('intval', $_SESSION['guest_wishlist']));
                $wishlistItems = $db->fetchAll(
                    "SELECT p.*, c.name as category_name FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     WHERE p.id IN ($ids) ORDER BY p.created_at DESC"
                );
            }
        } else if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer') {
            $wishlistItems = $db->fetchAll(
                "SELECT w.id as wishlist_id, p.*, c.name as category_name 
                 FROM wishlist w 
                 JOIN products p ON w.product_id = p.id 
                 LEFT JOIN categories c ON p.category_id = c.id 
                 WHERE w.user_id = ? 
                 ORDER BY w.added_at DESC",
                [$_SESSION['user_id']],
                'i'
            );
        }

        require_once BASE_PATH . '/models/Recommendation.php';
        $recommendation = new Recommendation();
        $trendingProducts = $recommendation->getTrending(8);

        $personalizedProducts = [];
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'customer') {
            $personalizedProducts = $recommendation->getPersonalized($_SESSION['user_id'], 4);
        }





        $pageTitle = 'Home';
        $currentPage = 'home';
        require BASE_PATH . '/views/layouts/main.php';
    }
}
