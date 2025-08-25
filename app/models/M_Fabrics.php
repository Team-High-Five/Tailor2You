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

    public function getFabricById($fabricId)
    {
        $this->db->query('
            SELECT f.*, GROUP_CONCAT(c.color_name SEPARATOR ", ") AS colors
            FROM fabrics f
            LEFT JOIN fabric_colors fc ON f.fabric_id = fc.fabric_id
            LEFT JOIN colors c ON fc.color_id = c.color_id
            WHERE f.fabric_id = :fabric_id
            GROUP BY f.fabric_id
        ');
        $this->db->bind(':fabric_id', $fabricId);
        return $this->db->single();
    }

    public function updateFabric($data)
    {
        // Step 1: Update fabric details - Execute this immediately
        $this->db->query('UPDATE fabrics SET fabric_name = :fabric_name, price_per_meter = :price, stock = :stock WHERE fabric_id = :fabric_id');
        $this->db->bind(':fabric_name', $data['fabric_name']);
        $this->db->bind(':price', floatval($data['price']));
        $this->db->bind(':stock', floatval($data['stock']));
        $this->db->bind(':fabric_id', $data['fabric_id']);
        $mainUpdateSuccess = $this->db->execute();  // Execute immediately

        // Step 2: Only update image if a new one was uploaded - As a separate query
        $imageUpdateSuccess = true;  // Default to true if no image update needed
        if ($data['image']) {
            $this->db->query('UPDATE fabrics SET image = :image WHERE fabric_id = :fabric_id');
            $this->db->bind(':image', $data['image']);
            $this->db->bind(':fabric_id', $data['fabric_id']);
            $imageUpdateSuccess = $this->db->execute();  // Execute the image update
        }

        // Step 3: Delete existing color relationships
        $this->db->query('DELETE FROM fabric_colors WHERE fabric_id = :fabric_id');
        $this->db->bind(':fabric_id', $data['fabric_id']);
        $colorDeleteSuccess = $this->db->execute();

        // Step 4: Insert new color relationships
        $colorSuccess = true;
        if (!empty($data['colors'])) {
            foreach ($data['colors'] as $color_id) {
                $this->db->query('INSERT INTO fabric_colors (fabric_id, color_id) VALUES (:fabric_id, :color_id)');
                $this->db->bind(':fabric_id', $data['fabric_id']);
                $this->db->bind(':color_id', $color_id);
                if (!$this->db->execute()) {
                    $colorSuccess = false;
                }
            }
        }

        // Return true only if all operations were successful
        return $mainUpdateSuccess && $imageUpdateSuccess && $colorDeleteSuccess && $colorSuccess;
    }
    public function checkFabricLinkOnDesign($fabric_id)
    {
        $this->db->query('SELECT COUNT(*) AS count FROM design_fabrics WHERE fabric_id = :fabric_id');
        $this->db->bind(':fabric_id', $fabric_id);
        return $this->db->single()->count > 0;
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

    public function getFabricImage($fabric_id)
    {
        $this->db->query('SELECT image FROM fabrics WHERE fabric_id = :fabric_id');
        $this->db->bind(':fabric_id', $fabric_id);
        return $this->db->single();
    }

    public function getAllFabrics()
    {
        $this->db->query('SELECT * FROM fabrics ORDER BY fabric_id ASC'); // Order by fabric_id in ascending order
        return $this->db->resultSet();
    }

    public function getFabricsCount()
    {
        $this->db->query('SELECT COUNT(*) AS count FROM fabrics');
        return $this->db->single()->count;
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }
}
