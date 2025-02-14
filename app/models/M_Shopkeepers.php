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

    public function getEmployeeById($id)
    {
        $this->db->query('SELECT * FROM employees WHERE employee_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addEmployee($data)
    {
        $this->db->query('INSERT INTO employees (user_id, first_name, last_name, phone_number, email, home_town, image) VALUES (:user_id, :first_name, :last_name, :phone_number, :email, :home_town, :image)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':image', $data['image'], PDO::PARAM_LOB);

        return $this->db->execute();
    }


public function updateEmployee($data)
{
    $this->db->query('UPDATE employees SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number, email = :email, home_town = :home_town, image = :image WHERE employee_id = :employee_id');
    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':phone_number', $data['phone_number']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':home_town', $data['home_town']);
    $this->db->bind(':image', $data['image'], PDO::PARAM_LOB);
    $this->db->bind(':employee_id', $data['employee_id']);

    return $this->db->execute();
}

    public function deleteEmployee($id)
    {
        $this->db->query('DELETE FROM employees WHERE employee_id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }
}
