<?php
require_once __DIR__ . '/Database.php';

class UserActivity
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function log($userId, $productId, $action)
    {
        $validActions = ['view', 'add_to_cart', 'purchase', 'wishlist'];
        if (!in_array($action, $validActions)) {
            return false;
        }

        $this->db->insert(
            "INSERT INTO user_activity (user_id, product_id, action) VALUES (?, ?, ?)",
        [$userId, $productId, $action],
            'iis'
        );

        return true;
    }
}
