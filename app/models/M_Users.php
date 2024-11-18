<?php

class M_Users {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return $this->db->rowCount() > 0;
    }

    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        if ($row && password_verify($password, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function register($data) {
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        // Execute
        return $this->db->execute();
    }
}