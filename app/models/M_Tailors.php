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
    public function getDashboardStats($tailor_id)
    {
        // Get total orders count
        $this->db->query("SELECT COUNT(*) as total_orders FROM orders WHERE tailor_id = :tailor_id");
        $this->db->bind(':tailor_id', $tailor_id);
        $totalOrders = $this->db->single()->total_orders;

        // Get previous week orders for comparison
        $this->db->query("SELECT COUNT(*) as prev_week_orders FROM orders 
                     WHERE tailor_id = :tailor_id 
                     AND order_date BETWEEN DATE_SUB(NOW(), INTERVAL 2 WEEK) AND DATE_SUB(NOW(), INTERVAL 1 WEEK)");
        $this->db->bind(':tailor_id', $tailor_id);
        $prevWeekOrders = $this->db->single()->prev_week_orders;

        // Get current week orders for comparison
        $this->db->query("SELECT COUNT(*) as current_week_orders FROM orders 
                     WHERE tailor_id = :tailor_id 
                     AND order_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK)");
        $this->db->bind(':tailor_id', $tailor_id);
        $currentWeekOrders = $this->db->single()->current_week_orders;

        // Calculate order percentage change
        $orderPercentChange = 0;
        if ($prevWeekOrders > 0) {
            $orderPercentChange = round((($currentWeekOrders - $prevWeekOrders) / $prevWeekOrders) * 100, 1);
        }

        // Get total sales amount
        $this->db->query("SELECT SUM(total_amount) as total_sales FROM orders WHERE tailor_id = :tailor_id");
        $this->db->bind(':tailor_id', $tailor_id);
        $totalSales = $this->db->single()->total_sales ?? 0;

        // Get yesterday's sales
        $this->db->query("SELECT SUM(total_amount) as yesterday_sales FROM orders 
                     WHERE tailor_id = :tailor_id 
                     AND DATE(order_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        $this->db->bind(':tailor_id', $tailor_id);
        $yesterdaySales = $this->db->single()->yesterday_sales ?? 0;

        // Get today's sales
        $this->db->query("SELECT SUM(total_amount) as today_sales FROM orders 
                     WHERE tailor_id = :tailor_id 
                     AND DATE(order_date) = CURDATE()");
        $this->db->bind(':tailor_id', $tailor_id);
        $todaySales = $this->db->single()->today_sales ?? 0;

        // Calculate sales percentage change
        $salesPercentChange = 0;
        if ($yesterdaySales > 0) {
            $salesPercentChange = round((($todaySales - $yesterdaySales) / $yesterdaySales) * 100, 1);
        }

        // Get total appointments count
        $this->db->query("SELECT COUNT(*) as total_appointments FROM appointments 
                     WHERE tailor_shopkeeper_id = :tailor_id");
        $this->db->bind(':tailor_id', $tailor_id);
        $totalAppointments = $this->db->single()->total_appointments;

        // Get yesterday's appointments
        $this->db->query("SELECT COUNT(*) as yesterday_appointments FROM appointments 
                     WHERE tailor_shopkeeper_id = :tailor_id 
                     AND DATE(appointment_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
        $this->db->bind(':tailor_id', $tailor_id);
        $yesterdayAppointments = $this->db->single()->yesterday_appointments;

        // Get today's appointments
        $this->db->query("SELECT COUNT(*) as today_appointments FROM appointments 
                     WHERE tailor_shopkeeper_id = :tailor_id 
                     AND DATE(appointment_date) = CURDATE()");
        $this->db->bind(':tailor_id', $tailor_id);
        $todayAppointments = $this->db->single()->today_appointments;

        // Calculate appointments percentage change
        $appointmentPercentChange = 0;
        if ($yesterdayAppointments > 0) {
            $appointmentPercentChange = round((($todayAppointments - $yesterdayAppointments) / $yesterdayAppointments) * 100, 1);
        }

        return [
            'total_orders' => $totalOrders,
            'order_percent_change' => $orderPercentChange,
            'total_sales' => $totalSales,
            'sales_percent_change' => $salesPercentChange,
            'total_appointments' => $totalAppointments,
            'appointment_percent_change' => $appointmentPercentChange
        ];
    }

    public function getMonthlySalesData($tailor_id)
    {
        $this->db->query("SELECT 
                        MONTH(order_date) as month,
                        MONTHNAME(order_date) as month_name,
                        SUM(total_amount) as monthly_sales
                      FROM orders
                      WHERE tailor_id = :tailor_id
                      AND YEAR(order_date) = YEAR(CURDATE())
                      GROUP BY MONTH(order_date), MONTHNAME(order_date)
                      ORDER BY MONTH(order_date)");
        $this->db->bind(':tailor_id', $tailor_id);
        return $this->db->resultSet();
    }

    public function getOrderStatusCounts($tailor_id)
    {
        $this->db->query("SELECT 
                        status,
                        COUNT(*) as count
                      FROM orders
                      WHERE tailor_id = :tailor_id
                      GROUP BY status");
        $this->db->bind(':tailor_id', $tailor_id);
        return $this->db->resultSet();
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
    public function createRescheduleRequest($data)
    {
        $this->db->query('INSERT INTO reschedule_requests 
                     (appointment_id, requested_by, proposed_date, proposed_time, reason) 
                     VALUES (:appointment_id, :requested_by, :proposed_date, :proposed_time, :reason)');

        $this->db->bind(':appointment_id', $data['appointment_id']);
        $this->db->bind(':requested_by', 'tailor'); // Since this is from the tailor
        $this->db->bind(':proposed_date', $data['proposed_date']);
        $this->db->bind(':proposed_time', $data['proposed_time']);
        $this->db->bind(':reason', $data['reason']);

        // Update appointment status to indicate a reschedule is pending
        if ($this->db->execute()) {
            $this->db->query('UPDATE appointments 
                         SET status = "reschedule_pending" 
                         WHERE appointment_id = :appointment_id');
            $this->db->bind(':appointment_id', $data['appointment_id']);
            return $this->db->execute();
        }

        return false;
    }
    public function getRescheduleRequestsForCustomer($customerId)
    {
        $this->db->query('SELECT r.*, a.customer_id, a.appointment_date as original_date, 
                    a.appointment_time as original_time, u.first_name, u.last_name 
                    FROM reschedule_requests r 
                    JOIN appointments a ON r.appointment_id = a.appointment_id 
                    JOIN users u ON a.tailor_shopkeeper_id = u.user_id 
                    WHERE a.customer_id = :customer_id AND r.status = "pending"');

        $this->db->bind(':customer_id', $customerId);
        return $this->db->resultSet();
    }
    public function getOrdersByTailorId($tailor_id, $filters = [])
    {
        $sql = 'SELECT o.*, 
            u.first_name, u.last_name,
            d.name as design_name,d.description as design_description, d.main_image as design_image,
            DATE_FORMAT(o.order_date, "%d %b %Y") as formatted_date
            FROM orders o
            JOIN users u ON o.customer_id = u.user_id
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN designs d ON oi.design_id = d.design_id
            WHERE o.tailor_id = :tailor_id';

        // Add filters if provided
        if (!empty($filters['date'])) {
            $sql .= ' AND DATE(o.order_date) = :date';
        }

        if (!empty($filters['status'])) {
            $sql .= ' AND o.status = :status';
        }

        // Group by order_id to avoid duplicates if multiple items in one order
        $sql .= ' GROUP BY o.order_id ORDER BY o.order_date DESC';

        $this->db->query($sql);
        $this->db->bind(':tailor_id', $tailor_id);

        // Bind filter parameters if they exist
        if (!empty($filters['date'])) {
            $this->db->bind(':date', $filters['date']);
        }

        if (!empty($filters['status'])) {
            $this->db->bind(':status', $filters['status']);
        }

        return $this->db->resultSet();
    }

    public function getOrderStatusOptions()
    {
        return [
            'order_placed' => 'Order Placed',
            'fabric_cutting' => 'Fabric Cutting',
            'stitching' => 'Stitching',
            'ready_for_delivery' => 'Ready for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];
    }
    public function getOrderById($order_id)
    {
        // Fetch basic order info
        $this->db->query('
            SELECT o.*, 
                   u.first_name, u.last_name, u.profile_pic,
                   DATE_FORMAT(o.order_date, "%d %b %Y") as formatted_date
            FROM orders o
            JOIN users u ON o.customer_id = u.user_id
            WHERE o.order_id = :order_id
        ');
        $this->db->bind(':order_id', $order_id);
        $order = $this->db->single();

        if (!$order) {
            return false;
        }

        // Fetch order items
        $this->db->query('
        SELECT oi.*, 
               d.name as design_name, d.description as design_description, d.main_image as design_image,
               f.fabric_name, 
               c.color_name
        FROM order_items oi
        JOIN designs d ON oi.design_id = d.design_id
        JOIN fabrics f ON oi.fabric_id = f.fabric_id
        JOIN colors c ON oi.color_id = c.color_id
        WHERE oi.order_id = :order_id
    ');
        $this->db->bind(':order_id', $order_id);
        $order->items = $this->db->resultSet();

        // Fetch measurements for each item (existing code)
        foreach ($order->items as $item) {
            $this->db->query('
            SELECT oim.*, m.name as measurement_name, m.display_name
            FROM order_item_measurements oim
            JOIN measurements m ON oim.measurement_id = m.measurement_id
            WHERE oim.item_id = :item_id
        ');
            $this->db->bind(':item_id', $item->item_id);
            $item->measurements = $this->db->resultSet();

            $this->db->query('
            SELECT oic.*, ct.name as customization_name, ct.name as display_name, cc.name  as option_name,cc.image as option_image
            FROM order_item_customizations oic
            JOIN customization_choices cc ON oic.choice_id = cc.choice_id
            JOIN customization_types ct ON oic.type_id = ct.type_id
            WHERE oic.item_id = :item_id
        ');
            $this->db->bind(':item_id', $item->item_id);
            $item->customizations = $this->db->resultSet();
        }

        return $order;
    }
    public function updateOrderStatus($data)
    {
        try {
            $this->db->beginTransaction();

            // Update the order status
            $this->db->query('UPDATE orders SET status = :status WHERE order_id = :order_id');
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->execute();

            // Also update the order items with the same status
            $this->db->query('UPDATE order_items SET status = :status WHERE order_id = :order_id');
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->execute();

            // Add entry to the status history
            $this->db->query('INSERT INTO order_status_history (order_id, status, updated_by, notes) 
                        VALUES (:order_id, :status, :updated_by, :notes)');
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':updated_by', $data['updated_by']);
            $this->db->bind(':notes', $data['notes']);
            $this->db->execute();

            $this->db->commitTransaction();
            return true;
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            return false;
        }
    }
    public function getRecentAppointments($tailorId, $status = null)
    {
        // Base query with future date filter
        $sql = "SELECT a.*, 
                  u.first_name as customer_first_name, 
                  u.last_name as customer_last_name,
                  a.created_at
                  FROM appointments a
                  JOIN users u ON a.customer_id = u.user_id
                  WHERE a.tailor_shopkeeper_id = :tailor_id";

        // Only add status filter if provided
        if ($status) {
            $sql .= " AND a.status = :status";
        }

        // Prioritize upcoming appointments first
        $sql .= " ORDER BY 
              CASE WHEN a.appointment_date >= CURDATE() THEN 0 ELSE 1 END, 
              a.appointment_date ASC, 
              a.appointment_time ASC 
              LIMIT 10";

        $this->db->query($sql);
        $this->db->bind(':tailor_id', $tailorId);

        if ($status) {
            $this->db->bind(':status', $status);
        }

        return $this->db->resultSet();
    }

    /**
     * Get recent orders with improved sorting
     */
    public function getRecentOrders($tailorId, $status = null)
    {
        $sql = "SELECT o.*,
                  CONCAT(u.first_name, ' ', u.last_name) as customer_name
                  FROM orders o
                  JOIN users u ON o.customer_id = u.user_id
                  WHERE o.tailor_id = :tailor_id";

        if ($status) {
            $sql .= " AND o.status = :status";
        }

        $sql .= " ORDER BY o.order_date DESC
              LIMIT 10";

        $this->db->query($sql);
        $this->db->bind(':tailor_id', $tailorId);

        if ($status) {
            $this->db->bind(':status', $status);
        }

        return $this->db->resultSet();
    }
}
