<?php
class M_Feedback
{
    private $db;
    
    public function __construct()
    {
        $this->db = new Database;
    }

    // Get all feedback (for admin/management)
    public function getAllFeedback()
    {
        $this->db->query('SELECT * FROM feedback ORDER BY created_at DESC');
        return $this->db->resultSet();
    }
    
    // Get only published feedback (for public display)
    public function getPublishedFeedback($limit = 5)
    {
        $this->db->query('SELECT * FROM feedback WHERE status = :status ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':status', 'published');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
    
    // Get feedback by ID
    public function getFeedbackById($id)
    {
        $this->db->query('SELECT * FROM feedback WHERE feedback_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Add new feedback
    public function addFeedback($data)
    {
        $this->db->query('INSERT INTO feedback (name, email, rating, feedback_text) VALUES (:name, :email, :rating, :feedback_text)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':feedback_text', $data['feedback_text']);
        
        return $this->db->execute();
    }
    
    // Update feedback status (publish/reject)
    public function updateFeedbackStatus($id, $status)
    {
        $this->db->query('UPDATE feedback SET status = :status WHERE feedback_id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Delete feedback
    public function deleteFeedback($id)
    {
        $this->db->query('DELETE FROM feedback WHERE feedback_id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    // Count feedback by status
    public function countFeedbackByStatus($status = null)
    {
        if ($status) {
            $this->db->query('SELECT COUNT(*) as count FROM feedback WHERE status = :status');
            $this->db->bind(':status', $status);
        } else {
            $this->db->query('SELECT COUNT(*) as count FROM feedback');
        }
        
        $result = $this->db->single();
        return $result->count;
    }
    
    // Get average rating from published feedback
    public function getAverageRating()
    {
        $this->db->query('SELECT AVG(rating) as avg_rating FROM feedback WHERE status = :status');
        $this->db->bind(':status', 'published');
        
        $result = $this->db->single();
        return $result->avg_rating ? round($result->avg_rating, 1) : 0;
    }
}
