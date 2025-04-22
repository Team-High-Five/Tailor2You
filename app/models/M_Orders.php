<?php

class M_Orders
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getDesigns($limit = null, $filters = [])
    {
        $sql = 'SELECT d.*, cc.name as category_name, cs.name as subcategory_name
                FROM designs d
                JOIN clothing_categories cc ON d.category_id = cc.category_id
                JOIN clothing_subcategories cs ON d.subcategory_id = cs.subcategory_id
                WHERE d.status = :status';

        $params = [':status' => 'active'];

        // Add category filter if provided
        if (isset($filters['category_id'])) {
            $sql .= ' AND d.category_id = :category_id';
            $params[':category_id'] = $filters['category_id'];
        }

        // Add gender filter if provided
        if (isset($filters['gender'])) {
            $sql .= ' AND (d.gender = :gender OR d.gender = "unisex")';
            $params[':gender'] = $filters['gender'];
        }

        // Add tailor filter if provided
        if (isset($filters['tailor_id'])) {
            $sql .= ' AND d.user_id = :tailor_id';
            $params[':tailor_id'] = $filters['tailor_id'];
        }

        $sql .= ' ORDER BY d.created_at DESC';

        // Add limit if provided
        if ($limit) {
            $sql .= ' LIMIT :limit';
            $params[':limit'] = $limit;
        }

        $this->db->query($sql);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        return $this->db->resultSet();
    }

    public function getDesignById($id)
    {
        $this->db->query('SELECT d.*, cc.name as category_name, cs.name as subcategory_name, u.first_name, u.last_name
                          FROM designs d
                          JOIN clothing_categories cc ON d.category_id = cc.category_id
                          JOIN clothing_subcategories cs ON d.subcategory_id = cs.subcategory_id
                          JOIN users u ON d.user_id = u.user_id
                          WHERE d.design_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getFabricsByDesignId($designId)
    {
        $this->db->query('SELECT f.*, df.price_adjustment
                          FROM fabrics f
                          JOIN design_fabrics df ON f.fabric_id = df.fabric_id
                          WHERE df.design_id = :design_id
                          ORDER BY f.fabric_name');
        $this->db->bind(':design_id', $designId);
        return $this->db->resultSet();
    }

    public function getColorsByFabricId($fabricId)
    {
        $this->db->query('SELECT c.* 
                          FROM colors c
                          JOIN fabric_colors fc ON c.color_id = fc.color_id
                          WHERE fc.fabric_id = :fabric_id
                          ORDER BY c.color_name');
        $this->db->bind(':fabric_id', $fabricId);
        return $this->db->resultSet();
    }

    public function getFabricById($fabricId, $designId = null)
    {
        if ($designId) {
            $this->db->query('SELECT f.*, df.price_adjustment 
                              FROM fabrics f 
                              JOIN design_fabrics df ON f.fabric_id = df.fabric_id 
                              WHERE f.fabric_id = :fabric_id AND df.design_id = :design_id');
            $this->db->bind(':fabric_id', $fabricId);
            $this->db->bind(':design_id', $designId);
        } else {
            // Fallback to just getting the fabric without price adjustment
            $this->db->query('SELECT * FROM fabrics WHERE fabric_id = :id');
            $this->db->bind(':id', $fabricId);
        }
        return $this->db->single();
    }

    public function getColorById($colorId)
    {
        $this->db->query('SELECT * FROM colors WHERE color_id = :id');
        $this->db->bind(':id', $colorId);
        return $this->db->single();
    }

    public function getCustomizationTypesByDesignId($designId)
    {
        $this->db->query('SELECT ct.*
                          FROM customization_types ct
                          JOIN designs d ON ct.category_id = d.category_id
                          WHERE d.design_id = :design_id
                          ORDER BY ct.name');
        $this->db->bind(':design_id', $designId);
        return $this->db->resultSet();
    }
    public function getCustomizationChoicesByTypeId($typeId)
    {
        $this->db->query('SELECT * FROM customization_choices WHERE type_id = :type_id ORDER BY name');
        $this->db->bind(':type_id', $typeId);
        return $this->db->resultSet();
    }

    public function getDesignCustomizationChoices($designId, $typeId)
    {
        $this->db->query('SELECT cc.*
                          FROM customization_choices cc
                          JOIN design_customizations dc ON cc.choice_id = dc.choice_id
                          WHERE dc.design_id = :design_id AND cc.type_id = :type_id
                          ORDER BY cc.name');
        $this->db->bind(':design_id', $designId);
        $this->db->bind(':type_id', $typeId);
        return $this->db->resultSet();
    }

    public function getCustomizationChoiceById($choiceId)
    {
        $this->db->query('SELECT * FROM customization_choices WHERE choice_id = :choice_id');
        $this->db->bind(':choice_id', $choiceId);
        return $this->db->single();
    }

    // Calculate design price with selected options
    public function calculateDesignPrice($designId, $fabricId = null, $customizations = [])
    {
        // Get base design price
        $design = $this->getDesignById($designId);
        $totalPrice = $design->base_price;

        // Add fabric price adjustment if provided
        if ($fabricId) {
            $this->db->query('SELECT price_adjustment FROM design_fabrics 
                              WHERE design_id = :design_id AND fabric_id = :fabric_id');
            $this->db->bind(':design_id', $designId);
            $this->db->bind(':fabric_id', $fabricId);
            $fabricAdjustment = $this->db->single();

            if ($fabricAdjustment) {
                $totalPrice += $fabricAdjustment->price_adjustment;
            }
        }

        // Add customization price adjustments
        if (!empty($customizations)) {
            foreach ($customizations as $choiceId) {
                $this->db->query('SELECT price_adjustment FROM customization_choices 
                                  WHERE choice_id = :choice_id');
                $this->db->bind(':choice_id', $choiceId);
                $customAdjustment = $this->db->single();

                if ($customAdjustment) {
                    $totalPrice += $customAdjustment->price_adjustment;
                }
            }
        }

        return $totalPrice;
    }
    // Add after existing methods

    // Get measurements required for a design category
    public function getMeasurementsByDesignId($designId)
    {
        // Get main measurements from design_measurements table
        $this->db->query('SELECT m.*, dm.is_required, dm.description as custom_description
                     FROM measurements m
                     JOIN design_measurements dm ON m.measurement_id = dm.measurement_id
                     WHERE dm.design_id = :design_id
                     ORDER BY dm.display_order');
        $this->db->bind(':design_id', $designId);
        $measurements = $this->db->resultSet();

        // Get any custom measurements specific to this design
        $this->db->query('SELECT * FROM custom_design_measurements 
                     WHERE design_id = :design_id 
                     ORDER BY display_order');
        $this->db->bind(':design_id', $designId);
        $customMeasurements = $this->db->resultSet();

        // Get default ranges for common measurements
        $this->db->query('SELECT m.name, mr.min_value, mr.max_value, mr.increment
                     FROM measurements m
                     LEFT JOIN measurement_ranges mr ON m.measurement_id = mr.measurement_id
                     WHERE m.measurement_id IN (SELECT measurement_id FROM design_measurements WHERE design_id = :design_id)');
        $this->db->bind(':design_id', $designId);
        $measurementRanges = $this->db->resultSet();

        // Create lookup array for ranges
        $ranges = [];
        foreach ($measurementRanges as $range) {
            $ranges[$range->name] = [
                'min' => $range->min_value ?? 5, // Default min if null
                'max' => $range->max_value ?? 60, // Default max if null
                'increment' => $range->increment ?? 0.5 // Default increment if null
            ];
        }

        return [
            'measurements' => $measurements,
            'customMeasurements' => $customMeasurements,
            'ranges' => $ranges
        ];
    }

    // Get user's existing measurements if available
    public function getUserMeasurements($userId)
    {
        $this->db->query('SELECT m.name, um.value
                     FROM user_measurements um
                     JOIN measurements m ON um.measurement_id = m.measurement_id
                     WHERE um.user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();

        $measurements = [];
        foreach ($results as $result) {
            $measurements[$result->name] = $result->value;
        }

        return $measurements;
    }

    // Save measurements to session or database
    public function saveMeasurements($orderItemId, $measurements, $userId = null)
    {
        // First save to order item measurements
        foreach ($measurements as $measurementId => $value) {
            $this->db->query('INSERT INTO order_item_measurements 
                         (item_id, measurement_id, value, measurement_source) 
                         VALUES (:item_id, :measurement_id, :value, :source)
                         ON DUPLICATE KEY UPDATE value = :value');
            $this->db->bind(':item_id', $orderItemId);
            $this->db->bind(':measurement_id', $measurementId);
            $this->db->bind(':value', $value);
            $this->db->bind(':source', $userId ? 'profile' : 'manual');
            $this->db->execute();
        }

        // Also save to user profile if user is logged in
        if ($userId) {
            foreach ($measurements as $measurementId => $value) {
                $this->db->query('INSERT INTO user_measurements 
                             (user_id, measurement_id, value) 
                             VALUES (:user_id, :measurement_id, :value)
                             ON DUPLICATE KEY UPDATE value = :value');
                $this->db->bind(':user_id', $userId);
                $this->db->bind(':measurement_id', $measurementId);
                $this->db->bind(':value', $value);
                $this->db->execute();
            }
        }

        return true;
    }
    public function getMeasurementNames()
    {
        $this->db->query('SELECT measurement_id, display_name FROM measurements');
        $results = $this->db->resultSet();

        $names = [];
        foreach ($results as $row) {
            $names[$row->measurement_id] = $row->display_name;
        }

        return $names;
    }
}
