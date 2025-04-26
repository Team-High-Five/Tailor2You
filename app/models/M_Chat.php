<?php
class M_Chat
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Assuming you have a Database class for DB operations
    }

    public function saveMessage($sender_id, $receiver_id, $message)
    {
        $this->db->query('INSERT INTO messages (sender_id, receiver_id, text) VALUES (:sender_id, :receiver_id, :message)');
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        $this->db->bind(':message', $message);
        return $this->db->execute();
    }

    public function getMessages($sender_id, $receiver_id)
    {
        $this->db->query('SELECT * FROM messages WHERE (sender_id = :sender_id AND receiver_id = :receiver_id) OR (sender_id = :receiver_id AND receiver_id = :sender_id) ORDER BY created_at ASC');
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        return $this->db->resultSet();
    }

    public function getUserName($user_id)
    {
        $this->db->query('SELECT first_name FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result ? $result->first_name : null;
    }

    public function getConversations($user_id)
    {
        $this->db->query('SELECT DISTINCT 
                          CASE WHEN sender_id = :user_id THEN receiver_id ELSE sender_id END AS other_user_id,
                          MAX(created_at) AS last_message_date,
                          (SELECT text FROM messages WHERE 
                           (sender_id = :user_id AND receiver_id = other_user_id) OR 
                           (sender_id = other_user_id AND receiver_id = :user_id)
                           ORDER BY created_at DESC LIMIT 1) AS last_message,
                          (SELECT first_name FROM users WHERE user_id = other_user_id) AS receiver_name
                          FROM messages
                          WHERE sender_id = :user_id OR receiver_id = :user_id
                          GROUP BY other_user_id
                          ORDER BY last_message_date DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet() ?? [];
    }

    public function getAllUsersExcept($user_id)
    {
        $this->db->query('SELECT user_id, first_name, last_name, phone_number, user_type FROM users WHERE user_id != :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function getReceiver($receiver_id)
    {
        $this->db->query('SELECT user_id, first_name, last_name, phone_number FROM users WHERE user_id = :receiver_id');
        $this->db->bind(':receiver_id', $receiver_id);
        return $this->db->single(); // Fetch a single record
    }
}