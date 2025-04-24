<?php
class M_Notifications
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Get unread notifications count
     * 
     * @param int $userId The user ID
     * @param string $userType The user type
     * @return int The count of unread notifications
     */
    public function getUnreadCount($userId, $userType)
    {
        $count = 0;

        // For now, we'll just count reschedule requests for customers
        if ($userType === 'customer') {
            $this->db->query('SELECT COUNT(*) as count 
                             FROM reschedule_requests r 
                             JOIN appointments a ON r.appointment_id = a.appointment_id 
                             WHERE a.customer_id = :user_id 
                             AND r.status = "pending"
                             AND a.status = "reschedule_pending"');
            $this->db->bind(':user_id', $userId);
            $result = $this->db->single();

            if ($result) {
                $count = $result->count;
            }
        }

        return $count;
    }

    // Additional methods will be added here as the notification system expands
}
