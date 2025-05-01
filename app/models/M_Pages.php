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
    public function getAllSellers()
    {
        $this->db->query("SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, bio, profile_pic ,join_date FROM users WHERE user_type = 'shopkeeper' OR user_type = 'tailor'");
        return $this->db->resultSet();
    }

    


    public function getFeaturedDesigns()
    {
        $this->db->query("
            SELECT d.design_id, d.name, d.main_image, d.base_price, 
                   u.user_id, CONCAT(u.first_name, ' ', u.last_name) as tailor_name
            FROM designs as d
            JOIN users as u ON d.user_id = u.user_id
            WHERE d.status = 'active'
            ORDER BY RAND()
            LIMIT 6
        ");
        return $this->db->resultSet();
    }
    public function getDesignsByGender($gender)
    {
        $this->db->query(
            "
        SELECT d.design_id, d.name, d.main_image, d.base_price, d.gender,
        u.user_id, CONCAT(u.first_name, ' ', u.last_name) as tailor_name
        FROM designs d
        JOIN users as u ON d.user_id = u.user_id
        WHERE d.status = 'active' AND d.gender = :gender
        ORDER BY RAND()
        LIMIT 6"
        );
        $this->db->bind(':gender', $gender);
        return $this->db->resultSet();
    }

    public function getCategoryByName($categoryName)
    {
        $this->db->query("SELECT category_id FROM clothing_categories WHERE name = :name");
        $this->db->bind(':name', $categoryName);
        $result= $this->db->single();

        return $result ? $result->category_id : null;
    }
    public function  getDesignsByCategory($categoryId)
    {
        $this->db->query("SELECT d.design_id, d.name, d.main_image,d.base_price ,
        u.user_id, CONCAT(u.first_name, ' ', u.last_name) as tailor_name
        FROM designs d
        JOIN users as u ON d.user_id = u.user_id
        WHERE d.status ='active' AND d.category_id = :categoryId
        ORDER BY RAND()
        LIMIT 6");
        $this->db->bind(':categoryId', $categoryId);
        return $this->db->resultSet();
    }
    // Add these new methods to the existing M_Pages class
    public function getSellerById($id)
    {
        $this->db->query("SELECT user_id, first_name, last_name, 
                      CONCAT(first_name, ' ', last_name) AS name, 
                      bio, profile_pic, home_town, user_type ,join_date
                      FROM users 
                      WHERE (user_type = 'shopkeeper' OR user_type = 'tailor') 
                      AND user_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getPostCountByUserId($id)
    {
        $this->db->query("SELECT COUNT(*) as count FROM posts WHERE user_id = :id");
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result->count;
    }

    public function getLikeCountByUserId($id)
    {

        $this->db->query("SELECT COUNT(*) as count FROM likes WHERE tailor_id = :id AND status = 'active'");
        $this->db->bind(':id', $id);
        $result = $this->db->single();

        return $result ? $result->count : 0;
    }
    // Update the getPostsByUserId method to include like counts
    public function getPostsByUserId($id)
    {
        $this->db->query("SELECT p.*, 
                     (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id AND status = 'active') as like_count 
                     FROM posts p 
                     WHERE p.user_id = :id 
                     ORDER BY p.created_at DESC");
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }

    public function getLikedPostsByUser($userId)
    {
        $this->db->query("SELECT post_id FROM post_likes WHERE user_id = :userId AND status = 'active'");
        $this->db->bind(':userId', $userId);
        $results = $this->db->resultSet();

        $likedPosts = [];
        foreach ($results as $result) {
            $likedPosts[] = $result->post_id;
        }

        return $likedPosts;
    }




    public function toggleLike($customerId, $tailorId)
    {
        $this->db->query("SELECT * FROM likes WHERE customer_id = :customerId AND tailor_id = :tailorId");
        $this->db->bind(':customerId', $customerId);
        $this->db->bind(':tailorId', $tailorId);

        $existingLike = $this->db->single();

        if ($existingLike) {
            if ($existingLike->status === 'active') {
                $this->db->query("UPDATE likes SET status = 'removed' WHERE customer_id = :customerId AND tailor_id = :tailorId");
            } else {
                $this->db->query("UPDATE likes SET status = 'active' WHERE customer_id = :customerId AND tailor_id = :tailorId");
            }
            $this->db->bind(':customerId', $customerId);
            $this->db->bind(':tailorId', $tailorId);
            return $this->db->execute();
        } else {

            $this->db->query("INSERT INTO likes (customer_id, tailor_id, status) VALUES (:customerId, :tailorId, 'active')");
            $this->db->bind(':customerId', $customerId);
            $this->db->bind(':tailorId', $tailorId);
            return $this->db->execute();
        }
    }
    public function hasUserLikedTailor($customerId, $tailorId)
    {
        $this->db->query("SELECT * FROM likes WHERE customer_id = :customerId AND tailor_id = :tailorId AND status = 'active'");
        $this->db->bind(':customerId', $customerId);
        $this->db->bind(':tailorId', $tailorId);

        return $this->db->single() ? true : false;
    }

    public function getPostById($id)
    {
        $this->db->query("SELECT * FROM posts WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function togglePostLike($userId, $postId)
    {
        $this->db->query("SELECT * FROM post_likes WHERE post_id = :postId AND user_id = :userId");
        $this->db->bind(':postId', $postId);
        $this->db->bind(':userId', $userId);
        $result = $this->db->single();

        if ($result) {
            $newStatus = ($result->status === 'active') ? 'inactive' : 'active';
            $this->db->query("UPDATE post_likes SET status = :status WHERE post_id = :postId AND user_id = :userId");
            $this->db->bind(':status', $newStatus);
            $this->db->bind(':postId', $postId);
            $this->db->bind(':userId', $userId);
            return $this->db->execute();
        } else {
            $this->db->query("INSERT INTO post_likes (post_id, user_id, status) VALUES (:postId, :userId, 'active')");
            $this->db->bind(':postId', $postId);
            $this->db->bind(':userId', $userId);
            return $this->db->execute();
        }
    }

    public function hasUserLikedPost($userId, $postId)
    {
        $this->db->query("SELECT * FROM post_likes WHERE post_id = :postId AND user_id = :userId AND status = 'active'");
        $this->db->bind(':postId', $postId);
        $this->db->bind(':userId', $userId);
        return $this->db->rowCount() > 0;
    }
    public function getDesignsByUserId($id)
    {
        $this->db->query("SELECT d.*, 
                     (SELECT COUNT(*) FROM designs WHERE design_id = d.design_id AND status = 'active') 
                     FROM designs d 
                     WHERE d.user_id = :id 
                     ORDER BY d.created_at DESC");
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }
 
}
