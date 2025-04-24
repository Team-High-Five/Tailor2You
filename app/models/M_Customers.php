<?php

class M_Customers
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getShirtmeasurementsbyid($user_id)
    {
        $this->db->query('SELECT * FROM shirt_measurements WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function updateShirtMeasurements($data)
    {
        $this->db->query('UPDATE shirt_measurements SET collar_size = :collar_size, chest_width = :chest_width, waist_width = :waist_width, bottom_width = :bottom_width, shoulder_width = :shoulder_width, sleeve_length = :sleeve_length, armhole_depth = :armhole_depth, bicep = :bicep, cuff_size = :cuff_size, front_length = :front_length, measure = :measure WHERE user_id = :user_id');
        $this->db->bind(':collar_size', $data['collar_size']);
        $this->db->bind(':chest_width', $data['chest_width']);
        $this->db->bind(':waist_width', $data['waist_width']);
        $this->db->bind(':bottom_width', $data['bottom_width']);
        $this->db->bind(':shoulder_width', $data['shoulder_width']);
        $this->db->bind(':sleeve_length', $data['sleeve_length']);
        $this->db->bind(':armhole_depth', $data['armhole_depth']);
        $this->db->bind(':bicep', $data['bicep']);
        $this->db->bind(':cuff_size', $data['cuff_size']);
        $this->db->bind(':front_length', $data['front_length']);
        $this->db->bind(':measure', $data['measure']);
        $this->db->bind(':user_id', $data['user_id']);
        return $this->db->execute();
    }

    public function createShirtMeasurements($data)
    {
        $this->db->query('INSERT INTO shirt_measurements (user_id, collar_size, chest_width, waist_width, bottom_width, shoulder_width, sleeve_length, armhole_depth, bicep, cuff_size, front_length, measure) VALUES (:user_id, :collar_size, :chest_width, :waist_width, :bottom_width, :shoulder_width, :sleeve_length, :armhole_depth, :bicep, :cuff_size, :front_length, :measure)');

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':collar_size', $data['collar_size']);
        $this->db->bind(':chest_width', $data['chest_width']);
        $this->db->bind(':waist_width', $data['waist_width']);
        $this->db->bind(':bottom_width', $data['bottom_width']);
        $this->db->bind(':shoulder_width', $data['shoulder_width']);
        $this->db->bind(':sleeve_length', $data['sleeve_length']);
        $this->db->bind(':armhole_depth', $data['armhole_depth']);
        $this->db->bind(':bicep', $data['bicep']);
        $this->db->bind(':cuff_size', $data['cuff_size']);
        $this->db->bind(':front_length', $data['front_length']);
        $this->db->bind(':measure', $data['measure']);

        return $this->db->execute();
    }


    public function getPantmeasurementsbyid($user_id)
    {
        $this->db->query('SELECT * FROM pant_measurements WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function updatePantMeasurements($data)
    {
        $this->db->query('UPDATE pant_measurements SET waist_width = :waist_width, seat = :seat, mid_thigh_width = :mid_thigh_width, inseam = :inseam, bottom_width = :bottom_width, rise_height_front = :rise_height_front, rise_height_back = :rise_height_back , measure = :measure WHERE user_id = :user_id');
        $this->db->bind(':waist_width', $data['waist_width']);
        $this->db->bind(':seat', $data['seat']);
        $this->db->bind(':mid_thigh_width', $data['mid_thigh_width']);
        $this->db->bind(':inseam', $data['inseam']);
        $this->db->bind(':bottom_width', $data['bottom_width']);
        $this->db->bind(':rise_height_front', $data['rise_height_front']);
        $this->db->bind(':rise_height_back', $data['rise_height_back']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':measure', $data['measure']);

        return $this->db->execute();
    }


    public function createPantMeasurements($data)
    {
        $this->db->query('INSERT INTO pant_measurements (user_id, waist_width, seat, mid_thigh_width, inseam, bottom_width, rise_height_front, rise_height_back , measure) VALUES (:user_id, :waist_width, :seat, :mid_thigh_width, :inseam, :bottom_width, :rise_height_front, :rise_height_back , :measure)');

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':waist_width', $data['waist_width']);
        $this->db->bind(':seat', $data['seat']);
        $this->db->bind(':mid_thigh_width', $data['mid_thigh_width']);
        $this->db->bind(':inseam', $data['inseam']);
        $this->db->bind(':bottom_width', $data['bottom_width']);
        $this->db->bind(':rise_height_front', $data['rise_height_front']);
        $this->db->bind(':rise_height_back', $data['rise_height_back']);
        $this->db->bind(':measure', $data['measure']);

        return $this->db->execute();
    }
    public function getCustomerAppointments($customer_id)
    {
        $this->db->query('SELECT a.*, 
                      u.first_name as tailor_first_name, 
                      u.last_name as tailor_last_name,
                      u.profile_pic as tailor_profile_pic
                      FROM appointments a 
                      LEFT JOIN users u ON a.tailor_shopkeeper_id = u.user_id 
                      WHERE a.customer_id = :customer_id 
                      ORDER BY a.appointment_date DESC, a.appointment_time DESC');

        $this->db->bind(':customer_id', $customer_id);
        return $this->db->resultSet();
    }

    public function getCustomerOrders($customer_id){
        $this->db->query('Select o.*,oi.*, oi.status as order_status, u.*, d.* from orders as o join order_items as oi on oi.order_id=o.order_id join users as u on u.user_id=o.tailor_id join designs as d on d.design_id = oi.design_id where o.customer_id = :customer_id');
        $this->db->bind(':customer_id', $customer_id);
        return $this->db->resultSet();
    }

    public function getCustomerOrder($customer_id, $order_id){
        $this->db->query('Select d.description as design_description, o.*,oi.*, oi.status as order_status, u.*, d.*, f.*,c.* from orders as o join order_items as oi on oi.order_id=o.order_id join users as u on u.user_id=o.tailor_id join designs as d on d.design_id = oi.design_id join colors as c on c.color_id = oi.color_id join fabrics as f on f.fabric_id=oi.fabric_id where o.customer_id = :customer_id and o.order_id = :order_id');
        $this->db->bind(':customer_id', $customer_id);
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }
    public function getShirtMeasurements($user_id)
    {
        $this->db->query('SELECT m.measurement_id, m.name, m.display_name, m.description, 
                         um.value_cm, um.value_inch, cm.is_required, cm.display_order
                         FROM measurements m
                         JOIN category_measurements cm ON m.measurement_id = cm.measurement_id
                         LEFT JOIN user_measurements um ON m.measurement_id = um.measurement_id 
                         AND um.user_id = :user_id
                         WHERE cm.category_id = 1
                         ORDER BY cm.display_order');
        
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function getPantMeasurements($user_id)
    {
        $this->db->query('SELECT m.measurement_id, m.name, m.display_name, m.description, 
                         um.value_cm, um.value_inch, cm.is_required, cm.display_order
                         FROM measurements m
                         JOIN category_measurements cm ON m.measurement_id = cm.measurement_id
                         LEFT JOIN user_measurements um ON m.measurement_id = um.measurement_id 
                         AND um.user_id = :user_id
                         WHERE cm.category_id = 2
                         ORDER BY cm.display_order');
        
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function updateUserMeasurements($data) {
        try {
            $this->db->beginTransaction();

            foreach ($data['measurements'] as $measurement) {
                $this->db->query('INSERT INTO user_measurements 
                                (user_id, measurement_id, value_cm, value_inch) 
                                VALUES (:user_id, :measurement_id, :value_cm, :value_inch)
                                ON DUPLICATE KEY UPDATE 
                                value_cm = :value_cm, 
                                value_inch = :value_inch');

                $this->db->bind(':user_id', $data['user_id']);
                $this->db->bind(':measurement_id', $measurement['id']);
                $this->db->bind(':value_cm', $measurement['cm']);
                $this->db->bind(':value_inch', $measurement['inch']);

                if (!$this->db->execute()) {
                    throw new Exception('Failed to update measurement');
                }
            }

            $this->db->commitTransaction();
            return true;
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log('Error updating measurements: ' . $e->getMessage());
            return false;
        }
    }
}
