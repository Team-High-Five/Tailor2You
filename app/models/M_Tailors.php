<?php

class M_Tailors {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }
    public function findTailorByEmail($email) {
        $this->db->query('SELECT * FROM tailors WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return $row ? $row : false;
    }

    public function login($email, $password) {
        $this->db->query('SELECT * FROM tailors WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        if ($row && password_verify($password, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function register($data) {
        $this->db->query('INSERT INTO tailors (first_name, last_name, email, password, phone_number, nic, birth_date, home_town, address) VALUES (:first_name, :last_name, :email, :password, :phone_number, :nic, :birth_date, :home_town, :address)');
        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':nic', $data['nic']);
        $this->db->bind(':birth_date', $data['birth_date']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':address', $data['address']);

        // Execute
        return $this->db->execute();
    }
}