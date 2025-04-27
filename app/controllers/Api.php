<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Fabrics.php';
require_once APPROOT . '/helpers/FileUploader.php';

class Api extends Controller
{
    private $tailorModel;

    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');

        // Check if user is logged in as tailor
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        // Set content type to JSON
        header('Content-Type: application/json');
    }

    /**
     * Get recent orders for dashboard
     */
    public function getRecentOrders()
    {
        // Get tailor ID from session
        $tailorId = $_SESSION['user_id'];

        // Get all statuses for a more comprehensive dashboard view
        $orders = [];
        $statuses = ['order_placed', 'fabric_cutting', 'stitching', 'ready_for_delivery'];

        foreach ($statuses as $status) {
            $statusOrders = $this->tailorModel->getRecentOrders($tailorId, $status);
            $orders = array_merge($orders, $statusOrders);
        }

        // Sort by most recent
        usort($orders, function ($a, $b) {
            return strtotime($b->order_date) - strtotime($a->order_date);
        });

        // Return only the 5 most recent orders
        $orders = array_slice($orders, 0, 5);

        // Format data for the frontend
        $formattedOrders = [];
        foreach ($orders as $order) {
            $formattedOrders[] = [
                'order_id' => $order->order_id,
                'customer_name' => $order->customer_name,
                'order_date' => date('M d, Y', strtotime($order->order_date)),
                'total_amount' => $order->total_amount,
                'status' => $order->status
            ];
        }

        echo json_encode($formattedOrders);
    }

    /**
     * Get upcoming appointments for dashboard
     */
    public function getUpcomingAppointments()
    {
        // Get tailor ID from session
        $tailorId = $_SESSION['user_id'];

        // Get appointments with various statuses
        $appointments = [];
        $statuses = ['pending', 'accepted', 'confirmed'];

        foreach ($statuses as $status) {
            $statusAppointments = $this->tailorModel->getRecentAppointments($tailorId, $status);
            $appointments = array_merge($appointments, $statusAppointments);
        }

        // Filter to only upcoming appointments (today and future)
        $today = date('Y-m-d');
        $upcomingAppointments = array_filter($appointments, function ($appointment) use ($today) {
            return $appointment->appointment_date >= $today;
        });

        // Sort by date and time
        usort($upcomingAppointments, function ($a, $b) {
            $dateCompare = strtotime($a->appointment_date) - strtotime($b->appointment_date);
            if ($dateCompare === 0) {
                return strtotime($a->appointment_time) - strtotime($b->appointment_time);
            }
            return $dateCompare;
        });

        // Return only the 5 most recent appointments
        $upcomingAppointments = array_slice($upcomingAppointments, 0, 5);

        // Format data for the frontend
        $formattedAppointments = [];
        foreach ($upcomingAppointments as $appointment) {
            $formattedAppointments[] = [
                'appointment_id' => $appointment->appointment_id,
                'customer_name' => $appointment->customer_first_name . ' ' . $appointment->customer_last_name,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'status' => $appointment->status
            ];
        }

        echo json_encode($formattedAppointments);
    }
}
