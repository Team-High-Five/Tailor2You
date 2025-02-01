<?php
class M_Shopkeepers
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getEmployeesByUserId($user_id)
    {
        $this->db->query('SELECT * FROM employees WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
}