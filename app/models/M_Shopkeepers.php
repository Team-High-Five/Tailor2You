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

    public function addEmployee($data)
    {
        $this->db->query('INSERT INTO employees (user_id, first_name, last_name, phone_number, home_town, email) VALUES (:user_id, :first_name, :last_name, :phone_number, :home_town, :email)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':email', $data['email']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}