<?php

class M_Tailors
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getTailorById($id)
    {
        $this->db->query('SELECT * FROM users WHERE user_type = "tailor" AND user_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row ? $row : false;
    }

    public function getColors()
    {
        $this->db->query('SELECT * FROM colors');
        return $this->db->resultSet();
    }


    public function addFabric($data)
    {
        $this->db->query('INSERT INTO fabrics (tailor_id, fabric_name, price_per_meter, stock, image) VALUES (:tailor_id, :fabric_name, :price, :stock, :image)');
        $this->db->bind(':tailor_id', $data['tailor_id']);
        $this->db->bind(':fabric_name', $data['fabric_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':image', $data['image']);

        if ($this->db->execute()) {
            $fabric_id = $this->db->lastInsertId();
            foreach ($data['colors'] as $color_id) {
                $this->db->query('INSERT INTO fabric_colors (fabric_id, color_id) VALUES (:fabric_id, :color_id)');
                $this->db->bind(':fabric_id', $fabric_id);
                $this->db->bind(':color_id', $color_id);
                $this->db->execute();
            }
            return true;
        } else {
            return false;
        }
    }
    public function getFabricsByTailorId($tailor_id)
    {
        $this->db->query('
        SELECT f.*, GROUP_CONCAT(c.color_name SEPARATOR ", ") AS colors
        FROM fabrics f
        LEFT JOIN fabric_colors fc ON f.fabric_id = fc.fabric_id
        LEFT JOIN colors c ON fc.color_id = c.color_id
        WHERE f.tailor_id = :tailor_id
        GROUP BY f.fabric_id
    ');
        $this->db->bind(':tailor_id', $tailor_id);
        return $this->db->resultSet();
    }
    public function getFabricById($fabric_id)
    {
        $this->db->query('
        SELECT f.*, GROUP_CONCAT(c.color_name SEPARATOR ", ") AS colors
        FROM fabrics f
        LEFT JOIN fabric_colors fc ON f.fabric_id = fc.fabric_id
        LEFT JOIN colors c ON fc.color_id = c.color_id
        WHERE f.fabric_id = :fabric_id
        GROUP BY f.fabric_id
    ');
        $this->db->bind(':fabric_id', $fabric_id);
        return $this->db->single();
    }

    public function updateFabric($data)
    {
        $this->db->query('UPDATE fabrics SET fabric_name = :fabric_name, price_per_meter = :price, stock = :stock, image = :image WHERE fabric_id = :fabric_id');
        $this->db->bind(':fabric_name', $data['fabric_name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':fabric_id', $data['fabric_id']);

        if ($this->db->execute()) {
            // Delete existing fabric colors
            $this->db->query('DELETE FROM fabric_colors WHERE fabric_id = :fabric_id');
            $this->db->bind(':fabric_id', $data['fabric_id']);
            $this->db->execute();

            // Insert new fabric colors
            foreach ($data['colors'] as $color_id) {
                $this->db->query('INSERT INTO fabric_colors (fabric_id, color_id) VALUES (:fabric_id, :color_id)');
                $this->db->bind(':fabric_id', $data['fabric_id']);
                $this->db->bind(':color_id', $color_id);
                $this->db->execute();
            }
            return true;
        } else {
            return false;
        }
    }
    public function getSelectedColorsByFabricId($fabric_id)
    {
        $this->db->query('
        SELECT c.color_id, c.color_name
        FROM fabric_colors fc
        JOIN colors c ON fc.color_id = c.color_id
        WHERE fc.fabric_id = :fabric_id
    ');
        $this->db->bind(':fabric_id', $fabric_id);
        return $this->db->resultSet();
    }

    public function deleteFabric($fabric_id)
    {
        $this->db->query('DELETE FROM fabrics WHERE fabric_id = :fabric_id');
        $this->db->bind(':fabric_id', $fabric_id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getAppointmentsByTailorId($tailor_id)
    {
        $this->db->query('
        SELECT a.appointment_id, u.first_name, u.last_name, a.appointment_date, a.appointment_time, a.status
        FROM appointments a
        JOIN users u ON a.customer_id = u.user_id
        WHERE a.tailor_shopkeeper_id = :tailor_id
        ORDER BY a.appointment_date, a.appointment_time
    ');
        $this->db->bind(':tailor_id', $tailor_id);
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
            tailors.first_name AS tailor_first_name, 
            tailors.last_name AS tailor_last_name 
        FROM appointments 
        JOIN users ON appointments.customer_id = users.user_id 
        JOIN users AS tailors ON appointments.tailor_shopkeeper_id = tailors.user_id 
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
    public function getAppointmentsByMonth($tailor_id, $year, $month)
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
            WHERE a.tailor_shopkeeper_id = :tailor_id 
            AND YEAR(a.appointment_date) = :year 
            AND MONTH(a.appointment_date) = :month
        ');
        $this->db->bind(':tailor_id', $tailor_id);
        $this->db->bind(':year', $year);
        $this->db->bind(':month', $month);

        return $this->db->resultSet();
    }
}
