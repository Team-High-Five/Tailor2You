<?php

class M_Fabrics
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getFabricsByUserId($user_id)
    {
        $this->db->query('
            SELECT f.*, GROUP_CONCAT(c.color_name SEPARATOR ", ") AS colors
            FROM fabrics f
            LEFT JOIN fabric_colors fc ON f.fabric_id = fc.fabric_id
            LEFT JOIN colors c ON fc.color_id = c.color_id
            WHERE f.user_id = :user_id
            GROUP BY f.fabric_id
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function addFabric($data)
    {
        $this->db->query('INSERT INTO fabrics (user_id, fabric_name, price_per_meter, stock, image) VALUES (:user_id, :fabric_name, :price, :stock, :image)');
        $this->db->bind(':user_id', $data['user_id']);
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
            $this->db->query('DELETE FROM fabric_colors WHERE fabric_id = :fabric_id');
            $this->db->bind(':fabric_id', $data['fabric_id']);
            $this->db->execute();

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

    public function getColors()
    {
        $this->db->query('SELECT * FROM colors');
        return $this->db->resultSet();
    }
}
