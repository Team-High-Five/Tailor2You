<?php

class M_Appointments
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
        return $this->db->single();
    }

    public function createAppointment($data)
    {
        $this->db->query('INSERT INTO appointments (customer_id, tailor_shopkeeper_id, appointment_date, appointment_time) VALUES (:customer_id, :tailor_id, :appointment_date, :appointment_time)');

        $this->db->bind(':customer_id', $_SESSION['user_id']);
        $this->db->bind(':tailor_id', $data['tailor_id']);
        $this->db->bind(':appointment_date', $data['appointment_date']);
        $this->db->bind(':appointment_time', $data['appointment_time']);

        return $this->db->execute();
    }
    public function getBookedTimeSlots($tailor_id, $date)
    {
        $this->db->query('SELECT appointment_time FROM appointments 
                      WHERE tailor_shopkeeper_id = :tailor_id 
                      AND appointment_date = :date 
                      AND status != "rejected"');

        $this->db->bind(':tailor_id', $tailor_id);
        $this->db->bind(':date', $date);

        $results = $this->db->resultSet();

        $bookedSlots = [];
        foreach ($results as $result) {
            $bookedSlots[] = $result->appointment_time;
        }

        return $bookedSlots;
    }
}
