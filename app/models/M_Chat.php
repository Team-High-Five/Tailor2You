<?php
class M_Chat {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Save a message to the database
    public function saveMessage($message) {
        $this->db->query('INSERT INTO messages (text) VALUES (:message)');
        $this->db->bind(':message', $message);
        return $this->db->execute();
    }

    // Retrieve all messages from the database
    public function getMessages() {
        $this->db->query('SELECT * FROM messages ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
}