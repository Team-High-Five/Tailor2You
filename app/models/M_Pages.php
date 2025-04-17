<?php

class M_Pages
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");
        return $this->db->resultSet();
    }
    public function getAllTailors()
    {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, bio, profile_pic FROM users WHERE user_type = 'tailor'");
        return $this->db->resultSet();
    }
    public function getFeaturedDesigns()
    {
        $this->db->query("
            SELECT d.design_id, d.name, d.main_image, d.base_price, 
                   u.user_id, CONCAT(u.first_name, ' ', u.last_name) as tailor_name
            FROM designs as d
            JOIN users as u ON d.user_id = u.user_id
            WHERE d.status = 'active'
            ORDER BY RAND()
            LIMIT 6
        ");
        return $this->db->resultSet();
    }
}
