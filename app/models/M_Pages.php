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
}
