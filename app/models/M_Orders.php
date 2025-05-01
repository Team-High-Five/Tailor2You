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

        if (isset($filters['category_id'])) {
            $sql .= ' AND d.category_id = :category_id';
            $params[':category_id'] = $filters['category_id'];
        }

        if (isset($filters['gender'])) {
            $sql .= ' AND (d.gender = :gender OR d.gender = "unisex")';
            $params[':gender'] = $filters['gender'];
        }

        if (isset($filters['tailor_id'])) {
            $sql .= ' AND d.user_id = :tailor_id';
            $params[':tailor_id'] = $filters['tailor_id'];
        }

        $sql .= ' ORDER BY d.created_at DESC';
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
    public function calculateDesignPrice($designId, $fabricId = null, $customizations = [])
    {
        $design = $this->getDesignById($designId);
        $totalPrice = $design->base_price;
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
    public function getMeasurementsByDesignId($designId)
    {
        $this->db->query('SELECT m.*, dm.is_required, dm.description as custom_description
                     FROM measurements m
                     JOIN design_measurements dm ON m.measurement_id = dm.measurement_id
                     WHERE dm.design_id = :design_id
                     ORDER BY dm.display_order');
        $this->db->bind(':design_id', $designId);
        $measurements = $this->db->resultSet();
        $this->db->query('SELECT * FROM custom_design_measurements 
                     WHERE design_id = :design_id 
                     ORDER BY display_order');
        $this->db->bind(':design_id', $designId);
        $customMeasurements = $this->db->resultSet();
        $this->db->query('SELECT m.name, mr.min_value, mr.max_value, mr.increment
                     FROM measurements m
                     LEFT JOIN measurement_ranges mr ON m.measurement_id = mr.measurement_id
                     WHERE m.measurement_id IN (SELECT measurement_id FROM design_measurements WHERE design_id = :design_id)');
        $this->db->bind(':design_id', $designId);
        $measurementRanges = $this->db->resultSet();
        $ranges = [];
        foreach ($measurementRanges as $range) {
            $ranges[$range->name] = [
                'min' => $range->min_value ?? 5,
                'max' => $range->max_value ?? 60,
                'increment' => $range->increment ?? 0.5
            ];
        }

        return [
            'measurements' => $measurements,
            'customMeasurements' => $customMeasurements,
            'ranges' => $ranges
        ];
    }    public function getUserMeasurements($userId)
    {
        $this->db->query('SELECT m.name, um.value_inch
                     FROM user_measurements um
                     JOIN measurements m ON um.measurement_id = m.measurement_id
                     WHERE um.user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $results = $this->db->resultSet();
        if(empty($results)) {
            return []; 
        }
        $measurements = [];
        foreach ($results as $result) {
            $measurements[$result->name] = $result->value_inch;
        }

        return $measurements;
    }
    public function saveMeasurements($orderItemId, $measurements, $userId = null)
    {
 
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
    public function generateOrderId()
    {
        $this->db->query('SELECT next_value FROM order_sequence WHERE id = 1');
        $result = $this->db->single();

        if (!$result) {
            $this->db->query('INSERT INTO order_sequence (id, next_value) VALUES (1, 1)');
            $nextValue = 1;
        } else {
            $nextValue = $result->next_value;
        }
        $orderId = 'T2Y-' . str_pad($nextValue, 5, '0', STR_PAD_LEFT);
        $nextValue = $nextValue + 1;
        $this->db->query('UPDATE `order_sequence` SET `next_value` = :nextValue WHERE `order_sequence`.`id` = 1;');
        $this->db->bind(':nextValue', $nextValue);
        $this->db->execute();
        return $orderId;
    }

    public function createOrder($orderData)
    {
        try {
            $this->db->beginTransaction();
            $orderId = $orderData['order_id'];
            $this->db->query('INSERT INTO orders (
            order_id, customer_id, tailor_id, total_amount, 
            tax_amount, final_amount, appointment_id, 
            delivery_address, expected_delivery_date, notes
        ) VALUES (
            :order_id, :customer_id, :tailor_id, :total_amount, 
            :tax_amount, :final_amount, :appointment_id, 
            :delivery_address, DATE_ADD(CURRENT_DATE, INTERVAL 14 DAY), :notes
        )');

            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':customer_id', $orderData['customer_id']);
            $this->db->bind(':tailor_id', $orderData['tailor_id']);
            $this->db->bind(':total_amount', $orderData['total_amount']);
            $this->db->bind(':tax_amount', $orderData['tax_amount']);
            $this->db->bind(':final_amount', $orderData['final_amount']);
            $this->db->bind(':appointment_id', $orderData['appointment_id'] ?? null);
            $this->db->bind(':delivery_address', $orderData['delivery_address']);
            $this->db->bind(':notes', $orderData['notes'] ?? null);

            $this->db->execute();
            foreach ($orderData['items'] as $item) {
                $this->db->query('INSERT INTO order_items (
                    order_id, design_id, fabric_id, color_id, quantity, 
                    base_price, customization_price, fabric_price, total_price
                ) VALUES (
                    :order_id, :design_id, :fabric_id, :color_id, :quantity,
                    :base_price, :customization_price, :fabric_price, :total_price
                )');

                $this->db->bind(':order_id', $orderId);
                $this->db->bind(':design_id', $item['design_id']);
                $this->db->bind(':fabric_id', $item['fabric_id']);
                $this->db->bind(':color_id', $item['color_id']);
                $this->db->bind(':quantity', $item['quantity'] ?? 1);
                $this->db->bind(':base_price', $item['base_price']);
                $this->db->bind(':customization_price', $item['customization_price'] ?? 0);
                $this->db->bind(':fabric_price', $item['fabric_price'] ?? 0);
                $this->db->bind(':total_price', $item['total_price']);

                $this->db->execute();

                $itemId = $this->db->lastInsertId();

                if (!empty($item['customizations'])) {
                    $this->addOrderItemCustomizations($itemId, $item['customizations']);
                }
                if (!empty($item['measurements'])) {
                    $this->addOrderItemMeasurements($itemId, $item['measurements']);
                }
            }

            $this->db->commitTransaction();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log('Order creation error: ' . $e->getMessage());
            return false;
        }
    }

    public function addOrderItemCustomizations($itemId, $customizations)
    {
        try {
            foreach ($customizations as $typeId => $choiceId) {
                $this->db->query('SELECT cc.*, ct.name as type_name 
                             FROM customization_choices cc
                             JOIN customization_types ct ON cc.type_id = ct.type_id
                             WHERE cc.choice_id = :choice_id');
                $this->db->bind(':choice_id', $choiceId);
                $choice = $this->db->single();

                if (!$choice) {
                    continue; 
                }

                $this->db->query('INSERT INTO order_item_customizations 
                             (item_id, type_id, choice_id, price_adjustment) 
                             VALUES (:item_id, :type_id, :choice_id, :price_adjustment)');

                $this->db->bind(':item_id', $itemId);
                $this->db->bind(':type_id', $choice->type_id);
                $this->db->bind(':choice_id', $choiceId);
                $this->db->bind(':price_adjustment', $choice->price_adjustment ?? 0);

                $this->db->execute();
            }

            return true;
        } catch (Exception $e) {
            error_log('Error adding order item customizations: ' . $e->getMessage());
            return false;
        }
    }
    public function addOrderItemMeasurements($itemId, $measurements)
    {
        try {
            foreach ($measurements as $key => $value) {
                if (strpos($key, 'measurement_') === 0) {
                    $measurementId = substr($key, 12);
                    if (is_numeric($measurementId) && is_numeric($value)) {
                        $this->db->query('INSERT INTO order_item_measurements 
                                     (item_id, measurement_id, value, measurement_source) 
                                     VALUES (:item_id, :measurement_id, :value, :source)');

                        $this->db->bind(':item_id', $itemId);
                        $this->db->bind(':measurement_id', $measurementId);
                        $this->db->bind(':value', $value);
                        $this->db->bind(':source', 'manual');

                        $this->db->execute();
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            error_log('Error adding order item measurements: ' . $e->getMessage());
            return false;
        }
    }
    public function createAppointment($appointmentData)
    {
        try {
            $this->db->query('INSERT INTO appointments (
            customer_id, tailor_shopkeeper_id, appointment_date, 
            appointment_time,  status
        ) VALUES (
            :customer_id, :tailor_id, :appointment_date, 
            :appointment_time,:status
        )');

            $this->db->bind(':customer_id', $appointmentData['customer_id']);
            $this->db->bind(':tailor_id', $appointmentData['tailor_shopkeeper_id']);
            $this->db->bind(':appointment_date', $appointmentData['appointment_date']);
            $this->db->bind(':appointment_time', $appointmentData['appointment_time']);
            $this->db->bind(':location_type', $appointmentData['location_type']);
            $this->db->bind(':status', $appointmentData['status']);

            $this->db->execute();

            return $this->db->lastInsertId();
        } catch (Exception $e) {
            error_log('Error creating appointment: ' . $e->getMessage());
            return false;
        }
    }

    public function getUserAddress($userId)
    {
        $this->db->query('SELECT * FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }
    public function updateOrderStatus($orderId, $newStatus, $notes = null)
    {
        try {
            $this->db->beginTransaction();
            $this->db->query('UPDATE orders SET status = :status WHERE order_id = :order_id');
            $this->db->bind(':status', $newStatus);
            $this->db->bind(':order_id', $orderId);

            if (!$this->db->execute()) {
                throw new Exception('Failed to update order status');
            }
            $this->db->query('INSERT INTO order_status_history 
                        (order_id, status, updated_by, notes) 
                        VALUES (:order_id, :status, :updated_by, :notes)');

            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':status', $newStatus);
            $this->db->bind(':updated_by', $_SESSION['user_id']);
            $this->db->bind(':notes', $notes);

            if (!$this->db->execute()) {
                throw new Exception('Failed to record status history');
            }

            $this->db->commitTransaction();
            return true;
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log('Error updating order status: ' . $e->getMessage());
            return false;
        }
    }
    public function getOrders() {
        $this->db->query('SELECT * FROM orders');
        return $this->db->resultSet();
    }
}
