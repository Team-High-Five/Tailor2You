<?php

class M_Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return $this->db->rowCount() > 0;
    }
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row ? $row : false;
    }

    public function updateUser($data)
    {
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, nic = :nic, birth_date = :birth_date, home_town = :home_town, address = :address, bio = :bio, category = :category, profile_pic = IFNULL(:profile_pic, profile_pic), status = :status WHERE user_id = :user_id');
        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone_number', value: $data['phone_number']);
        $this->db->bind(':nic', $data['nic']);
        $this->db->bind(':birth_date', $data['birth_date']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':bio', $data['bio']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':profile_pic', $data['profile_pic']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':user_id', $data['user_id']);

        // Execute
        return $this->db->execute();
    }

    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if (!$row) {
            return false;
        }

        // Check if user is inactive and customer
        if ($row->status === 'inactive' && $row->user_type === 'customer') {
            return false;
        }

        $hashed_password = $row->password;

        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function register($data)
    {
        $this->db->query('INSERT INTO users (user_type, first_name, last_name, email, password, phone_number, nic, birth_date, home_town, address, bio, category, profile_pic) VALUES (:user_type, :first_name, :last_name, :email, :password, :phone_number, :nic, :birth_date, :home_town, :address, :bio, :category, :profile_pic)');
        // Bind values
        $this->db->bind(':user_type', $data['user_type']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':nic', $data['nic']);
        $this->db->bind(':birth_date', $data['birth_date']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':bio', $data['bio']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':profile_pic', $data['profile_pic']);

        // Execute
        return $this->db->execute();
    }
    public function getPostsByUserId($user_id)
    {
        $this->db->query('SELECT * FROM posts WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts (user_id, title, description, gender, item_type, image) 
                          VALUES (:user_id, :title, :description, :gender, :item_type, :image)');
        
        // Bind values
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':item_type', $data['item_type']);
        $this->db->bind(':image', $data['image']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostById($post_id)
    {
        $this->db->query('SELECT * FROM posts WHERE id = :post_id');
        $this->db->bind(':post_id', $post_id);
        return $this->db->single();
    }

    public function updatePost($data)
    {
        $this->db->query('UPDATE posts SET title = :title, description = :description, 
                          gender = :gender, item_type = :item_type, image = :image 
                          WHERE id = :id AND user_id = :user_id');
        
        // Bind values
        $this->db->bind(':id', $data['post_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':item_type', $data['item_type']);
        $this->db->bind(':image', $data['image']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($post_id)
    {
        $this->db->query('DELETE FROM posts WHERE id = :post_id');
        $this->db->bind(':post_id', $post_id);

        // Execute
        return $this->db->execute();
    }

    public function getAllCustomers()
    {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, phone_number, email ,status FROM users WHERE user_type = 'customer'");
        return $this->db->resultSet();
    }
    public function deleteCustomerById($id)
    {
        $this->db->query('DELETE FROM users WHERE user_id = :id AND user_type = "customer"');
        $this->db->bind(':id', $id);

        // Execute
        return $this->db->execute();
    }
    public function updateCustomer($data)
    {
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, nic = :nic, birth_date = :birth_date, home_town = :home_town, address = :address, bio = :bio, category = :category, profile_pic = IFNULL(:profile_pic, profile_pic), status = :status WHERE user_id = :user_id');
        // Bind values
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

        // Execute
        return $this->db->execute();
    }
    public function getAllShopkeepers()
    {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, phone_number, email, status FROM users WHERE user_type = 'shopkeeper'");
        return $this->db->resultSet();
    }

    public function deleteShopkeeperById($id)
    {
        $this->db->query('DELETE FROM users WHERE user_id = :id AND user_type = "shopkeeper"');
        $this->db->bind(':id', $id);

        // Execute
        return $this->db->execute();
    }

    public function updateShopkeeper($data)
    {
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, nic = :nic, birth_date = :birth_date, home_town = :home_town, address = :address, bio = :bio, category = :category, profile_pic = IFNULL(:profile_pic, profile_pic), status = :status WHERE user_id = :user_id');
        // Bind values
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

        // Execute
        return $this->db->execute();
    }
    public function getAllTailors()
    {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, phone_number, email, status FROM users WHERE user_type = 'tailor'");
        return $this->db->resultSet();
    }

    public function deleteTailorById($id)
    {
        $this->db->query('DELETE FROM users WHERE user_id = :id AND user_type = "tailor"');
        $this->db->bind(':id', $id);

        // Execute
        return $this->db->execute();
    }


    public function updateTailor($data)
    {
        $this->db->query('UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, nic = :nic, birth_date = :birth_date, home_town = :home_town, address = :address, bio = :bio, category = :category, profile_pic = IFNULL(:profile_pic, profile_pic), status = :status WHERE user_id = :user_id');
        // Bind values
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

        // Execute
        return $this->db->execute();
    }

    public function addUser($data)
    {
        $this->db->query('INSERT INTO users (user_type, first_name, last_name, email, phone_number, nic, birth_date, home_town, address, bio, category, status, password, profile_pic) VALUES (:user_type, :first_name, :last_name, :email, :phone_number, :nic, :birth_date, :home_town, :address, :bio, :category, :status, :password, :profile_pic)');

        // Bind values
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

        // Execute
        return $this->db->execute();
    }


    public function deleteUserById($id)
    {
        $this->db->query('DELETE FROM users WHERE user_id = :id');
        $this->db->bind(':id', $id);

        // Execute
        return $this->db->execute();
    }

public function updatePassword($user_id, $new_password)
{
    $this->db->query('UPDATE users SET password = :password WHERE user_id = :user_id');
    $this->db->bind(':password', password_hash($new_password, PASSWORD_DEFAULT));
    $this->db->bind(':user_id', $user_id);

    // Execute
    return $this->db->execute();
}

public function checkPassword($user_id, $current_password)
{
    $this->db->query('SELECT password FROM users WHERE user_id = :user_id');
    $this->db->bind(':user_id', $user_id);
    $row = $this->db->single();

    if ($row && password_verify($current_password, $row->password)) {
        return true;
    } else {
        return false;
    }
}
}
