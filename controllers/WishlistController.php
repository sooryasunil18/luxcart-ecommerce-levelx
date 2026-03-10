<?php
require_once BASE_PATH . '/models/Database.php';

class WishlistController
{
    private $db;
    private $userId;

    public function __construct()
    {
        $this->db = Database::getInstance();

        if (isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
        }
    }

    public function index()
    {
        // Only customers have the wishlist view
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'customer') {
            header('Location: ' . BASE_URL . '/#guest-wishlist');
            exit;
        }

        $wishlistItems = $this->db->fetchAll(
            "SELECT w.id as wishlist_id, p.*, c.name as category_name 
             FROM wishlist w 
             JOIN products p ON w.product_id = p.id 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE w.user_id = ? 
             ORDER BY w.added_at DESC",
            [$this->userId],
            'i'
        );

        $pageTitle = 'My Wishlist';
        $currentPage = 'customer/wishlist';
        require BASE_PATH . '/views/layouts/main.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/products');
            exit;
        }

        $productId = $_POST['product_id'] ?? 0;

        if ($productId) {
            if (!isset($_SESSION['user_id'])) {
                if (!isset($_SESSION['guest_wishlist'])) {
                    $_SESSION['guest_wishlist'] = [];
                }
                
                if (!in_array($productId, $_SESSION['guest_wishlist'])) {
                    $_SESSION['guest_wishlist'][] = $productId;
                    $_SESSION['success'] = 'Product added to your wishlist!';
                } else {
                    $_SESSION['error'] = 'Product is already in your wishlist.';
                }
            } else {
                // Check if already in wishlist
                $existing = $this->db->fetch(
                    "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?",
                    [$this->userId, $productId],
                    'ii'
                );

                if (!$existing) {
                    $this->db->query(
                        "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)",
                        [$this->userId, $productId],
                        'ii'
                    );
                    $_SESSION['success'] = 'Product added to your wishlist!';
                } else {
                    $_SESSION['error'] = 'Product is already in your wishlist.';
                }
            }
        }

        // Redirect back where they came from
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/products';
        header('Location: ' . $referer);
        exit;
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $wishlistId = $_POST['wishlist_id'] ?? 0;
        $productId = $_POST['product_id'] ?? 0;

        if (!isset($_SESSION['user_id'])) {
            if ($productId && isset($_SESSION['guest_wishlist'])) {
                $index = array_search($productId, $_SESSION['guest_wishlist']);
                if ($index !== false) {
                    unset($_SESSION['guest_wishlist'][$index]);
                    $_SESSION['guest_wishlist'] = array_values($_SESSION['guest_wishlist']);
                    $_SESSION['success'] = 'Product removed from your wishlist!';
                }
            }
        } else {
            if ($wishlistId) {
                $this->db->query(
                    "DELETE FROM wishlist WHERE id = ? AND user_id = ?",
                    [$wishlistId, $this->userId],
                    'ii'
                );
                $_SESSION['success'] = 'Product removed from your wishlist!';
            } elseif ($productId) {
                $this->db->query(
                    "DELETE FROM wishlist WHERE product_id = ? AND user_id = ?",
                    [$productId, $this->userId],
                    'ii'
                );
                $_SESSION['success'] = 'Product removed from your wishlist!';
            }
        }

        // Redirect back where they came from
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/';
        header('Location: ' . $referer);
        exit;
    }

    public static function getWishlistCount()
    {
        if (!isset($_SESSION['user_id'])) {
            return isset($_SESSION['guest_wishlist']) ? count($_SESSION['guest_wishlist']) : 0;
        }

        $db = Database::getInstance();
        $result = $db->fetch("SELECT COUNT(*) as count FROM wishlist WHERE user_id = ?", [$_SESSION['user_id']], 'i');
        return $result ? $result['count'] : 0;
    }
}
