<?php
class M_Orders {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getOrders() {
        $this->db->query('SELECT * FROM orders');
        return $this->db->resultSet();
    }

    public function getOrderCount()
    {
        $this->db->query('SELECT COUNT(*) AS count FROM orders');
        $row = $this->db->single();
        return $row ? $row->count : 0; // Return the count or 0 if no rows are found
    }
}