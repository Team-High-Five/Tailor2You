<?php
class M_Admin {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Assuming you have a Database class for handling DB operations
    }

    public function getUserCount() {
        $this->db->query("SELECT COUNT(*) AS count FROM users");
        return $this->db->single()->count;
    }

    public function getOrderCount() {
        $this->db->query("SELECT COUNT(*) AS count FROM orders");
        return $this->db->single()->count;
    }

    public function getInventoryCount() {
        $this->db->query("SELECT COUNT(*) AS count FROM inventory");
        return $this->db->single()->count;
    }

    public function getReviewCount() {
        $this->db->query("SELECT COUNT(*) AS count FROM posts"); // Assuming reviews are stored in the `posts` table
        return $this->db->single()->count;
    }
}