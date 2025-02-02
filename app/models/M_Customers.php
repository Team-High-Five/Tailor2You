<?php

class M_Customers
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getShirtmeasurementsbyid($user_id){
        $this->db->query('SELECT * FROM shirt_measurements WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function updateShirtMeasurements($data) {
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
    
    public function createShirtMeasurements($data) {
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


    public function getPantmeasurementsbyid($user_id){
        $this->db->query('SELECT * FROM pant_measurements WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function updatePantMeasurements($data) {
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
    
    
    public function createPantMeasurements($data) {
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
    
    
}


