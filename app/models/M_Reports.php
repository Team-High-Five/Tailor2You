<?php
class M_Reports {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Assuming you have a Database class for handling DB operations
    }

    public function getSalesReport($dateRange) {
        $this->db->query("SELECT * FROM sales WHERE date BETWEEN :start AND :end");
        $this->db->bind(':start', $dateRange['start']);
        $this->db->bind(':end', $dateRange['end']);
        return $this->db->resultSet();
    }

    public function getRefundReport($dateRange) {
        $this->db->query("SELECT * FROM refunds WHERE date BETWEEN :start AND :end");
        $this->db->bind(':start', $dateRange['start']);
        $this->db->bind(':end', $dateRange['end']);
        return $this->db->resultSet();
    }

    public function getUserActivityReport() {
        $this->db->query("SELECT id, username, email, user_type FROM users");
        return $this->db->resultSet();
    }

    public function getInventoryReport($dateRange) {
        $this->db->query("SELECT * FROM inventory WHERE last_updated BETWEEN :start AND :end");
        $this->db->bind(':start', $dateRange['start']);
        $this->db->bind(':end', $dateRange['end']);
        return $this->db->resultSet();
    }
}