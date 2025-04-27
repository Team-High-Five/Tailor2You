<?php
class M_Admin {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Assuming you have a Database class for handling DB operations
    }

    public function updateUser($data) {
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, nic = :nic, birth_date = :birth_date, home_town = :home_town, address = :address, bio = :bio, category = :category, profile_pic = IFNULL(:profile_pic, profile_pic), status = :status WHERE user_id = :user_id');
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':nic', $data['nic']);
        $this->db->bind(':birth_date', $data['birth_date']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':bio', $data['bio']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':profile_pic', $data['profile_pic']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':user_id', $data['user_id']);
        return $this->db->execute();
    }

    public function deleteUserById($id) {
        $this->db->query('DELETE FROM users WHERE user_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getAllUsers() {
        $this->db->query('SELECT user_id AS id, CONCAT(first_name, " ", last_name) AS name, email, user_type AS role FROM users');
        return $this->db->resultSet();
    }

    public function getAllCustomers() {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, phone_number, email, status FROM users WHERE user_type = 'customer'");
        return $this->db->resultSet();
    }

    public function deleteCustomerById($id) {
        $this->db->query('DELETE FROM users WHERE user_id = :id AND user_type = "customer"');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getAllShopkeepers() {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, phone_number, email, status FROM users WHERE user_type = 'shopkeeper'");
        return $this->db->resultSet();
    }

    public function deleteShopkeeperById($id) {
        $this->db->query('DELETE FROM users WHERE user_id = :id AND user_type = "shopkeeper"');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getAllTailors() {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, phone_number, email, status FROM users WHERE user_type = 'tailor'");
        return $this->db->resultSet();
    }

    public function deleteTailorById($id) {
        $this->db->query('DELETE FROM users WHERE user_id = :id AND user_type = "tailor"');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function updateCustomer($data) {
        $data['user_type'] = 'customer';
        return $this->updateUser($data);
    }

    public function updateTailor($data) {
        $data['user_type'] = 'tailor';
        return $this->updateUser($data);
    }

    public function updateShopkeeper($data) {
        $data['user_type'] = 'shopkeeper';
        return $this->updateUser($data);
    }

    public function addUser($data) {
        $this->db->query('INSERT INTO users (user_type, first_name, last_name, email, phone_number, nic, birth_date, home_town, address, bio, category, status, password, profile_pic) VALUES (:user_type, :first_name, :last_name, :email, :phone_number, :nic, :birth_date, :home_town, :address, :bio, :category, :status, :password, :profile_pic)');
        $this->db->bind(':user_type', $data['user_type']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':nic', $data['nic']);
        $this->db->bind(':birth_date', $data['birth_date']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':bio', $data['bio']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':profile_pic', $data['profile_pic']);
        return $this->db->execute();
    }

    public function getUserCount()
    {
        $this->db->query("SELECT COUNT(*) as count FROM users");
        return $this->db->single()->count;
    }

    public function getOrderCount()
    {
        $this->db->query("SELECT COUNT(*) as count FROM orders");
        return $this->db->single()->count;
    }

    public function getInventoryCount()
    {
        $this->db->query("SELECT COUNT(*) as count FROM fabrics"); // Query the fabrics table
        return $this->db->single()->count;
    }

    public function getReviewCount() {
        $this->db->query("SELECT COUNT(*) as count FROM reviews");
        return $this->db->single()->count;
    }

    public function getUserCountsByType()
    {
        $this->db->query("SELECT user_type, COUNT(*) as count FROM users GROUP BY user_type");
        return $this->db->resultSet();
    }
    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE user_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function testDatabaseConnection() {
        $this->db->query("SELECT 1");
        return $this->db->execute();
    }

    public function getAllReviews() {
        $this->db->query("SELECT r.review_id, r.review_text, r.rating, r.created_at, r.status, r.admin_notes, 
                                 u.user_id AS user_id, CONCAT(u.first_name, ' ', u.last_name) AS user_name
                          FROM reviews r
                          JOIN users u ON r.user_id = u.user_id");
        return $this->db->resultSet(); // Fetch all reviews
    }

    public function getReviewById($review_id) {
        $this->db->query("SELECT r.review_id, r.review_text, r.rating, r.created_at, r.status, r.admin_notes, 
                                 u.user_id, CONCAT(u.first_name, ' ', u.last_name) AS user_name, 
                                 u.email, u.phone_number AS phone
                          FROM reviews r
                          JOIN users u ON r.user_id = u.user_id
                          WHERE r.review_id = :review_id");
        $this->db->bind(':review_id', $review_id);

        return $this->db->single(); // Fetch a single review
    }

    public function updateReviewStatus($review_id, $status, $admin_notes) {
        $this->db->query("UPDATE reviews SET status = :status, admin_notes = :admin_notes WHERE review_id = :review_id");
        $this->db->bind(':status', $status);
        $this->db->bind(':admin_notes', $admin_notes);
        $this->db->bind(':review_id', $review_id);

        return $this->db->execute();
    }

    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        if ($row && password_verify($password, $row->password)) {
            // Store admin ID in session
            $_SESSION['admin_id'] = $row->user_id;
            return $row;
        } else {
            return false;
        }
    }
}