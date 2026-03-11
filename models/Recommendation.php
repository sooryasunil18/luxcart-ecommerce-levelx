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
}
