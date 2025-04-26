<?php
class M_Shopkeepers
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getEmployeesByUserId($user_id)
    {
        $this->db->query('SELECT * FROM employees WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function getEmployeeById($id)
    {
        $this->db->query('SELECT * FROM employees WHERE employee_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addEmployee($data)
    {
        $this->db->query('INSERT INTO employees (user_id, first_name, last_name, phone_number, email, home_town, district, image) VALUES (:user_id, :first_name, :last_name, :phone_number, :email, :home_town, :district, :image)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':image', $data['image'], PDO::PARAM_LOB);

        return $this->db->execute();
    }


    public function updateEmployee($data)
    {
        $this->db->query('UPDATE employees SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number, email = :email, home_town = :home_town, district = :district, image = :image WHERE employee_id = :employee_id');
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':home_town', $data['home_town']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':image', $data['image'], PDO::PARAM_LOB);
        $this->db->bind(':employee_id', $data['employee_id']);

        return $this->db->execute();
    }

    public function deleteEmployee($id)
    {
        $this->db->query('DELETE FROM employees WHERE employee_id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    // Add appointment-related methods
    public function getAppointmentsByShopkeeperId($shopkeeper_id)
    {
        $this->db->query('
            SELECT a.appointment_id, u.first_name, u.last_name, a.appointment_date, a.appointment_time, a.status
            FROM appointments a
            JOIN users u ON a.customer_id = u.user_id
            WHERE a.tailor_shopkeeper_id = :shopkeeper_id
            ORDER BY a.appointment_date, a.appointment_time
        ');
        $this->db->bind(':shopkeeper_id', $shopkeeper_id);
        return $this->db->resultSet();
    }

    public function getAppointmentById($appointment_id)
    {
        $this->db->query('
            SELECT 
                appointments.*, 
                users.first_name, 
                users.last_name, 
                users.profile_pic,
                shopkeepers.first_name AS shopkeeper_first_name, 
                shopkeepers.last_name AS shopkeeper_last_name 
            FROM appointments 
            JOIN users ON appointments.customer_id = users.user_id 
            JOIN users AS shopkeepers ON appointments.tailor_shopkeeper_id = shopkeepers.user_id 
            WHERE appointments.appointment_id = :appointment_id
        ');
        $this->db->bind(':appointment_id', $appointment_id);
        return $this->db->single();
    }

    public function updateAppointment($data)
    {
        $this->db->query('UPDATE appointments SET appointment_date = :appointment_date, appointment_time = :appointment_time, status = :status WHERE appointment_id = :appointment_id');
        $this->db->bind(':appointment_date', $data['appointment_date']);
        $this->db->bind(':appointment_time', $data['appointment_time']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':appointment_id', $data['appointment_id']);
        return $this->db->execute();
    }

    public function updateAppointmentStatus($data)
    {
        $this->db->query('UPDATE appointments SET status = :status WHERE appointment_id = :appointment_id');
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':appointment_id', $data['appointment_id']);
        return $this->db->execute();
    }

    public function getAppointmentsByMonth($shopkeeper_id, $year, $month)
    {
        $this->db->query('
            SELECT 
                a.appointment_id, 
                a.appointment_date, 
                a.appointment_time, 
                a.status, 
                u.first_name, 
                u.last_name 
            FROM appointments a
            JOIN users u ON a.customer_id = u.user_id
            WHERE a.tailor_shopkeeper_id = :shopkeeper_id 
            AND YEAR(a.appointment_date) = :year 
            AND MONTH(a.appointment_date) = :month
        ');
        $this->db->bind(':shopkeeper_id', $shopkeeper_id);
        $this->db->bind(':year', $year);
        $this->db->bind(':month', $month);
        return $this->db->resultSet();
    }

    public function getPostsWithLikeCounts($userId) {
        $this->db->query("SELECT p.*, 
                         (SELECT COUNT(*) FROM post_likes 
                          WHERE post_id = p.id AND status = 'active') as like_count 
                         FROM posts p 
                         WHERE p.user_id = :id 
                         ORDER BY p.created_at DESC");
        $this->db->bind(':id', $userId);
        return $this->db->resultSet();
    }

    public function assignTailorToOrder($data)
    {
        try {
            // Begin transaction
            $this->db->query('START TRANSACTION');
            
            // Insert into order_tailor_assignments table
            $this->db->query('INSERT INTO order_tailor_assignments (order_id, tailor_id, assigned_by, notes) 
                             VALUES (:order_id, :tailor_id, :assigned_by, :notes)');
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->bind(':tailor_id', $data['tailor_id']);
            $this->db->bind(':assigned_by', $data['assigned_by']);
            $this->db->bind(':notes', $data['notes'] ?? null);
            
            $this->db->execute();
            
            // Update the order status to indicate a tailor has been assigned
            $this->db->query('UPDATE orders SET status = :status WHERE order_id = :order_id');
            $this->db->bind(':status', 'fabric_cutting');
            $this->db->bind(':order_id', $data['order_id']);
            
            $this->db->execute();
            
            // Add entry to order status history
            $this->db->query('INSERT INTO order_status_history (order_id, status, updated_by, notes) 
                             VALUES (:order_id, :status, :updated_by, :notes)');
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->bind(':status', 'fabric_cutting');
            $this->db->bind(':updated_by', $data['assigned_by']);
            $this->db->bind(':notes', 'Tailor assigned: Employee #' . $data['tailor_id']);
            
            $this->db->execute();
            
            // Commit the transaction
            $this->db->query('COMMIT');
            return true;
            
        } catch (Exception $e) {
            // Rollback transaction if any query fails
            $this->db->query('ROLLBACK');
            error_log('Error assigning tailor to order: ' . $e->getMessage());
            return false;
        }
    }

    public function assignTailorToAppointment($data)
    {
        try {
            // Begin transaction
            $this->db->query('START TRANSACTION');
            
            // Insert into appointment_tailor_assignments table
            $this->db->query('INSERT INTO appointment_tailor_assignments (appointment_id, tailor_id, assigned_by, notes) 
                             VALUES (:appointment_id, :tailor_id, :assigned_by, :notes)');
            $this->db->bind(':appointment_id', $data['appointment_id']);
            $this->db->bind(':tailor_id', $data['tailor_id']);
            $this->db->bind(':assigned_by', $_SESSION['user_id']);
            $this->db->bind(':notes', $data['notes'] ?? "Assigned by shopkeeper");
            
            $this->db->execute();
            
            // Update the appointment status to indicate a tailor has been assigned
            $this->db->query('UPDATE appointments SET status = :status WHERE appointment_id = :appointment_id');
            $this->db->bind(':status', 'accepted');
            $this->db->bind(':appointment_id', $data['appointment_id']);
            
            $this->db->execute();
            
            // Commit the transaction
            $this->db->query('COMMIT');
            return true;
            
        } catch (Exception $e) {
            // Rollback transaction if any query fails
            $this->db->query('ROLLBACK');
            error_log('Error assigning tailor to appointment: ' . $e->getMessage());
            return false;
        }
    }
}
