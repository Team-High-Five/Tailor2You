<?php

class M_Reviews
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Add this method to make your controller work
    public function addFeedback($data)
    {
        $this->db->query('INSERT INTO reviews (user_id, review_text, rating) 
                          VALUES (:user_id, :review_text, :rating)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':review_text', $data['feedback']); // Notice: mapping 'feedback' to 'review_text'
        $this->db->bind(':rating', $data['rating']);

        return $this->db->execute();
    }

    // Example method to fetch all reviews
    public function getAllReviews()
    {
        $this->db->query('SELECT r.*, u.first_name, u.last_name, u.email, u.phone_number 
                          FROM reviews r 
                          LEFT JOIN users u ON r.user_id = u.user_id
                          ORDER BY r.created_at DESC');
        return $this->db->resultSet();
    }

    // Example method to fetch a review by ID
    public function getReviewById($reviewId)
    {
        $this->db->query('SELECT r.*, u.first_name, u.last_name, u.email, u.phone_number 
                          FROM reviews r 
                          LEFT JOIN users u ON r.user_id = u.user_id 
                          WHERE r.review_id = :review_id');
        $this->db->bind(':review_id', $reviewId);
        return $this->db->single();
    }

    // Example method to update review status
    public function updateReviewStatus($reviewId, $status, $adminNotes)
    {
        $this->db->query('UPDATE reviews SET status = :status, admin_notes = :admin_notes WHERE review_id = :review_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':admin_notes', $adminNotes);
        $this->db->bind(':review_id', $reviewId);
        return $this->db->execute();
    }

    // Add a new review
    public function addReview($data)
    {
        $this->db->query('INSERT INTO reviews (user_id, review_text, rating, created_at) 
                          VALUES (:user_id, :review_text, :rating, NOW())');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':review_text', $data['review_text']);
        $this->db->bind(':rating', $data['rating']);

        return $this->db->execute();
    }

    public function getLatestReviews($limit)
    {
        // Modified to show all approved reviews OR the most recent pending ones
        $this->db->query('SELECT review_text, rating, created_at 
                     FROM reviews 
                     WHERE status = "accepted" OR status = "pending" 
                     ORDER BY created_at DESC 
                     LIMIT :limit');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
