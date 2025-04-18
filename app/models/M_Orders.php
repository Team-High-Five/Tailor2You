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
}