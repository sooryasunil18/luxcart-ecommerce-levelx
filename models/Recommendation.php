<?php
require_once __DIR__ . '/Database.php';

class Recommendation
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAlsoBought($productId, $limit = 4)
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name as category_name, COUNT(oi2.product_id) as purchase_count
             FROM order_items oi1
             JOIN order_items oi2 ON oi1.order_id = oi2.order_id AND oi2.product_id != ?
             JOIN products p ON oi2.product_id = p.id
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE oi1.product_id = ?
             GROUP BY oi2.product_id
             ORDER BY purchase_count DESC
             LIMIT ?",
        [$productId, $productId, $limit],
            'iii'
        );
    }
    public function getTrending($limit = 8)
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name as category_name, COUNT(ua.id) as interaction_count
             FROM user_activity ua
             JOIN products p ON ua.product_id = p.id
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE ua.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             GROUP BY ua.product_id
             ORDER BY interaction_count DESC
             LIMIT ?",
        [$limit],
            'i'
        );
    }
    public function getPersonalized($userId, $limit = 4)
    {
        return $this->db->fetchAll(
            "SELECT p.*, c.name as category_name, COUNT(ua.id) as interest_score
             FROM user_activity ua
             JOIN products p ON ua.product_id = p.id
             LEFT JOIN categories c ON p.category_id = c.id
             -- Find categories the user has interacted with
             WHERE p.category_id IN (
                 SELECT p_sub.category_id
                 FROM user_activity ua_sub
                 JOIN products p_sub ON ua_sub.product_id = p_sub.id
                 WHERE ua_sub.user_id = ?
             )
             -- Exclude products the user has already purchased
             AND p.id NOT IN (
                 SELECT product_id FROM user_activity WHERE user_id = ? AND action = 'purchase'
             )
             -- Exclude products the user is currently viewing in this session's activity (optional, but good)
             GROUP BY p.id
             ORDER BY interest_score DESC
             LIMIT ?",
        [$userId, $userId, $limit],
            'iii'
        );
    }


}
