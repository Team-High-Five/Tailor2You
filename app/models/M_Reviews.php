<?php

class M_Reviews {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Example method to fetch all reviews
    public function getAllReviews() {
        $this->db->query('SELECT * FROM reviews');
        return $this->db->resultSet();
    }

    // Example method to fetch a review by ID
    public function getReviewById($reviewId) {
        $this->db->query('SELECT * FROM reviews WHERE review_id = :review_id');
        $this->db->bind(':review_id', $reviewId);
        return $this->db->single();
    }

    // Example method to update review status
    public function updateReviewStatus($reviewId, $status, $adminNotes) {
        $this->db->query('UPDATE reviews SET status = :status, admin_notes = :admin_notes WHERE review_id = :review_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':admin_notes', $adminNotes);
        $this->db->bind(':review_id', $reviewId);
        return $this->db->execute();
    }
}